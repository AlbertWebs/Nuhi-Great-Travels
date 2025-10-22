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

        // upcoming tasks for today + incomplete tasks
        $today = now()->toDateString();
        $tasksToday = Task::where('user_id', $user->id)
            ->whereDate('planned_date', $today)
            ->orderBy('planned_time')
            ->get();

        $incompleteTasks = Task::where('user_id', $user->id)
            ->where('is_completed', false)
            ->orderBy('planned_date')
            ->limit(10)
            ->get();

        $recentLeads = Lead::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('tasksToday','incompleteTasks','recentLeads'));
    }
}
