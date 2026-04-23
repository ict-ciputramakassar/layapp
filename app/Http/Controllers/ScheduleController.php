<?php

namespace App\Http\Controllers;

use App\Models\GroupSchedule;
use App\Models\Team;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Frontend Home Page displaying fixtures and next match
     */
    public function frontendHome()
    {
        $now = now()->setTimezone('Asia/Makassar');

        // Next Match (1 nearest upcoming match)
        $nextMatch = GroupSchedule::with(['teamH', 'teamA', 'event'])
            ->where('play_date', '>=', $now)
            ->orderBy('play_date', 'asc')
            ->first();

        // Match Fixtures (5 upcoming schedules)
        $fixtures = GroupSchedule::with(['teamH', 'teamA', 'event'])
            ->where('play_date', '>=', $now)
            ->orderBy('play_date', 'asc')
            ->limit(5)
            ->get();

        // Get Group Data for the Carousel
        $groupGames = \App\Models\GroupGame::with(['groupEvents.eventRegistration.team'])->get();

        $groups = $groupGames->map(function ($group) {
            $teams = $group->groupEvents->map(function ($ge) {
                $team = $ge->eventRegistration->team ?? null;
                return [
                    'id'    => $team ? $team->id : null,
                    'name'  => $team ? $team->name : 'Unknown',
                    'image' => $team ? $team->image : '',
                    'points' => [
                        'play' => $ge->play,
                        'win'  => $ge->win,
                        'lose' => $ge->lose,
                        'draw' => $ge->draw,
                        'point' => $ge->point,
                    ],
                ];
            });

            // Sort by points descending
            $teams = $teams->sortByDesc('points.point')->values();

            return [
                'id'   => $group->id,
                'name' => $group->name,
                'teams' => $teams,
            ];
        })->filter(function ($group) {
            // Only include groups that have actual teams playing
            return $group['teams']->count() > 0;
        });

        return view('views_frontend.home', [
            'nextMatch' => $nextMatch,
            'fixtures' => $fixtures,
            'groups' => $groups
        ]);
    }

    /**
     * Show the schedule list view
     */
    public function index()
    {
        return view('views_backend.schedule-list');
    }

    /**
     * Show the schedule creation form
     */
    public function create()
    {
        $teams = Team::select('id', 'name')->where('is_active', 1)->get();
        $events = Event::select('id', 'name')->orderBy('start_date', 'desc')->get();

        return view('views_backend.create-schedule', [
            'teams' => $teams,
            'events' => $events,
        ]);
    }

    /**
     * Store schedules from form submission
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'event_id' => 'required|string|exists:m_event,id',
            'schedules' => 'required|array|min:1',
            'schedules.*.team_id_h' => 'required|string|exists:m_team,id',
            'schedules.*.team_id_a' => 'required|string|exists:m_team,id|different:schedules.*.team_id_h',
            'schedules.*.play_date' => 'required|date',
        ], [
            'schedules.*.team_id_h.different' => 'Team Home and Team Away must be different.',
            'schedules.*.team_id_a.exists' => 'Selected Team Away is invalid.',
        ]);

        DB::beginTransaction();
        try {
            $eventId = $request->event_id;
            $userId = Auth::id();

            foreach ($request->schedules as $schedule) {
                GroupSchedule::create([
                    'event_id' => $eventId,
                    'team_id_h' => $schedule['team_id_h'],
                    'team_id_a' => $schedule['team_id_a'],
                    'play_date' => $schedule['play_date'],
                    'score_h' => 0,
                    'score_a' => 0,
                    'created_date' => now(),
                    'created_by' => $userId,
                    'modified_date' => now(),
                    'modified_by' => $userId,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Schedules saved successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving schedules: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all schedules for the list view (with pagination/DataTable support)
     */
    public function list(Request $request)
    {
        $query = GroupSchedule::with(['teamH:id,name', 'teamA:id,name', 'event:id,name']);

        // Search
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->whereHas('event', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('teamH', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('teamA', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $total = $query->count();

        // Sorting
        if ($request->has('order') && count($request->order) > 0) {
            $order = $request->order[0];
            $columns = [
                0 => 'event_name',
                1 => 'team_home',
                2 => 'team_away',
                3 => 'score_h',
                4 => 'score_a',
                5 => 'play_date'
            ];

            if (isset($columns[$order['column']])) {
                $orderColumn = $columns[$order['column']];
                $orderDirection = $order['dir'] === 'desc' ? 'desc' : 'asc';

                // Map logical columns to database foreign keys for relational sorting
                switch ($orderColumn) {
                    case 'event_name':
                        $query->orderBy('event_id', $orderDirection);
                        break;
                    case 'team_home':
                        $query->orderBy('team_id_h', $orderDirection);
                        break;
                    case 'team_away':
                        $query->orderBy('team_id_a', $orderDirection);
                        break;
                    default:
                        $query->orderBy($orderColumn, $orderDirection);
                        break;
                }
            }
        } else {
            $query->orderBy('play_date', 'desc');
        }

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $schedules = $query->offset($start)
            ->limit($length)
            ->get();

        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'event_name' => $schedule->event?->name ?? 'N/A',
                    'team_home' => $schedule->teamH?->name ?? 'N/A',
                    'team_away' => $schedule->teamA?->name ?? 'N/A',
                    'score_h' => $schedule->score_h,
                    'score_a' => $schedule->score_a,
                    'play_date' => $schedule->play_date->format('Y-m-d H:i'),
                    'created_by' => $schedule->created_by,
                    'created_date' => $schedule->created_date->format('Y-m-d H:i'),
                ];
            })
        ]);
    }

    /**
     * Get single schedule for editing
     */
    public function edit($id)
    {
        $schedule = GroupSchedule::with(['teamH:id,name', 'teamA:id,name', 'event:id,name'])->findOrFail($id);
        $events = Event::select('id', 'name')->orderBy('start_date', 'desc')->get();
        $teams = Team::select('id', 'name')->where('is_active', 1)->get();

        return view('views_backend.edit-schedule', [
            'schedule' => $schedule,
            'events' => $events,
            'teams' => $teams,
        ]);
    }

    /**
     * Update schedule
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required|string|exists:m_event,id',
            'team_id_h' => 'required|string|exists:m_team,id',
            'team_id_a' => 'required|string|exists:m_team,id|different:team_id_h',
            'play_date' => 'required|date',
        ]);

        try {
            $schedule = GroupSchedule::findOrFail($id);

            $schedule->update([
                'event_id' => $request->event_id,
                'team_id_h' => $request->team_id_h,
                'team_id_a' => $request->team_id_a,
                'play_date' => $request->play_date,
                'modified_date' => now(),
                'modified_by' => Auth::id(),
            ]);

            return redirect()->route('schedule-list')->with('success', 'Schedule updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error updating schedule: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete schedule
     */
    public function destroy($id)
    {
        try {
            $schedule = GroupSchedule::findOrFail($id);
            $schedule->delete();

            return response()->json([
                'success' => true,
                'message' => 'Schedule deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting schedule: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get teams and events for AJAX dropdowns
     */
    public function getTeamsAndEvents()
    {
        $teams = Team::select('id', 'name')->where('is_active', 1)->get();
        $events = Event::select('id', 'name')->orderBy('start_date', 'desc')->get();

        return response()->json([
            'teams' => $teams,
            'events' => $events,
        ]);
    }
}
