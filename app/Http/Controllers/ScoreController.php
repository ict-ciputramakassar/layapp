<?php

namespace App\Http\Controllers;

use App\Models\GroupSchedule;
use App\Models\Team;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    /**
     * Show the score list view
     */
    public function index()
    {
        return view('views_backend.score-list');
    }

    /**
     * Get all scores for the list view (with pagination/DataTable support)
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
     * Get single score for editing
     */
    public function edit($id)
    {
        $score = GroupSchedule::with(['teamH:id,name', 'teamA:id,name', 'event:id,name'])->findOrFail($id);
        $events = Event::orderBy('name')->get(['id', 'name']);
        $teams = Team::orderBy('name')->get(['id', 'name']);

        return view('views_backend.edit-score', [
            'score' => $score,
            'events' => $events,
            'teams' => $teams,
        ]);
    }

    /**
     * Update score
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'score_h' => 'required|integer|min:0',
            'score_a' => 'required|integer|min:0',
        ]);

        try {
            $score = GroupSchedule::findOrFail($id);

            $score->update([
                'score_h' => $request->score_h,
                'score_a' => $request->score_a,
                'modified_date' => now(),
                'modified_by' => Auth::id(),
            ]);

            return redirect()->route('score-list')->with('success', 'Score updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error updating score: ' . $e->getMessage()]);
        }
    }
}
