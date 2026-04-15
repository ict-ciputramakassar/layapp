<?php

namespace App\Http\Controllers;

use App\Models\CategoryLevel;
use App\Models\CategoryAge;
use App\Models\EventRegistration;
use App\Models\EventRegistrationList;
use App\Models\CategoryGame;
use App\Models\CategoryType;
use App\Models\Event;
use App\Models\EventCategoryAge;
use App\Models\EventCategoryGame;
use App\Models\EventCategoryType;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function registerTeam(Request $request)
    {
        // Validasi data yang masuk dari Fetch API
        $request->validate([
            'event_id'   => 'required',
            'player_ids' => 'required|array|min:13|max:20',
        ]);

        // 1. Dapatkan User/Tim yang sedang login
        $user = Auth::user();
        $team = $user->team;

        $eventId   = $request->event_id;
        $playerIds = $request->player_ids;

        // 2. Ambil ID semua anggota tim yang valid dari relasi
        $validMemberIds = $team->teamMembers->pluck('id')->toArray();

        // 3. Filter: hanya player_ids yang benar-benar ada di dalam tim
        $validPlayerIds = array_values(
            array_filter($playerIds, fn($pid) => in_array($pid, $validMemberIds))
        );

        // 4. Periksa apakah jumlah yang valid
        if (count($validPlayerIds) < 13 || count($validPlayerIds) > 20) {
            return response()->json([
                'success' => false,
                'message' => 'Must Select Minimum of 13 Players and Maximum of 20 Players. '
                    . 'Found: ' . count($validPlayerIds) . ' Valid Players From Your Team.',
            ], 422);
        }

        // 5. Mulai DB Transaction
        DB::beginTransaction();
        try {

            // Buat data pendaftaran utama
            $registration = EventRegistration::create([
                'event_id' => $eventId,
                'team_id'  => $team->id,
                'created_by' => $user->id,
                'modified_by' => $user->id,
            ]);

            // Insert setiap pemain ke tabel detail
            foreach ($validPlayerIds as $pid) {
                EventRegistrationList::create([
                    'event_registration_id' => $registration->id,
                    'team_member_id' => $pid,
                    'created_by' => $user->id,
                    'modified_by' => $user->id,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran event berhasil!',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Event Registration Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function viewEventList()
    {
        // Default: bukan team leader
        $isTeamLeader = false;

        // Cek apakah user sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah relasi userType ada dan code-nya adalah 'TL'
            if ($user->userType && $user->userType->code === 'TL') {
                $isTeamLeader = true;
            }
        }

        // Lempar variabel ke view
        return view('views_frontend.events', [
            'isTeamLeader' => $isTeamLeader,
            'name' => $user->full_name ?? "",
        ]);
    }

    /**
     * Get events for frontend display
     */
    public function getEventsFrontend()
    {
        try {
            $events = Event::with(['eventCategoryAges.categoryAge', 'eventCategoryGames.categoryGame', 'eventCategoryTypes.categoryType'])
                ->orderBy('start_date', 'desc')
                ->get();

            $data = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->name,
                    'start_date' => $event->start_date ? date('d-m-Y', strtotime($event->start_date)) : '-',
                    'end_date' => $event->end_date ? date('d-m-Y', strtotime($event->end_date)) : '-',
                    'logo' => $event->eo_logo,
                    'description' => $event->description ?? '-',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getEventsFrontend:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching events',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getTeamPointsFrontend()
    {
        try {
            $teams = Team::all();

            $data = $teams->map(function ($team) {
                $eventRegistrations = $team->eventRegistrations;

                $play = $eventRegistrations->sum(fn($registration) => $registration->groupEvents->sum('play'));
                $win  = $eventRegistrations->sum(fn($registration) => $registration->groupEvents->sum('win'));
                $lose = $eventRegistrations->sum(fn($registration) => $registration->groupEvents->sum('lose'));

                return [
                    'id'    => $team->id,
                    'name'  => $team->name,
                    'image' => $team->image,
                    'points' => [
                        'play' => $play,
                        'win'  => $win,
                        'lose' => $lose,
                    ],
                ];
            });

            return response()->json([
                'success' => true,
                'teams' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getTeamPointsFrontend:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching points',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get events for DataTables server-side processing
     */
    public function getEventsData(Request $request)
    {
        try {
            $query = Event::with(['categoryLevel', 'eventCategoryAges.categoryAge', 'eventCategoryGames.categoryGame', 'eventCategoryTypes.categoryType']);

            // Global search
            if ($request->has('search') && !empty($request->search['value'])) {
                $search = $request->search['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('eo_name', 'like', "%{$search}%")
                        ->orWhereHas('categoryLevel', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            }

            $recordsFiltered = $query->count();
            $recordsTotal = Event::count();

            // Sorting
            if ($request->has('order') && count($request->order) > 0) {
                $order = $request->order[0];
                $columns = ['name', 'start_date', 'end_date', 'categoryLevel.name', 'eo_name', 'eo_logo'];

                if (isset($columns[$order['column']])) {
                    $orderColumn = $columns[$order['column']];
                    $orderDirection = $order['dir'] === 'desc' ? 'desc' : 'asc';

                    if (strpos($orderColumn, '.') !== false) {
                        $query->orderBy(explode('.', $orderColumn)[0], $orderDirection);
                    } else {
                        $query->orderBy($orderColumn, $orderDirection);
                    }
                }
            } else {
                $query->orderBy('created_date', 'desc');
            }

            // Pagination
            $start = $request->start ?? 0;
            $length = $request->length ?? 10;
            $events = $query->skip($start)->take($length)->get();

            $data = $events->map(function ($event) {
                $categoryAges = $event->eventCategoryAges->pluck('categoryAge.name')->join(', ');
                $categoryGames = $event->eventCategoryGames->pluck('categoryGame.name')->join(', ');
                $categoryTypes = $event->eventCategoryTypes->pluck('categoryType.name')->join(', ');

                return [
                    'id' => $event->id,
                    'logo' => $event->eo_logo ? asset('images/upload/' . $event->eo_logo) : '',
                    'name' => $event->name,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'category_level' => $event->categoryLevel?->name ?? '-',
                    'category_age' => $categoryAges ?: '-',
                    'category_game' => $categoryGames ?: '-',
                    'category_type' => $categoryTypes ?: '-',
                    'eo_name' => $event->eo_name,
                ];
            });

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getEventsData:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'draw' => intval($request->draw ?? 0),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('views_backend.event-list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryLevels = CategoryLevel::where('is_active', 1)->get();
        $categoryAges = CategoryAge::where('is_active', 1)->get();
        $categoryGames = CategoryGame::where('is_active', 1)->get();
        $categoryTypes = CategoryType::where('is_active', 1)->get();

        return view('views_backend.create-event', compact('categoryLevels', 'categoryAges', 'categoryGames', 'categoryTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'eventName' => 'required|string|max:255',
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
                'eventDescription' => 'nullable|string',
                'categoryLevel' => 'required|string|exists:m_category_level,id',
                'eoName' => 'required|string|max:255',
                'eoLogo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'categoryAge' => 'nullable|array',
                'categoryAge.*' => 'exists:m_category_age,id',
                'categoryGame' => 'nullable|array',
                'categoryGame.*' => 'exists:m_category_game,id',
                'categoryType' => 'nullable|array',
                'categoryType.*' => 'exists:m_category_type,id',
            ]);

            // Upload EO Logo
            $logoFile = null;
            if ($request->hasFile('eoLogo')) {
                $file = $request->file('eoLogo');
                $extension = $file->getClientOriginalExtension();
                $logoFile = Str::uuid() . '.' . $extension;
                $file->move(public_path('images/upload/events'), $logoFile);
            }

            // Create Event
            $userName = Auth::check() && Auth::user()->username ? Auth::user()->username : '-';
            $event = Event::create([
                'id' => Str::uuid(),
                'name' => $validated['eventName'],
                'start_date' => $validated['startDate'],
                'end_date' => $validated['endDate'],
                'description' => $validated['eventDescription'] ?? '-',
                'category_level_id' => $validated['categoryLevel'],
                'eo_name' => $validated['eoName'],
                'eo_logo' => $logoFile,
                'created_date' => now(),
                'created_by' => $userName,
                'modified_date' => now(),
                'modified_by' => $userName,
            ]);

            // Create EventCategoryAge relations
            if (!empty($validated['categoryAge'])) {
                foreach ($validated['categoryAge'] as $categoryAgeId) {
                    EventCategoryAge::create([
                        'id' => Str::uuid(),
                        'event_id' => $event->id,
                        'category_age_id' => $categoryAgeId,
                        'created_date' => now(),
                        'created_by' => $userName,
                        'modified_date' => now(),
                        'modified_by' => $userName,
                    ]);
                }
            }

            // Create EventCategoryGame relations
            if (!empty($validated['categoryGame'])) {
                foreach ($validated['categoryGame'] as $categoryGameId) {
                    EventCategoryGame::create([
                        'id' => Str::uuid(),
                        'event_id' => $event->id,
                        'category_game_id' => $categoryGameId,
                        'created_date' => now(),
                        'created_by' => $userName,
                        'modified_date' => now(),
                        'modified_by' => $userName,
                    ]);
                }
            }

            // Create EventCategoryType relations
            if (!empty($validated['categoryType'])) {
                foreach ($validated['categoryType'] as $categoryTypeId) {
                    EventCategoryType::create([
                        'id' => Str::uuid(),
                        'event_id' => $event->id,
                        'category_type_id' => $categoryTypeId,
                        'created_date' => now(),
                        'created_by' => $userName,
                        'modified_date' => now(),
                        'modified_by' => $userName,
                    ]);
                }
            }

            // Determine redirect route based on user role
            $userRole = Auth::user()->userType?->code;
            $redirectRoute = match ($userRole) {
                'SA' => 'superadmin.event-list',
                'A' => 'admin.event-list',
                default => 'admin.event-list',
            };

            return redirect()->route($redirectRoute)
                ->with('success', 'Event created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('views_backend.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categoryLevels = CategoryLevel::where('is_active', 1)->get();
        $categoryAges = CategoryAge::where('is_active', 1)->get();
        $categoryGames = CategoryGame::where('is_active', 1)->get();
        $categoryTypes = CategoryType::where('is_active', 1)->get();

        // Get selected IDs for multi-selects
        $selectedCategoryAges = EventCategoryAge::where('event_id', $event->id)
            ->pluck('category_age_id')
            ->toArray();
        $selectedCategoryGames = EventCategoryGame::where('event_id', $event->id)
            ->pluck('category_game_id')
            ->toArray();
        $selectedCategoryTypes = EventCategoryType::where('event_id', $event->id)
            ->pluck('category_type_id')
            ->toArray();

        return view('views_backend.edit-event', compact(
            'event',
            'categoryLevels',
            'categoryAges',
            'categoryGames',
            'categoryTypes',
            'selectedCategoryAges',
            'selectedCategoryGames',
            'selectedCategoryTypes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        try {
            $userName = Auth::check() && Auth::user()->username ? Auth::user()->username : '-';

            $validated = $request->validate([
                'eventName' => 'required|string|max:255',
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
                'eventDescription' => 'nullable|string',
                'categoryLevel' => 'required|string|exists:m_category_level,id',
                'eoName' => 'required|string|max:255',
                'eoLogo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'categoryAge' => 'nullable|array',
                'categoryAge.*' => 'exists:m_category_age,id',
                'categoryGame' => 'nullable|array',
                'categoryGame.*' => 'exists:m_category_game,id',
                'categoryType' => 'nullable|array',
                'categoryType.*' => 'exists:m_category_type,id',
            ]);

            $logoFile = $event->eo_logo;
            if ($request->hasFile('eoLogo')) {
                // Delete old file if exists
                if ($logoFile && file_exists(public_path('images/upload/' . $logoFile))) {
                    unlink(public_path('images/upload/events/' . $logoFile));
                }

                $file = $request->file('eoLogo');
                $logoFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/upload/events/'), $logoFile);
            }

            // Update Event
            $event->update([
                'name' => $validated['eventName'],
                'start_date' => $validated['startDate'],
                'end_date' => $validated['endDate'],
                'description' => $validated['eventDescription'] ?? null,
                'category_level_id' => $validated['categoryLevel'],
                'eo_name' => $validated['eoName'],
                'eo_logo' => $logoFile,
                'modified_date' => now(),
                'modified_by' => $userName,
            ]);

            // Delete and recreate EventCategoryAge relations
            EventCategoryAge::where('event_id', $event->id)->delete();
            if (!empty($validated['categoryAge'])) {
                foreach ($validated['categoryAge'] as $categoryAgeId) {
                    EventCategoryAge::create([
                        'id' => Str::uuid(),
                        'event_id' => $event->id,
                        'category_age_id' => $categoryAgeId,
                        'created_date' => now(),
                        'created_by' => $userName,
                        'modified_date' => now(),
                        'modified_by' => $userName,
                    ]);
                }
            }

            // Delete and recreate EventCategoryGame relations
            EventCategoryGame::where('event_id', $event->id)->delete();
            if (!empty($validated['categoryGame'])) {
                foreach ($validated['categoryGame'] as $categoryGameId) {
                    EventCategoryGame::create([
                        'id' => Str::uuid(),
                        'event_id' => $event->id,
                        'category_game_id' => $categoryGameId,
                        'created_date' => now(),
                        'created_by' => $userName,
                        'modified_date' => now(),
                        'modified_by' => $userName,
                    ]);
                }
            }

            // Delete and recreate EventCategoryType relations
            EventCategoryType::where('event_id', $event->id)->delete();
            if (!empty($validated['categoryType'])) {
                foreach ($validated['categoryType'] as $categoryTypeId) {
                    EventCategoryType::create([
                        'id' => Str::uuid(),
                        'event_id' => $event->id,
                        'category_type_id' => $categoryTypeId,
                        'created_date' => now(),
                        'created_by' => $userName,
                        'modified_date' => now(),
                        'modified_by' => $userName,
                    ]);
                }
            }

            // Determine redirect route based on user role
            $userRole = Auth::user()->userType?->code;
            $redirectRoute = match ($userRole) {
                'SA' => 'superadmin.event-list',
                'A' => 'admin.event-list',
                default => 'admin.event-list',
            };

            return redirect()->route($redirectRoute)
                ->with('success', 'Event updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            // Delete logo file
            if ($event->eo_logo && file_exists(public_path('images/upload/' . $event->eo_logo))) {
                unlink(public_path('images/upload/events/' . $event->eo_logo));
            }

            // Delete relations
            EventCategoryAge::where('event_id', $event->id)->delete();
            EventCategoryGame::where('event_id', $event->id)->delete();
            EventCategoryType::where('event_id', $event->id)->delete();

            // Delete event
            $event->delete();

            // Check if it's an AJAX request
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Event deleted successfully!'], 200);
            }

            // Determine redirect route based on user role
            $userRole = Auth::user()->userType?->code;
            $redirectRoute = match ($userRole) {
                'SA' => 'superadmin.event-list',
                'A' => 'admin.event-list',
                default => 'admin.event-list',
            };

            return redirect()->route($redirectRoute)
                ->with('success', 'Event deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Event Deletion Error: ' . $e->getMessage());

            // Check if it's an AJAX request
            if (request()->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return back()->with('error', 'Error deleting event: ' . $e->getMessage());
        }
    }
}
