{{-- resources/views/user/orders/show.blade.php --}}
<script src="https://cdn.tailwindcss.com"></script>

@php
  // Defensive totals in case your model doesn’t expose an accessor.
  $subtotal = 0;
  foreach (($order->items ?? []) as $it) {
      $price = $it->price ?? ($it->product->price ?? 0);
      $subtotal += $price * (int)($it->quantity ?? 0);
  }
  $total = $order->computed_total ?? $subtotal;

  // Pretty status badge (white + red palette)
  $statusText = ucfirst($order->status ?? 'pending');
  $badge = 'inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-200';
@endphp

<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8 bg-white">
  {{-- Top bar --}}
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h1 class="text-2xl font-extrabold text-red-700">Order #{{ $order->id }}</h1>
      <div class="mt-1 flex flex-wrap items-center gap-3">
        <span class="{{ $badge }}">{{ $statusText }}</span>
        <span class="text-sm text-red-800/70">{{ $order->created_at?->format('Y-m-d H:i') }}</span>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('orders.index') }}"
         class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 transition">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M14.7 6.3a1 1 0 0 1 0 1.4L10.4 12l4.3 4.3a1 1 0 1 1-1.4 1.4l-5-5a1 1 0 0 1 0-1.4l5-5a1 1 0 0 1 1.4 0z"/></svg>
        Back to orders
      </a>
      <button onclick="window.print()"
              class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7H7V3h10v4Zm3 4h-1V8a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v3H4a2 2 0 0 0-2 2v5h5v3h10v-3h5v-5a2 2 0 0 0-2-2Zm-5 9H9v-4h6v4Z"/></svg>
        Print
      </button>
    </div>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-800">
      {{ session('success') }}
    </div>
  @endif

  {{-- Summary cards --}}
  <div class="mt-6 grid gap-4 md:grid-cols-3">
    <div class="rounded-2xl border border-red-100 bg-white p-4">
      <div class="text-xs uppercase tracking-wide text-red-800/60">Total</div>
      <div class="mt-1 text-2xl font-extrabold text-red-700">KSh {{ number_format($total, 2) }}</div>
    </div>

    <div class="rounded-2xl border border-red-100 bg-white p-4">
      <div class="text-xs uppercase tracking-wide text-red-800/60">Payment</div>
      <div class="mt-1 text-sm text-red-900">
        {{ strtoupper($order->payment_method ?? 'mpesa') }}
        @if(($order->payment_method ?? null) === 'mpesa' && !empty($order->mpesa_phone))
          <span class="text-red-800/70"> · {{ $order->mpesa_phone }}</span>
        @endif
        @if(($order->payment_method ?? null) === 'card' && !empty($order->card_last4))
          <span class="text-red-800/70"> · **** {{ $order->card_last4 }}</span>
        @endif
      </div>
    </div>

    <div class="rounded-2xl border border-red-100 bg-white p-4">
      <div class="text-xs uppercase tracking-wide text-red-800/60">Pick-up station</div>
      <div class="mt-1 text-sm text-red-900">
        {{ $order->station?->name ?? $order->pickupStation?->name ?? '—' }}
        @php
          $addr = trim(($order->station?->address ?? $order->pickupStation?->address ?? '').' '.($order->station?->city ?? $order->pickupStation?->city ?? ''));
        @endphp
        @if($addr)
          <div class="text-red-800/70 text-xs">{{ $addr }}</div>
        @endif
      </div>
    </div>
  </div>

  {{-- Customer details --}}
  <div class="mt-6 rounded-2xl border border-red-100 bg-white p-5">
    <h2 class="text-sm font-semibold text-red-700">Customer</h2>
    <div class="mt-2 grid gap-3 sm:grid-cols-2">
      <div class="text-sm text-red-900">
        <div class="text-red-800/60 text-xs">Name</div>
        <div class="font-medium">{{ $order->name ?? auth()->user()?->name ?? '—' }}</div>
      </div>
      <div class="text-sm text-red-900">
        <div class="text-red-800/60 text-xs">Phone</div>
        <div class="font-medium">{{ $order->phone ?? '—' }}</div>
      </div>
      <div class="text-sm text-red-900">
        <div class="text-red-800/60 text-xs">Email</div>
        <div class="font-medium">{{ $order->email ?? '—' }}</div>
      </div>
      <div class="text-sm text-red-900">
        <div class="text-red-800/60 text-xs">Address / Notes</div>
        <div class="font-medium">{{ $order->address ?? '—' }}</div>
      </div>
    </div>
  </div>

  {{-- Items --}}
  <div class="mt-6 rounded-2xl border border-red-100 bg-white overflow-hidden">
    <div class="border-b border-red-100 bg-red-50/40 px-4 py-3">
      <h2 class="text-sm font-semibold text-red-700">Items</h2>
    </div>

    {{-- Desktop table --}}
    <div class="hidden md:block">
      <table class="min-w-full">
        <thead>
          <tr class="text-left text-xs uppercase tracking-wide text-red-800/60">
            <th class="px-4 py-3">Product</th>
            <th class="px-4 py-3">Price</th>
            <th class="px-4 py-3">Qty</th>
            <th class="px-4 py-3 text-right">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($order->items ?? [] as $it)
            @php
              $price = $it->price ?? ($it->product->price ?? 0);
              $sub = $price * (int)$it->quantity;
            @endphp
            <tr class="border-t border-red-100">
              <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <img
                    src="{{ $it->product?->image_path ? asset('storage/'.$it->product->image_path) : 'https://via.placeholder.com/48' }}"
                    class="h-12 w-12 rounded-md object-cover ring-1 ring-red-100" alt="">
                  <div>
                    <div class="font-medium text-red-900">{{ $it->product?->name ?? 'Product' }}</div>
                    @if(!empty($it->product?->sku))
                      <div class="text-xs text-red-800/60">SKU: {{ $it->product->sku }}</div>
                    @endif
                  </div>
                </div>
              </td>
              <td class="px-4 py-3 text-red-900">KSh {{ number_format($price, 2) }}</td>
              <td class="px-4 py-3 text-red-900">× {{ $it->quantity }}</td>
              <td class="px-4 py-3 text-right font-semibold text-red-700">KSh {{ number_format($sub, 2) }}</td>
            </tr>
          @empty
            <tr>
              <td class="px-4 py-4 text-sm text-red-800/70" colspan="4">No items on this order.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Mobile list --}}
    <div class="md:hidden divide-y divide-red-100">
      @forelse ($order->items ?? [] as $it)
        @php
          $price = $it->price ?? ($it->product->price ?? 0);
          $sub = $price * (int)$it->quantity;
        @endphp
        <div class="p-4">
          <div class="flex items-start gap-3">
            <img
              src="{{ $it->product?->image_path ? asset('storage/'.$it->product->image_path) : 'https://via.placeholder.com/48' }}"
              class="h-14 w-14 rounded-md object-cover ring-1 ring-red-100" alt="">
            <div class="flex-1">
              <div class="font-medium text-red-900">{{ $it->product?->name ?? 'Product' }}</div>
              <div class="mt-1 text-sm text-red-800/70">KSh {{ number_format($price, 2) }} · × {{ $it->quantity }}</div>
            </div>
            <div class="text-right font-semibold text-red-700">KSh {{ number_format($sub, 2) }}</div>
          </div>
        </div>
      @empty
        <div class="p-4 text-sm text-red-800/70">No items on this order.</div>
      @endforelse
    </div>
  </div>

  {{-- Totals --}}
  <div class="mt-6 grid gap-4 md:grid-cols-2">
    <div></div>
    <div class="rounded-2xl border border-red-100 bg-white p-5">
      <dl class="space-y-2 text-sm">
        <div class="flex items-center justify-between">
          <dt class="text-red-800/70">Subtotal</dt>
          <dd class="font-semibold text-red-900">KSh {{ number_format($subtotal, 2) }}</dd>
        </div>
        {{-- If you ever add shipping/discounts, place them here --}}
        <div class="flex items-center justify-between border-t border-red-100 pt-3">
          <dt class="text-red-700 font-semibold">Total</dt>
          <dd class="text-xl font-extrabold text-red-700">KSh {{ number_format($total, 2) }}</dd>
        </div>
      </dl>
    </div>
  </div>

  {{-- Help --}}
  <div class="mt-8 rounded-2xl border border-red-100 bg-red-50/40 p-4 text-sm text-red-800/80">
    Need help with this order?
    <a href="{{ route('shop.index') }}" class="font-semibold text-red-700 underline hover:text-red-800">Contact us</a>.
  </div>
</div>
