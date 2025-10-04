{{-- resources/views/user/orders/index.blade.php --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8 bg-white">
  {{-- Header --}}
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h1 class="text-2xl font-extrabold text-red-700">My Orders</h1>
      <div class="mt-1 h-1 w-16 rounded bg-red-600/70"></div>
    </div>

    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 transition">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M14.7 6.3a1 1 0 0 1 0 1.4L10.4 12l4.3 4.3a1 1 0 1 1-1.4 1.4l-5-5a1 1 0 0 1 0-1.4l5-5a1 1 0 0 1 1.4 0z"/>
      </svg>
      Continue shopping
    </a>
  </div>

  {{-- Flashes --}}
  @if (session('success'))
    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-800">
      {{ session('success') }}
    </div>
  @endif
  @if (session('error'))
    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-800">
      {{ session('error') }}
    </div>
  @endif

  {{-- Content --}}
  @if ($orders->isEmpty())
    <div class="mt-8 grid place-items-center rounded-2xl border border-red-100 bg-white p-10 text-center">
      <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-full bg-red-600 text-white">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M7 4h-.7a1 1 0 0 0 0 2H7l1.1 6.4a3 3 0 0 0 3 2.6h6.6a1 1 0 1 0 0-2H11.1a1 1 0 0 1-1-.9L9.7 10h8.8a2 2 0 0 0 1.9-1.5l1-3.8A1 1 0 0 0 20.5 4H8.2L8 2.9A2 2 0 0 0 6 1H3a1 1 0 1 0 0 2h3l1 5.8"/></svg>
      </div>
      <h2 class="text-lg font-semibold text-red-900">You haven’t placed any orders yet</h2>
      <p class="mt-1 text-sm text-red-800/70">When you do, they’ll show up here.</p>
      <a href="{{ route('shop.index') }}"
         class="mt-4 inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 font-semibold text-white hover:bg-red-700 transition">
        Start shopping
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m13 6 5 6-5 6H11l4-6-4-6h2Z"/></svg>
      </a>
    </div>
  @else
    <div class="mt-6 space-y-4">
      @foreach ($orders as $order)
        @php
          $statusLabel = ucfirst($order->status ?? 'pending');
          $badge = 'inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-200';
          $cancellable = in_array($order->status, ['pending','in_progress'], true);
        @endphp

        {{-- Card --}}
        <div class="block overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm hover:shadow-md transition">
          {{-- Clickable header to view details --}}
          <a href="{{ route('orders.show', $order) }}"
             class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between border-b border-red-100 bg-red-50/40 px-4 py-3">
            <div class="flex flex-wrap items-center gap-3 text-red-900">
              <span class="text-sm text-red-800/70">{{ $order->created_at?->format('Y-m-d H:i') }}</span>
            </div>
            <span class="{{ $badge }}">{{ $statusLabel }}</span>
          </a>

          {{-- Body --}}
          <div class="px-4 py-4">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
              {{-- Thumbnails / items --}}
              <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                  @foreach($order->items->take(4) as $item)
                    <img
                      src="{{ $item->product?->image_path ? asset('storage/'.$item->product->image_path) : 'https://via.placeholder.com/40' }}"
                      class="h-10 w-10 rounded-md object-cover ring-2 ring-white border border-red-100"
                      alt="">
                  @endforeach
                  @if($order->items->count() > 4)
                    <span class="h-10 w-10 grid place-items-center rounded-md bg-red-50 text-xs font-bold text-red-700 ring-2 ring-white border border-red-100">
                      +{{ $order->items->count() - 4 }}
                    </span>
                  @endif
                </div>

                <div class="ml-2 text-sm text-red-800/80">
                  {{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}
                </div>
              </div>

              {{-- Total --}}
              <div class="text-right">
                <div class="text-[12px] uppercase tracking-wide text-red-800/60">Total</div>
                <div class="text-xl font-extrabold text-red-700">
                  KSh {{ number_format($order->total, 2) }}
                </div>
              </div>
            </div>

            {{-- CTAs --}}
            <div class="mt-3 flex items-center gap-3">
              <a href="{{ route('orders.show', $order) }}"
                 class="inline-flex items-center gap-1 rounded-md border border-red-200 px-3 py-1.5 text-sm font-semibold text-red-700 hover:bg-red-50">
                View details
              </a>

              @if($cancellable)
                <button type="button"
                        class="inline-flex items-center gap-1 rounded-md border border-red-600 px-3 py-1.5 text-sm font-semibold text-red-600 hover:bg-red-600 hover:text-black"
                        data-cancel-url="{{ route('orders.cancel', $order) }}"
                        data-order-number="#{{ $order->id }}"
                        onclick="openCancelModal(this)">
                  Cancel Order
                </button>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
      {{ $orders->links() }}
    </div>
  @endif
</div>

{{-- Cancel Modal --}}
<div id="cancel-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4">
  <div class="w-full max-w-md rounded-xl bg-white text-red-900 ring-1 ring-red-200">
    <div class="px-5 py-4 border-b border-red-200">
      <h3 class="text-lg font-bold">Cancel order</h3>
    </div>

    <div class="px-5 py-4">
      <p class="text-sm">
        Are you sure you want to cancel
        <span id="cancel-modal-order" class="font-semibold"></span>?
        This action cannot be undone.
      </p>
    </div>

    <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-red-200">
      <button type="button"
              class="rounded-md border border-red-300 px-3 py-1.5 hover:bg-red-50"
              onclick="closeCancelModal()">
        Keep Order
      </button>

      <form id="cancel-modal-form" method="POST" action="#">
        @csrf
        @method('PATCH')
        <button class="rounded-md bg-red-600 px-3 py-1.5 font-semibold text-white hover:bg-red-700">
          Yes, Cancel
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  const cancelModal = document.getElementById('cancel-modal');
  const cancelForm  = document.getElementById('cancel-modal-form');
  const cancelText  = document.getElementById('cancel-modal-order');

  function openCancelModal(btn) {
    const url   = btn.getAttribute('data-cancel-url');
    const label = btn.getAttribute('data-order-number') || '';
    cancelForm.setAttribute('action', url);
    cancelText.textContent = label;

    cancelModal.classList.remove('hidden');
    cancelModal.classList.add('flex');
  }
  function closeCancelModal() {
    cancelModal.classList.add('hidden');
    cancelModal.classList.remove('flex');
  }
  // Close on backdrop
  cancelModal?.addEventListener('click', (e) => {
    if (e.target === cancelModal) closeCancelModal();
  });
  // ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !cancelModal.classList.contains('hidden')) closeCancelModal();
  });
</script>
