{{-- resources/views/Admin/products/index.blade.php --}}
@extends('admin.layout')

@section('title','Products')

@section('content')
  {{-- Page Header --}}
  <header class="border-b border-white/10 px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <h1 class="text-xl font-bold">Products</h1>

      {{-- Top actions --}}
      <div class="flex items-center gap-2">
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-black hover:bg-red-500">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
          Add Product
        </a>
      </div>
    </div>

    {{-- Filters + search --}}
    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div class="flex flex-wrap items-center gap-2">
        @php $isLow = request('filter') === 'low-stock'; @endphp
        <a href="{{ route('admin.products.index') }}"
           class="rounded-full border px-3 py-1.5 text-sm
           {{ !$isLow ? 'border-red-600 bg-red-600 text-black' : 'border-white/20 hover:bg-white/10' }}">
          All
        </a>
        <a href="{{ route('admin.products.index', ['filter' => 'low-stock']) }}"
           class="rounded-full border px-3 py-1.5 text-sm
           {{ $isLow ? 'border-red-600 bg-red-600 text-black' : 'border-white/20 hover:bg-white/10' }}">
          Low Stock
        </a>
      </div>

      <form method="GET" action="{{ route('admin.products.index') }}" class="w-full sm:w-auto">
        <div class="relative">
          <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search name or SKU…"
            class="w-full sm:w-72 rounded-lg bg-white text-red-900 placeholder:text-red-800/60 border border-red-200 px-3 py-2 pr-9 focus:outline-none focus:ring-2 focus:ring-red-400"
          />
          <button class="absolute inset-y-0 right-0 grid w-9 place-items-center" aria-label="Search">
            <svg class="h-5 w-5 text-red-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.1-4.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
            </svg>
          </button>
        </div>
      </form>
    </div>
  </header>

  {{-- Flash messages --}}
  <div class="px-4 sm:px-6 lg:px-8">
    @if(session('success'))
      <div class="mt-4 rounded-lg border border-red-600 bg-red-600/10 px-3 py-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="mt-4 rounded-lg border border-red-600 bg-red-600/10 px-3 py-2">{{ session('error') }}</div>
    @endif
  </div>

  {{-- Content --}}
  <div class="p-4 sm:p-6 lg:p-8">
    @if($products->isEmpty())
      <div class="rounded-xl border border-white/10 p-8 text-center">
        <p class="text-white/80">No products found.</p>
        <a href="{{ route('admin.products.create') }}"
           class="mt-3 inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-black hover:bg-red-500">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
          Add your first product
        </a>
      </div>
    @else
      {{-- Desktop table --}}
      <div class="hidden md:block overflow-hidden rounded-xl border border-white/10">
        <table class="min-w-full divide-y divide-white/10">
          <thead class="bg-black">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Product</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Price</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Stock</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Status</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Added</th>
              <th class="px-4 py-3 text-right text-sm font-semibold text-white/80">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/10 bg-black/70">
            @foreach($products as $p)
              <tr class="hover:bg-white/5">
                <td class="px-4 py-3">
                  <div class="flex items-center gap-3">
                    <img
                      src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/64x64?text=No+Image' }}"
                      alt="{{ $p->name }}"
                      class="h-12 w-12 rounded-md object-cover ring-1 ring-white/10"
                    />
                    <div>
                      <div class="font-semibold">{{ $p->name }}</div>
                      @if(!empty($p->sku))
                        <div class="text-xs text-white/60">Tag: {{ $p->sku }}</div>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3">
                  <div class="font-semibold">KSh {{ number_format($p->price, 2) }}</div>
                </td>
                <td class="px-4 py-3">
                  <div class="inline-flex items-center gap-2">
                    <span class="font-semibold">{{ $p->stock }}</span>
                    <!-- Low stock value edit -->
                    @php($LOW_STOCK_THRESHOLD = (int) config('shop.low_stock_threshold', 5))
                    @if($p->stock <= $LOW_STOCK_THRESHOLD)
                    <span class="rounded-full bg-red-600 px-2 py-0.5 text-xs font-bold text-black">Low</span>
                    @endif
                  </div>
                </td>
                <td class="px-4 py-3">
                  @if($p->is_active)
                    <span class="rounded-full border border-white/20 px-2 py-0.5 text-xs">Active</span>
                  @else
                    <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs">Disabled</span>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <div class="text-sm">{{ $p->created_at?->diffForHumans() }}</div>
                  <div class="text-xs text-white/60">{{ $p->created_at?->format('Y-m-d H:i') }}</div>
                </td>
                <td class="px-4 py-3 text-right">
                  <div class="inline-flex items-center gap-2">
                    <a href="{{ route('admin.products.edit', $p) }}"
                       class="rounded-md border border-red-600 px-3 py-1.5 text-sm font-semibold text-red-500 hover:bg-red-600 hover:text-black">
                      Edit
                    </a>
                    {{-- Delete opens modal --}}
                    <button type="button"
                            class="rounded-md bg-white/10 px-3 py-1.5 text-sm hover:bg-white/20"
                            data-delete-url="{{ route('admin.products.destroy', $p) }}"
                            data-name="{{ $p->name }}"
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
        @foreach($products as $p)
          <div class="rounded-xl border border-white/10 bg-black/70 p-4">
            <div class="flex items-start gap-3">
              <img
                src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/64x64?text=No+Image' }}"
                alt="{{ $p->name }}"
                class="h-14 w-14 rounded-md object-cover ring-1 ring-white/10"
              />
              <div class="flex-1">
                <div class="font-semibold">{{ $p->name }}</div>
                @if(!empty($p->sku))
                  <div class="text-xs text-white/60">SKU: {{ $p->sku }}</div>
                @endif

                <div class="mt-2 grid grid-cols-2 gap-2 text-sm">
                  <div>
                    <div class="text-white/60">Price</div>
                    <div class="font-semibold">KSh {{ number_format($p->price, 2) }}</div>
                  </div>
                  <div>
                    <div class="text-white/60">Stock</div>
                    <div class="inline-flex items-center gap-2">
                        <span class="font-semibold">{{ $p->stock }}</span>
                        @if($p->stock <= $LOW_STOCK_THRESHOLD)
                        <span class="rounded-full bg-red-600 px-2 py-0.5 text-[11px] font-bold text-black">Low</span>
                        @endif
                    </div>
                  </div>
                  <div>
                    <div class="text-white/60">Status</div>
                    <div>{{ $p->is_active ? 'Active' : 'Disabled' }}</div>
                  </div>
                  <div>
                    <div class="text-white/60">Added</div>
                    <div>{{ $p->created_at?->diffForHumans() }}</div>
                  </div>
                </div>

                <div class="mt-3 flex items-center gap-2">
                  <a href="{{ route('admin.products.edit', $p) }}"
                     class="rounded-md border border-red-600 px-3 py-1.5 text-sm font-semibold text-red-500 hover:bg-red-600 hover:text-black">
                    Edit
                  </a>
                  <button type="button"
                          class="rounded-md bg-white/10 px-3 py-1.5 text-sm hover:bg-white/20"
                          data-delete-url="{{ route('admin.products.destroy', $p) }}"
                          data-name="{{ $p->name }}"
                          onclick="openDeleteModal(this)">
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      <div class="mt-6">
        {{ $products->appends(request()->query())->links() }}
      </div>
    @endif
  </div>

  {{-- Delete Modal --}}
  <div id="delete-modal"
       class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4">
    <div class="w-full max-w-md rounded-xl bg-black text-white ring-1 ring-white/10">
      <div class="px-5 py-4 border-b border-white/10">
        <h3 class="text-lg font-bold">Delete product</h3>
      </div>

      <div class="px-5 py-4">
        <p class="text-sm text-white/80">
          Are you sure you want to delete
          <span id="delete-modal-name" class="font-semibold text-white"></span>?
          This action cannot be undone.
        </p>
      </div>

      <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-white/10">
        <button type="button"
                class="rounded-md border border-white/20 px-3 py-1.5 hover:bg-white/10"
                onclick="closeDeleteModal()">
          Cancel
        </button>

        <form id="delete-modal-form" method="POST" action="#">
          @csrf @method('DELETE')
          <button class="rounded-md bg-red-600 px-3 py-1.5 font-semibold text-black hover:bg-red-500">
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    const modal = document.getElementById('delete-modal');
    const nameSpan = document.getElementById('delete-modal-name');
    const form = document.getElementById('delete-modal-form');

    function openDeleteModal(btn) {
      const url = btn.getAttribute('data-delete-url');
      const name = btn.getAttribute('data-name');

      form.setAttribute('action', url);
      nameSpan.textContent = name ?? '';

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function closeDeleteModal() {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    // Close on backdrop click
    modal?.addEventListener('click', (e) => {
      if (e.target === modal) closeDeleteModal();
    });

    // ESC to close
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeDeleteModal();
    });
  </script>
@endsection
