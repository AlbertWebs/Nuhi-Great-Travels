<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Start query for leads belonging to the current user
        $query = Lead::where('user_id', $user->id);

        // Apply status filter if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Order by latest and paginate
        $leads = $query->orderBy('created_at', 'desc')->paginate(20);

        // Preserve query parameters in pagination links
        $leads->appends($request->only('status'));

        return view('leads.index', compact('leads'));
    }


    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:50',
                'company' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
                'task_id' => 'nullable|exists:tasks,id',
            ]);

            $lead = $request->user()->leads()->create($data);

            // Optionally mark task completed if task_id passed
            if (!empty($data['task_id'])) {
                $task = Task::find($data['task_id']);
                if ($task && $task->user_id === $request->user()->id) {
                    // Task linking logic if needed
                }
            }

            if ($request->wantsJson()) {
                return response()->json(['ok' => true, 'lead' => $lead], 201);
            }

            return redirect()->back()->with('success', 'Lead saved successfully.');
        } catch (ValidationException $e) {
            Log::warning('Lead validation failed', [
                'user_id' => $request->user()->id ?? null,
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Failed to save lead', [
                'user_id' => $request->user()->id ?? null,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to save lead: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Request $request, Lead $lead)
    {
        $this->authorize('view', $lead);
        return view('leads.show', compact('lead'));
    }

    public function updateStatus(Request $request, Lead $lead)
        {
            $request->validate([
                'status' => 'required|in:new,contacted,qualified,lost,converted',
            ]);

            $lead->update([
                'status' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Lead status updated successfully!');
        }


}
