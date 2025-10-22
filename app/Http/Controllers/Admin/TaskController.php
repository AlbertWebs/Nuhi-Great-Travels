<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $query = Task::with('user');

    if ($request->filled('status')) {
        if ($request->status === 'completed') {
            $query->where('is_completed', true);
        } elseif ($request->status === 'not_completed') {
            $query->where('is_completed', false);
        }
    }

    $tasks = $query->orderBy('planned_date', 'desc')->paginate(20);

    return view('admin.tasks.index', compact('tasks'));
}

    public function create()
    {
        return view('admin.tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'planned_date' => 'nullable|date',
            'planned_time' => 'nullable|date_format:H:i',
        ]);

        try {
            Task::create($data);
            return redirect()->back()->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create task', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Failed to create task: ' . $e->getMessage())->withInput();
        }
    }

    public function toggle(Task $task)
    {
        try {
            $task->is_completed = !$task->is_completed;
            $task->completed_at = $task->is_completed ? now() : null;
            $task->save();

            return redirect()->back()->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to toggle task', [
                'task_id' => $task->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Failed to update task: ' . $e->getMessage());
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return redirect()->back()->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete task', [
                'task_id' => $task->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete task: ' . $e->getMessage());
        }
    }
}
