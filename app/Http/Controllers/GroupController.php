<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\GroupGame;
use App\Models\GroupEvent;
use App\Models\Event;
use App\Models\EventRegistration;

use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        return view("views_backend.group-list");
    }

    public function create()
    {
        $groupGames = GroupGame::all();

        // Get only events that have registrations
        $registeredEventIds = EventRegistration::pluck('event_id')->unique();
        $events = Event::whereIn('id', $registeredEventIds)->get(['id', 'name']);

        // Get only teams that have registered for an event
        $registeredTeamIds = EventRegistration::pluck('team_id')->unique();
        $teams = Team::whereIn('id', $registeredTeamIds)->get(['id', 'name']);

        return view("views_backend.create-group", [
            "groupGames" => $groupGames,
            "teams" => $teams,
            "events" => $events,
            "score" => new GroupEvent(),
            "schedule" => new GroupEvent(),
            "isEdit" => false
        ]);
    }

    public function edit($id)
    {
        $groupEvent = GroupEvent::with("eventRegistration")->findOrFail($id);
        $groupGames = GroupGame::all();

        // Get only events that have registrations
        $registeredEventIds = EventRegistration::pluck('event_id')->unique();
        $events = Event::whereIn('id', $registeredEventIds)->get(['id', 'name']);

        // Get only teams that have registered for an event
        $registeredTeamIds = EventRegistration::pluck('team_id')->unique();
        $teams = Team::whereIn('id', $registeredTeamIds)->get(['id', 'name']);

        return view("views_backend.edit-group", [
            "groupEvent" => $groupEvent,
            "score" => $groupEvent,
            "schedule" => $groupEvent,
            "groupGames" => $groupGames,
            "teams" => $teams,
            "events" => $events,
            "isEdit" => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $groupEvent = GroupEvent::findOrFail($id);

        // Simple validation
        $validated = $request->validate([
            "event_id" => "required|exists:m_event,id",
            "team_id" => "required|exists:m_team,id",
            "group_game_id" => "required|exists:m_group_game,id",
            "play" => "required|numeric|min:0",
            "win" => "required|numeric|min:0",
            "lose" => "required|numeric|min:0",
            "draw" => "required|numeric|min:0",
            "point" => "required|numeric|min:0",
        ]);

        try {
            $eventRegistration = EventRegistration::firstOrCreate(
                [
                    "event_id" => $validated["event_id"],
                    "team_id" => $validated["team_id"],
                ],
                [
                    "created_by" => Auth::id() ?? "-",
                    "created_date" => now(),
                    "modified_by" => Auth::id() ?? "-",
                    "modified_date" => now(),
                ]
            );

            $groupEvent->update([
                "event_registration_id" => $eventRegistration->id,
                "group_game_id" => $validated["group_game_id"],
                "play" => $validated["play"],
                "win" => $validated["win"],
                "lose" => $validated["lose"],
                "draw" => $validated["draw"],
                "point" => $validated["point"],
                "modified_by" => Auth::id() ?? "-",
                "modified_date" => now(),
            ]);

            return redirect()->route("group-list")->with("success", "Group updated successfully");
        } catch (\Exception $e) {
            Log::error("Error updating group:", ["message" => $e->getMessage()]);
            return back()->with("error", "Error updating group: " . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $groupEvent = GroupEvent::findOrFail($id);
            $groupEvent->delete();

            return response()->json([
                "success" => true,
                "message" => "Group deleted successfully"
            ]);
        } catch (\Exception $e) {
            Log::error("Error deleting group:", ["message" => $e->getMessage()]);
            return response()->json([
                "success" => false,
                "message" => "Error deleting group"
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "event_id" => "required|exists:m_event,id",
            "team_id" => "required|exists:m_team,id",
            "group_game_id" => "required|exists:m_group_game,id",
            "play" => "required|numeric|min:0",
            "win" => "required|numeric|min:0",
            "lose" => "required|numeric|min:0",
            "draw" => "required|numeric|min:0",
            "point" => "required|numeric|min:0",
        ]);

        try {
            $eventRegistration = EventRegistration::firstOrCreate(
                [
                    "event_id" => $validated["event_id"],
                    "team_id" => $validated["team_id"],
                ],
                [
                    "created_by" => Auth::id() ?? "-",
                    "created_date" => now(),
                    "modified_by" => Auth::id() ?? "-",
                    "modified_date" => now(),
                ]
            );

            GroupEvent::create([
                "event_registration_id" => $eventRegistration->id,
                "group_game_id" => $validated["group_game_id"],
                "play" => $validated["play"],
                "win" => $validated["win"],
                "lose" => $validated["lose"],
                "draw" => $validated["draw"],
                "point" => $validated["point"],
                "created_by" => Auth::id() ?? "-",
                "created_date" => now(),
                "modified_by" => Auth::id() ?? "-",
                "modified_date" => now(),
            ]);

            return redirect()->route("group-list")->with("success", "Group created successfully");
        } catch (\Exception $e) {
            Log::error("Error creating group:", ["message" => $e->getMessage()]);
            return back()->with("error", "Error creating group: " . $e->getMessage());
        }
    }

    public function getTeamPointsFrontend()
    {
        try {
            $groupGames = \App\Models\GroupGame::with(["groupEvents.eventRegistration.team"])->get();

            $data = $groupGames->map(function ($group) {
                $teams = $group->groupEvents->map(function ($ge) {
                    $team = $ge->eventRegistration->team;
                    return [
                        "id"    => $team ? $team->id : null,
                        "name"  => $team ? $team->name : "Unknown",
                        "image" => $team ? $team->image : "",
                        "points" => [
                            "play" => $ge->play,
                            "win"  => $ge->win,
                            "lose" => $ge->lose,
                            "draw" => $ge->draw,
                            "point" => $ge->point,
                        ],
                    ];
                });

                $teams = $teams->sortByDesc("points.point")->values();

                return [
                    "id"   => $group->id,
                    "name" => $group->name,
                    "teams" => $teams,
                ];
            });

            return response()->json([
                "success" => true,
                "groups" => $data,
            ]);
        } catch (\Exception $e) {
            Log::error("Error in getTeamPointsFrontend:", ["message" => $e->getMessage()]);
            return response()->json([
                "success" => false,
                "message" => "Error fetching points",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function getGroupsData(Request $request)
    {
        try {
            $query = GroupEvent::query()->with([
                "eventRegistration.event",
                "eventRegistration.team",
                "groupGame"
            ]);

            // Global search
            if ($request->has('search') && !empty($request->search['value'])) {
                $search = $request->search['value'];
                $query->where(function ($q) use ($search) {
                    $q->whereHas('groupGame', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('eventRegistration.event', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('eventRegistration.team', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            }

            $recordsFiltered = $query->count();
            $recordsTotal = GroupEvent::count();

            // Pagination
            $start = $request->start ?? 0;
            $length = $request->length ?? 10;
            $groupEvents = $query->skip($start)->take($length)->get();

            $data = $groupEvents->map(function ($row) {
                $editUrl = route('group.edit', $row->id);
                return [
                    'group_game_name' => $row->groupGame ? $row->groupGame->name : 'N/A',
                    'event_name' => $row->eventRegistration && $row->eventRegistration->event
                        ? $row->eventRegistration->event->name
                        : 'N/A',
                    'team_name' => $row->eventRegistration && $row->eventRegistration->team
                        ? $row->eventRegistration->team->name
                        : 'N/A',
                    'play' => $row->play,
                    'win' => $row->win,
                    'lose' => $row->lose,
                    'draw' => $row->draw,
                    'point' => $row->point,
                    'action' => '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-edit"></i> Edit
                        </a>
                        <a href="javascript:void(0);" onclick="deleteGroup(\'' . $row->id . '\')" class="btn btn-sm btn-outline-danger">
                            <i class="ti ti-trash"></i> Delete
                        </a>
                    ',
                ];
            });

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error("Error in getGroupsData:", ["message" => $e->getMessage()]);
            return response()->json([
                'draw' => intval($request->draw ?? 0),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
