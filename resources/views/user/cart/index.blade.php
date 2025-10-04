 <script src="https://cdn.tailwindcss.com"></script>

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
  <div class="grid gap-6 md:grid-cols-[1fr,350px]">
    {{-- LEFT: Cart list --}}
    <section class="rounded-xl bg-white border border-red-100 shadow-sm overflow-hidden">
      <div class="px-4 py-3 border-b border-red-100">
        <h1 class="text-xl font-extrabold text-red-900">Cart ({{ $count }})</h1>
      </div>

      @if (session('success'))
        <div class="px-4 py-2 text-sm text-red-900 bg-red-50 border-b border-red-100">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="px-4 py-2 text-sm text-red-900 bg-red-50 border-b border-red-100">{{ session('error') }}</div>
      @endif

      @if (empty($items))
        <div class="p-6 text-red-900/80">Your cart is empty.</div>
      @else
        <ul class="divide-y divide-red-100">
          @foreach ($items as $row)
            @php
              $p = $row['product'];
              $qty = $row['qty'];
              $out = $p->stock < 1;
            @endphp

            <li class="p-4">
              <div class="grid grid-cols-[80px,1fr,auto] items-start gap-4 {{ $out ? 'opacity-70' : '' }}">
                {{-- Image --}}
                <div class="relative">
                  <a href="{{ route('shop.show', $p) }}">
                    <img
                      src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/120x120?text=No+Image' }}"
                      class="h-20 w-20 rounded-lg object-cover ring-1 ring-red-100"
                      alt="{{ $p->name }}"
                    />
                  </a>
                  @if($out)
                    <span class="absolute -top-2 -left-2 rounded-md bg-red-600 text-white text-[10px] px-2 py-0.5">OUT</span>
                  @endif
                </div>

                {{-- Name + meta + remove --}}
                <div>
                  <a href="{{ route('shop.show', $p) }}" class="font-semibold text-red-900 hover:underline">
                    {{ $p->name }}
                  </a>
                  <div class="mt-1 text-sm text-red-800/80">In stock: {{ $p->stock }}</div>

                  <form method="POST" action="{{ route('cart.destroy', $p) }}" class="mt-2">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center gap-1 text-sm text-red-700 hover:text-red-800 underline"
                            onclick="return confirm('Remove this item?')">
                      Remove
                    </button>
                  </form>
                </div>

                {{-- Price --}}
                <div class="text-right">
                  <div class="text-lg font-extrabold text-red-900">KSh {{ number_format($row['subtotal'], 2) }}</div>
                </div>
              </div>

              {{-- Qty stepper --}}
              <div class="mt-3 flex items-center justify-end gap-2">
                {{-- - --}}
                <form method="POST" action="{{ route('cart.update', $p) }}">
                  @csrf @method('PATCH')
                  <input type="hidden" name="quantity" value="{{ max(0, $qty - 1) }}">
                  <button type="submit"
                          class="h-9 w-9 grid place-items-center rounded-lg border border-red-200 text-red-900 bg-white hover:bg-red-50 disabled:opacity-50"
                          {{ $qty <= 0 ? 'disabled' : '' }}>
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><rect x="5" y="11" width="14" height="2"/></svg>
                  </button>
                </form>

                <span class="inline-flex h-9 min-w-[2.5rem] items-center justify-center rounded-lg border border-red-200 bg-white text-red-900 px-2">
                  {{ $qty }}
                </span>

                {{-- + --}}
                <form method="POST" action="{{ route('cart.update', $p) }}">
                  @csrf @method('PATCH')
                  <input type="hidden" name="quantity" value="{{ $qty + 1 }}">
                  <button type="submit"
                          class="h-9 w-9 grid place-items-center rounded-lg bg-red-600 text-white hover:bg-red-700 disabled:opacity-60"
                          {{ $out ? 'disabled' : '' }}>
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
                  </button>
                </form>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </section>

    {{-- RIGHT: Summary --}}
    <aside class="md:sticky md:top-20">
      <div class="rounded-xl bg-white border border-red-100 shadow-sm p-4">
        <div class="text-sm font-semibold text-red-900">CART SUMMARY</div>
        <div class="mt-2 flex items-baseline justify-between">
          <span class="text-sm text-red-900/80">Subtotal</span>
          <span class="text-2xl font-extrabold text-red-900">KSh {{ number_format($total, 2) }}</span>
        </div>

        <form method="GET" action="{{ route('checkout.index') }}" class="mt-4 space-y-3">
          @csrf


          <button class="mt-2 w-full rounded-lg bg-red-600 px-4 py-3 font-extrabold text-white shadow hover:bg-red-700">
            
            Checkout (KSh {{ number_format($total, 0) }})
          </button>
        </form>
      </div>
    </aside>
  </div>
</div>
