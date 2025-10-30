@extends('layouts.app-layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  <!-- Welcome -->
  <h1 class="text-2xl sm:text-3xl font-bold mb-8 text-yellow-600 text-center sm:text-left">
    Welcome Back, {{ Auth::user()->name }}!
  </h1>

  <!-- Alerts -->
  @if (session('success'))
      <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
          {{ session('success') }}
      </div>
  @endif

  @if ($errors->any())
      <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
          <strong>Oops! Please fix the following errors:</strong>
          <ul class="list-disc pl-5 mt-2">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  

  <!-- Tasks & Leads -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Today's Tasks -->
      <div class="md:col-span-2 bg-white shadow-lg rounded-xl p-6">
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
              <h2 class="text-xl font-semibold text-gray-800 mb-3 sm:mb-0">Today's Tasks</h2>
              <button id="newTaskBtn" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition w-full sm:w-auto">
                  + New Task
              </button>
          </div>

          <div class="space-y-4">
              @forelse($tasksToday as $task)
                  <div class="flex items-start justify-between p-4 border rounded-lg hover:shadow-md hover:bg-yellow-50 transition">
                      <div class="flex items-center gap-4">
                          <input type="checkbox" class="task-toggle h-6 w-6 text-yellow-500 border-gray-300 rounded"
                                 data-id="{{ $task->id }}" {{ $task->is_completed ? 'checked' : '' }}>
                          <div>
                              <div class="font-medium {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-900' }} break-words">
                                  {{ $task->title }}
                              </div>
                              <div class="text-sm text-gray-500 break-words">{{ $task->notes }}</div>
                          </div>
                      </div>
                      <div class="text-sm text-gray-400 shrink-0">{{ $task->planned_time ?? '--' }}</div>
                  </div>
              @empty
                  <div class="text-gray-500 italic text-center py-4">No tasks for today. Add one!</div>
              @endforelse
          </div>
      </div>

      <!-- Recent Leads -->
      <div class="bg-white shadow-lg rounded-xl p-6">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Leads</h2>
          <div class="space-y-4">
              @forelse($recentLeads as $lead)
                  <a href="{{ route('leads.show', $lead) }}"
                     class="block p-4 border rounded-lg hover:shadow-md hover:bg-yellow-50 transition">
                      <div class="font-medium text-gray-900 break-words">{{ $lead->name }}</div>
                      <div class="text-sm text-gray-500 break-words">{{ $lead->company ?? $lead->phone }}</div>
                      <div class="text-xs text-gray-400">{{ $lead->created_at->diffForHumans() }}</div>
                  </a>
              @empty
                  <div class="text-gray-500 italic text-center py-4">No leads yet.</div>
              @endforelse
          </div>
          <div class="mt-6 text-right">
              <a href="{{ route('leads.index') }}" class="text-yellow-500 hover:text-yellow-600 font-medium transition">
                  View all leads →
              </a>
          </div>
      </div>
  </div>

  <hr>

</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <!-- Charts -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <!-- Task Completion Chart -->
      <div class="bg-white shadow-lg rounded-xl p-6">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Task Completion Overview</h2>
          @if(($taskStats['completed'] + $taskStats['pending']) > 0)
              <canvas id="taskChart" height="150"></canvas>
          @else
              <p class="text-gray-500 italic text-center mt-4">No task data available.</p>
          @endif
      </div>

      <!-- Leads Trend Chart -->
      <div class="bg-white shadow-lg rounded-xl p-6">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Leads Trend (Last 7 Days)</h2>
          @if($leadStats->count() > 0)
              <canvas id="leadChart" height="150"></canvas>
          @else
              <p class="text-gray-500 italic text-center mt-4">No leads data available.</p>
          @endif
      </div>
  </div>
</div>

<!-- Create Task Modal -->
<div id="taskModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
      <h2 class="text-2xl font-semibold mb-6 text-yellow-600">Create New Task</h2>
      <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
          @csrf
          <div>
              <label class="block text-sm font-medium text-gray-700">Title</label>
              <input type="text" name="title" value="{{ old('title') }}" required
                     class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700">Notes</label>
              <textarea name="notes" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">{{ old('notes') }}</textarea>
          </div>
          <div class="flex flex-col sm:flex-row gap-4">
              <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-700">Planned Date</label>
                  <input type="date" name="planned_date" value="{{ old('planned_date') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
              </div>
              <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-700">Planned Time</label>
                  <input type="time" name="planned_time" value="{{ old('planned_time') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
              </div>
          </div>
          <div class="flex justify-end gap-3">
              <button type="button" id="closeTaskModal" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Cancel</button>
              <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Save</button>
          </div>
      </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newTaskBtn = document.getElementById('newTaskBtn');
    const taskModal = document.getElementById('taskModal');
    const closeTaskModal = document.getElementById('closeTaskModal');

    if (newTaskBtn && taskModal && closeTaskModal) {
        newTaskBtn.addEventListener('click', () => taskModal.classList.remove('hidden'));
        closeTaskModal.addEventListener('click', () => taskModal.classList.add('hidden'));
    }

    // Toggle completion
    document.querySelectorAll('.task-toggle').forEach(cb => {
        cb.addEventListener('change', function() {
            const id = this.dataset.id;
            fetch(`/tasks/${id}/toggle`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            }).then(res => res.json()).catch(err => console.error(err));
        });
    });

    // --- Charts ---
    const taskData = @json($taskStats);
    const leadData = @json($leadStats);

    if (taskData && (taskData.completed > 0 || taskData.pending > 0)) {
        new Chart(document.getElementById('taskChart'), {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [taskData.completed, taskData.pending],
                    backgroundColor: ['#facc15', '#fef08a'],
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    }

    if (leadData && leadData.length > 0) {
        new Chart(document.getElementById('leadChart'), {
            type: 'line',
            data: {
                labels: leadData.map(d => d.date),
                datasets: [{
                    label: 'Leads Created',
                    data: leadData.map(d => d.total),
                    borderColor: '#facc15',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    }
});
</script>
@endsection
