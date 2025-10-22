<div id="taskModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden">
  <div class="bg-white p-6 rounded w-full max-w-md">
    <h3 class="text-lg font-semibold mb-4">New Task</h3>
    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-3">
      @csrf
      <div>
        <label class="block text-sm">Title</label>
        <input name="title" required class="mt-1 w-full border rounded px-3 py-2" />
      </div>
      <div>
        <label class="block text-sm">Notes</label>
        <textarea name="notes" class="mt-1 w-full border rounded px-3 py-2"></textarea>
      </div>
      <div class="grid grid-cols-2 gap-2">
        <div>
          <label class="block text-sm">Planned Date</label>
          <input name="planned_date" type="date" class="mt-1 w-full border rounded px-3 py-2"/>
        </div>
        <div>
          <label class="block text-sm">Time</label>
          <input name="planned_time" type="time" class="mt-1 w-full border rounded px-3 py-2"/>
        </div>
      </div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="document.getElementById('taskModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white">Save</button>
      </div>
    </form>
  </div>
</div>
