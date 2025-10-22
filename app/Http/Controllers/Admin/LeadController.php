<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.leads.index', compact('leads'));
    }

    public function create()
    {
        $tasks = Task::orderBy('planned_date')->get(); // Optional: link lead to task
        return view('admin.leads.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'task_id' => 'nullable|exists:tasks,id',
        ]);

        try {
            $lead = Lead::create($data);

            // Optional: link task if needed
            if (!empty($data['task_id'])) {
                $task = Task::find($data['task_id']);
                if ($task) {
                    // You could mark task as completed or relate it
                }
            }

            return redirect()->back()->with('success', 'Lead created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create lead', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Failed to create lead: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function destroy(Lead $lead)
    {
        try {
            $lead->delete();
            return redirect()->back()->with('success', 'Lead deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete lead', [
                'lead_id' => $lead->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete lead: ' . $e->getMessage());
        }
    }
}
