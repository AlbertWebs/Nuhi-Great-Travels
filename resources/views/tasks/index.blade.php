@extends('layouts.app-layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">My Tasks</h1>
    <button id="newTaskBtn" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
      + New Task
    </button>
  </div>

  <!-- Tasks Table -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Done</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Planned Time</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse ($tasks as $task)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <input type="checkbox"
                     class="task-toggle rounded border-gray-300"
                     data-id="{{ $task->id }}"
                     {{ $task->is_completed ? 'checked' : '' }}>
            </td>

            <td class="px-6 py-4">
              <div class="font-medium {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                {{ $task->title }}
              </div>
            </td>

            <td class="px-6 py-4 text-sm text-gray-500">
              {{ $task->notes ?? '—' }}
            </td>

            <td class="px-6 py-4 text-sm text-gray-500">
              {{ $task->planned_time ?? '—' }}
            </td>

            <td class="px-6 py-4 text-right text-sm">
              <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No tasks yet. Add one above!</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $tasks->links() }}
  </div>
</div>

<!-- Task Modal -->
<div id="taskModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white rounded shadow-lg w-full max-w-md p-6">
    <h2 class="text-xl font-semibold mb-4">Create New Task</h2>

    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Notes</label>
        <textarea name="notes" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Planned Time (optional)</label>
        <input type="time" name="planned_time" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <div class="flex justify-end space-x-3">
        <button type="button" id="closeTaskModal" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Task</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const newTaskBtn = document.getElementById('newTaskBtn');
  const taskModal = document.getElementById('taskModal');
  const closeTaskModal = document.getElementById('closeTaskModal');

  // Show modal
  if (newTaskBtn && taskModal && closeTaskModal) {
    newTaskBtn.addEventListener('click', () => taskModal.classList.remove('hidden'));
    closeTaskModal.addEventListener('click', () => taskModal.classList.add('hidden'));
  }

  // Toggle complete
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
      })
      .then(res => res.json())
      .catch(err => console.error(err));
    });
  });
});
</script>
@endsection
