<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Lead;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        // --- Tasks Today ---
        $tasksToday = Task::where('user_id', $user->id)
            ->whereDate('planned_date', $today)
            ->orderBy('planned_time')
            ->get();

        // --- Incomplete Tasks ---
        $incompleteTasks = Task::where('user_id', $user->id)
            ->where('is_completed', false)
            ->orderBy('planned_date')
            ->limit(10)
            ->get();

        // --- Recent Leads ---
        $recentLeads = Lead::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // --- Chart Data: Task Completion ---
        $taskStats = [
            'completed' => Task::where('user_id', $user->id)->where('is_completed', true)->count(),
            'pending'   => Task::where('user_id', $user->id)->where('is_completed', false)->count(),
        ];

        // --- Chart Data: Leads Growth (last 7 days) ---
        $leadStats = Lead::where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit(7)
            ->get();

        return view('dashboard.index', compact(
            'tasksToday',
            'incompleteTasks',
            'recentLeads',
            'taskStats',
            'leadStats'
        ));
    }




    public function indexs()
    {
        $tasksToday = Task::whereDate('planned_date', today())
                        ->where('user_id', auth()->id())
                        ->get();

        $recentLeads = Lead::where('user_id', auth()->id())
                        ->latest()
                        ->take(5)
                        ->get();

        $taskStats = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'completed' => [3, 5, 4, 6, 2, 0, 1],
            'pending' => [1, 2, 1, 0, 3, 2, 1],
        ];

        $leadStats = [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            'count' => [4, 7, 5, 9],
        ];

        return view('dashboard.index', compact('tasksToday', 'recentLeads', 'taskStats', 'leadStats'));
    }
}


