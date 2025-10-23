<div id="leadModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 hidden">
  <div class="bg-white p-6 rounded w-full max-w-lg">
    <h3 class="text-lg font-semibold mb-4">Log Lead</h3>
    <form action="{{ route('leads.store') }}" method="POST" class="space-y-3">
      @csrf
      <input type="hidden" name="latitude" id="latitude">
      <input type="hidden" name="longitude" id="longitude">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-sm">Name</label>
          <input name="name" required class="mt-1 w-full border rounded px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm">Phone</label>
          <input name="phone" class="mt-1 w-full border rounded px-3 py-2" />
        </div>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-sm">Email</label>
          <input name="email" type="email" class="mt-1 w-full border rounded px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm">Company</label>
          <input name="company" class="mt-1 w-full border rounded px-3 py-2" />
        </div>
      </div>

      <div>
        <label class="block text-sm">Notes</label>
        <textarea name="notes" class="mt-1 w-full border rounded px-3 py-2"></textarea>
      </div>

      <div>
        <label class="block text-sm">Attach to Task (optional)</label>
        <select name="task_id" class="mt-1 w-full border rounded px-3 py-2">
          <option value="">-- none --</option>
          @foreach(auth()->user()->tasks()->latest()->limit(20)->get() as $t)
            <option value="{{ $t->id }}">{{ $t->title }} {{ $t->planned_date ? '('.$t->planned_date->format('Y-m-d').')' : '' }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="document.getElementById('leadModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white">Save Lead</button>
      </div>
    </form>
  </div>
</div>
