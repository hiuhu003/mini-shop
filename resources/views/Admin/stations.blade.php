@extends('admin.layout')

@section('title','Pickup Stations')

@section('content')
  <header class="border-b border-white/10 px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <h1 class="text-xl font-bold">Pickup Stations</h1>

      <div class="flex items-center gap-2">
        <button type="button"
                class="inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-black hover:bg-red-500"
                data-store-url="{{ route('admin.stations.store') }}"
                onclick="openStationModalForCreate(this)">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
          New Station
        </button>
      </div>
    </div>

    {{-- Filters + search --}}
    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div class="flex flex-wrap items-center gap-2">
        @php $status = $status ?? request('status'); @endphp
        <a href="{{ route('admin.stations.index') }}"
           class="rounded-full border px-3 py-1.5 text-sm
           {{ !$status ? 'border-red-600 bg-red-600 text-black' : 'border-white/20 hover:bg-white/10' }}">
          All
        </a>
        <a href="{{ route('admin.stations.index', ['status' => 'active'] + request()->except('page')) }}"
           class="rounded-full border px-3 py-1.5 text-sm
           {{ $status === 'active' ? 'border-red-600 bg-red-600 text-black' : 'border-white/20 hover:bg-white/10' }}">
          Active
        </a>
        <a href="{{ route('admin.stations.index', ['status' => 'inactive'] + request()->except('page')) }}"
           class="rounded-full border px-3 py-1.5 text-sm
           {{ $status === 'inactive' ? 'border-red-600 bg-red-600 text-black' : 'border-white/20 hover:bg-white/10' }}">
          Inactive
        </a>
      </div>

      <form method="GET" action="{{ route('admin.stations.index') }}" class="w-full sm:w-auto">
        <div class="relative">
          <input
            type="text"
            name="q"
            value="{{ $q ?? request('q') }}"
            placeholder="Search name / address / city…"
            class="w-full sm:w-80 rounded-lg bg-white text-red-900 placeholder:text-red-800/60 border border-red-200 px-3 py-2 pr-9 focus:outline-none focus:ring-2 focus:ring-red-400"
          />
          @if($status)
            <input type="hidden" name="status" value="{{ $status }}">
          @endif
          <button class="absolute inset-y-0 right-0 grid w-9 place-items-center" aria-label="Search">
            <svg class="h-5 w-5 text-red-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.1-4.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
            </svg>
          </button>
        </div>
      </form>
    </div>
  </header>

  <div class="px-4 sm:px-6 lg:px-8">
    @if ($errors->any())
      <div class="mt-4 rounded-lg border border-red-600 bg-red-600/10 px-3 py-2">
        <ul class="list-disc list-inside text-sm">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div class="mt-4 rounded-lg border border-red-600 bg-red-600/10 px-3 py-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="mt-4 rounded-lg border border-red-600 bg-red-600/10 px-3 py-2">{{ session('error') }}</div>
    @endif
  </div>

  <div class="p-4 sm:p-6 lg:p-8">
    @if($stations->isEmpty())
      <div class="rounded-xl border border-white/10 p-8 text-center">
        <p class="text-white/80">No pickup stations found.</p>
        <button type="button"
                class="mt-3 inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-black hover:bg-red-500"
                data-store-url="{{ route('admin.stations.store') }}"
                onclick="openStationModalForCreate(this)">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
          Add your first station
        </button>
      </div>
    @else
      {{-- Desktop table --}}
      <div class="hidden md:block overflow-hidden rounded-xl border border-white/10">
        <table class="min-w-full divide-y divide-white/10">
          <thead class="bg-black">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Name</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Address</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">City</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Notes</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Status</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Added</th>
              <th class="px-4 py-3 text-right text-sm font-semibold text-white/80">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/10 bg-black/70">
            @foreach($stations as $s)
              <tr class="hover:bg-white/5">
                <td class="px-4 py-3 font-semibold">{{ $s->name }}</td>
                <td class="px-4 py-3">{{ $s->address }}</td>
                <td class="px-4 py-3">{{ $s->city }}</td>
                <td class="px-4 py-3 text-white/80">{{ \Illuminate\Support\Str::limit($s->notes, 60) }}</td>
                <td class="px-4 py-3">
                  @if($s->is_active)
                    <span class="rounded-full border border-white/20 px-2 py-0.5 text-xs">Active</span>
                  @else
                    <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs">Inactive</span>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <div class="text-sm">{{ $s->created_at?->diffForHumans() }}</div>
                  <div class="text-xs text-white/60">{{ $s->created_at?->format('Y-m-d H:i') }}</div>
                </td>
                <td class="px-4 py-3 text-right">
                  <div class="inline-flex items-center gap-2">
                    <button type="button"
                            class="rounded-md border border-red-600 px-3 py-1.5 text-sm font-semibold text-red-500 hover:bg-red-600 hover:text-black"
                            data-update-url="{{ route('admin.stations.update', $s) }}"
                            data-name="{{ $s->name }}"
                            data-address="{{ $s->address }}"
                            data-city="{{ $s->city }}"
                            data-notes="{{ $s->notes }}"
                            data-active="{{ $s->is_active ? '1' : '0' }}"
                            onclick="openStationModalForEdit(this)">
                      Edit
                    </button>

                    <button type="button"
                            class="rounded-md bg-white/10 px-3 py-1.5 text-sm hover:bg-white/20"
                            data-delete-url="{{ route('admin.stations.destroy', $s) }}"
                            data-name="{{ $s->name }}"
                            onclick="openDeleteModal(this)">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Mobile cards --}}
      <div class="md:hidden space-y-3">
        @foreach($stations as $s)
          <div class="rounded-xl border border-white/10 bg-black/70 p-4">
            <div class="flex items-start justify-between gap-3">
              <div>
                <div class="font-semibold">{{ $s->name }}</div>
                <div class="text-sm text-white/80">{{ $s->address }} @if($s->city) — {{ $s->city }} @endif</div>
                @if($s->notes)
                  <div class="mt-1 text-xs text-white/60">{{ \Illuminate\Support\Str::limit($s->notes, 100) }}</div>
                @endif
                <div class="mt-2">
                  @if($s->is_active)
                    <span class="rounded-full border border-white/20 px-2 py-0.5 text-xs">Active</span>
                  @else
                    <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs">Inactive</span>
                  @endif
                </div>
                <div class="mt-1 text-xs text-white/60">{{ $s->created_at?->diffForHumans() }}</div>
              </div>

              <div class="flex flex-col gap-2">
                <button type="button"
                        class="rounded-md border border-red-600 px-3 py-1.5 text-sm font-semibold text-red-500 hover:bg-red-600 hover:text-black"
                        data-update-url="{{ route('admin.stations.update', $s) }}"
                        data-name="{{ $s->name }}"
                        data-address="{{ $s->address }}"
                        data-city="{{ $s->city }}"
                        data-notes="{{ $s->notes }}"
                        data-active="{{ $s->is_active ? '1' : '0' }}"
                        onclick="openStationModalForEdit(this)">
                  Edit
                </button>
                <button type="button"
                        class="rounded-md bg-white/10 px-3 py-1.5 text-sm hover:bg-white/20"
                        data-delete-url="{{ route('admin.stations.destroy', $s) }}"
                        data-name="{{ $s->name }}"
                        onclick="openDeleteModal(this)">
                  Delete
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-6">
        {{ $stations->appends(request()->query())->links() }}
      </div>
    @endif
  </div>

  <div id="station-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4">
    <div class="w-full max-w-lg rounded-xl bg-black text-white ring-1 ring-white/10">
      <div class="px-5 py-4 border-b border-white/10">
        <h3 id="station-modal-title" class="text-lg font-bold">New Station</h3>
      </div>

      <form id="station-modal-form" method="POST" action="{{ route('admin.stations.store') }}">
        @csrf
        <input type="hidden" id="station-method"> {{-- name=_method added only when editing --}}

        <div class="px-5 py-4 grid gap-3">
          <div>
            <label class="text-sm font-semibold">Name</label>
            <input name="name" id="st-name"
                   class="mt-1 w-full rounded-lg border border-white/20 bg-black px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>
          <div class="grid sm:grid-cols-2 gap-3">
            <div>
              <label class="text-sm font-semibold">Address</label>
              <input name="address" id="st-address"
                     class="mt-1 w-full rounded-lg border border-white/20 bg-black px-3 py-2">
            </div>
            <div>
              <label class="text-sm font-semibold">City</label>
              <input name="city" id="st-city"
                     class="mt-1 w-full rounded-lg border border-white/20 bg-black px-3 py-2">
            </div>
          </div>
          <div>
            <label class="text-sm font-semibold">Notes</label>
            <textarea name="notes" id="st-notes" rows="3"
                      class="mt-1 w-full rounded-lg border border-white/20 bg-black px-3 py-2"></textarea>
          </div>

          {{-- Send 0 when unchecked so boolean is consistent --}}
          <input type="hidden" name="is_active" value="0">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" id="st-active" class="h-4 w-4" value="1">
            <span>Active</span>
          </label>
        </div>

        <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-white/10">
          <button type="button" class="rounded-md border border-white/20 px-3 py-1.5 hover:bg-white/10"
                  onclick="closeStationModal()">
            Cancel
          </button>
          <button class="rounded-md bg-red-600 px-3 py-1.5 font-semibold text-black hover:bg-red-500">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Delete Modal --}}
  <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4">
    <div class="w-full max-w-md rounded-xl bg-black text-white ring-1 ring-white/10">
      <div class="px-5 py-4 border-b border-white/10">
        <h3 class="text-lg font-bold">Delete station</h3>
      </div>

      <div class="px-5 py-4">
        <p class="text-sm text-white/80">
          Are you sure you want to delete
          <span id="delete-modal-name" class="font-semibold text-white"></span>?
          This action cannot be undone.
        </p>
      </div>

      <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-white/10">
        <button type="button" class="rounded-md border border-white/20 px-3 py-1.5 hover:bg-white/10"
                onclick="closeDeleteModal()">
          Cancel
        </button>
        <form id="delete-modal-form" method="POST" action="#">
          @csrf @method('DELETE')
          <button class="rounded-md bg-red-600 px-3 py-1.5 font-semibold text-black hover:bg-red-500">Delete</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    // ----- CREATE / EDIT MODAL -----
    const stModal  = document.getElementById('station-modal');
    const stForm   = document.getElementById('station-modal-form');
    const stMethod = document.getElementById('station-method');
    const stTitle  = document.getElementById('station-modal-title');

    const stName   = document.getElementById('st-name');
    const stAddr   = document.getElementById('st-address');
    const stCity   = document.getElementById('st-city');
    const stNotes  = document.getElementById('st-notes');
    const stActive = document.getElementById('st-active');

    function openStationModalForCreate(btn) {
      const storeUrl = btn.getAttribute('data-store-url');
      stForm.setAttribute('action', storeUrl);

      // Ensure we POST without method spoofing
      stMethod.removeAttribute('name');
      stMethod.value = '';

      stTitle.textContent = 'New Station';

      stName.value = '';
      stAddr.value = '';
      stCity.value = '';
      stNotes.value = '';
      stActive.checked = true;

      stModal.classList.remove('hidden'); stModal.classList.add('flex');
    }

    function openStationModalForEdit(btn) {
      const url   = btn.getAttribute('data-update-url');
      const name  = btn.getAttribute('data-name') || '';
      const addr  = btn.getAttribute('data-address') || '';
      const city  = btn.getAttribute('data-city') || '';
      const notes = btn.getAttribute('data-notes') || '';
      const active= btn.getAttribute('data-active') === '1';

      stForm.setAttribute('action', url);

      // Spoof PATCH for update
      stMethod.setAttribute('name', '_method');
      stMethod.value = 'PATCH';

      stTitle.textContent = 'Edit Station';

      stName.value  = name;
      stAddr.value  = addr;
      stCity.value  = city;
      stNotes.value = notes;
      stActive.checked = active;

      stModal.classList.remove('hidden'); stModal.classList.add('flex');
    }

    function closeStationModal() {
      stModal.classList.add('hidden'); stModal.classList.remove('flex');
    }
    stModal?.addEventListener('click', (e) => { if (e.target === stModal) closeStationModal(); });

    // ----- DELETE MODAL -----
    const delModal = document.getElementById('delete-modal');
    const delName  = document.getElementById('delete-modal-name');
    const delForm  = document.getElementById('delete-modal-form');

    function openDeleteModal(btn) {
      const url  = btn.getAttribute('data-delete-url');
      const name = btn.getAttribute('data-name') || '';
      delForm.setAttribute('action', url);
      delName.textContent = name;
      delModal.classList.remove('hidden'); delModal.classList.add('flex');
    }

    function closeDeleteModal() {
      delModal.classList.add('hidden'); delModal.classList.remove('flex');
    }
    delModal?.addEventListener('click', (e) => { if (e.target === delModal) closeDeleteModal(); });

    // ESC closes any open modal
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') { closeStationModal(); closeDeleteModal(); }
    });
  </script>
@endsection
