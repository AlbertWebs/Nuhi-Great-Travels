<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a paginated list of tasks for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $tasks = Task::where('user_id', $user->id)
            ->orderBy('planned_date', 'asc')
            ->orderBy('planned_time', 'asc')
            ->paginate(20);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Store a new task.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'notes' => 'nullable|string',
                'planned_date' => 'nullable|date',
                'planned_time' => 'nullable|date_format:H:i',
            ]);

            $task = $request->user()->tasks()->create($data);

            Log::info('Task created successfully', [
                'user_id' => $request->user()->id,
                'task_id' => $task->id
            ]);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Task created.', 'task' => $task]);
            }

            return redirect()->back()->with('success', 'Task created.');
        } catch (ValidationException $e) {
            Log::warning('Task validation failed', [
                'user_id' => $request->user()->id ?? null,
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Failed to create task', [
                'user_id' => $request->user()->id ?? null,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to create task: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle the completion status of a task.
     */
    public function toggle(Request $request, Task $task)
    {
        try {
            if ($request->user()->id !== $task->user_id) {
                throw new HttpException(403, 'Forbidden');
            }

            $task->is_completed = !$task->is_completed;
            $task->completed_at = $task->is_completed ? now() : null;
            $task->save();

            Log::info('Task toggled', [
                'user_id' => $request->user()->id,
                'task_id' => $task->id,
                'is_completed' => $task->is_completed
            ]);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'is_completed' => $task->is_completed]);
            }

            return redirect()->back()->with('success', 'Task updated.');
        } catch (HttpException $e) {
            Log::warning('Unauthorized toggle attempt', [
                'user_id' => $request->user()->id ?? null,
                'task_id' => $task->id,
                'message' => $e->getMessage()
            ]);
            abort($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to toggle task', [
                'user_id' => $request->user()->id ?? null,
                'task_id' => $task->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to toggle task: ' . $e->getMessage());
        }
    }

    /**
     * Delete a task.
     */
    public function destroy(Request $request, Task $task)
    {
        try {
            if ($request->user()->id !== $task->user_id) {
                throw new HttpException(403, 'Forbidden');
            }

            $task->delete();

            Log::info('Task deleted', [
                'user_id' => $request->user()->id,
                'task_id' => $task->id
            ]);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Task deleted.']);
            }

            return redirect()->back()->with('success', 'Task deleted.');
        } catch (HttpException $e) {
            Log::warning('Unauthorized delete attempt', [
                'user_id' => $request->user()->id ?? null,
                'task_id' => $task->id,
                'message' => $e->getMessage()
            ]);
            abort($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to delete task', [
                'user_id' => $request->user()->id ?? null,
                'task_id' => $task->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to delete task: ' . $e->getMessage());
        }
    }
}
