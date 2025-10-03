<script src="https://cdn.tailwindcss.com"></script>

<div class="mx-auto max-w-4xl p-6">
  <h1 class="text-2xl font-bold mb-4">Your Cart ({{ $count }})</h1>

  @if (session('success'))
    <div class="mb-4 rounded border border-red-600 bg-red-600/10 px-3 py-2">
      {{ session('success') }}
    </div>
  @endif
  @if (session('error'))
    <div class="mb-4 rounded border border-red-600 bg-red-600/10 px-3 py-2">
      {{ session('error') }}
    </div>
  @endif

  @if (empty($items))
    <p>Your cart is empty.</p>
  @else
    <div class="space-y-3">
      @foreach ($items as $row)
        <div class="rounded border border-red-600/40 bg-black/20 p-3">
          <div class="flex items-center justify-between gap-3">
            {{-- Left: image + name + "view" --}}
            <div class="flex items-center gap-3">
              <img
                src="{{ $row['product']->image_path ? asset('storage/'.$row['product']->image_path) : 'https://via.placeholder.com/80' }}"
                class="h-16 w-16 object-cover rounded"
                alt="{{ $row['product']->name }}"
              >
              <div>
                <div class="font-semibold">
                  <a href="{{ route('shop.show', $row['product']) }}" class="hover:underline">
                    {{ $row['product']->name }}
                  </a>
                </div>
                <div class="text-sm text-red-400">Ksh {{ number_format($row['product']->price, 2) }}</div>
              </div>
            </div>

            {{-- Middle: quantity update --}}
            <form method="POST" action="{{ route('cart.update', $row['product']) }}" class="flex items-center gap-2">
              @csrf
              @method('PATCH')
              <label for="qty-{{ $row['product']->id }}" class="sr-only">Quantity</label>
              <input
                id="qty-{{ $row['product']->id }}"
                type="number"
                name="quantity"
                value="{{ $row['qty'] }}"
                min="0"
                class="w-20 rounded bg-white text-red-900 border border-red-300 px-3 py-1.5 text-center focus:outline-none focus:ring-2 focus:ring-red-400"
              />
              <button class="rounded bg-red-600 px-3 py-1.5 text-sm font-semibold text-black hover:bg-red-500">
                Update
              </button>
            </form>

            {{-- Right: line subtotal + remove --}}
            <div class="text-right">
              <div class="font-bold">Ksh {{ number_format($row['subtotal'], 2) }}</div>
              <form method="POST" action="{{ route('cart.destroy', $row['product']) }}" class="mt-1">
                @csrf
                @method('DELETE')
                <button class="text-sm text-red-400 hover:text-red-300 underline" onclick="return confirm('Remove this item?')">
                  Remove
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Totals + payment method --}}
    <div class="mt-6 rounded border border-red-600/40 bg-black/20 p-4">
      <div class="flex items-center justify-between">
        <div class="text-lg font-bold">Total: Ksh {{ number_format($total, 2) }}</div>
      </div>

      <form method="POST" action="{{ route('checkout.start') }}" class="mt-4 space-y-3">
        @csrf
        <fieldset class="space-y-2">
          <legend class="font-semibold">Choose payment method</legend>

          <label class="flex items-center gap-2">
            <input type="radio" name="payment_method" value="mpesa" checked>
            <span>M-Pesa</span>
          </label>
          <div class="pl-6">
            <input type="text" name="mpesa_phone" placeholder="M-Pesa phone (e.g. 07xx…)" class="w-full max-w-sm rounded bg-white text-red-900 border border-red-300 px-3 py-2">
          </div>

          <label class="flex items-center gap-2 mt-3">
            <input type="radio" name="payment_method" value="card">
            <span>Card</span>
          </label>
          <div class="pl-6">
            <input type="text" name="card_last4" placeholder="Card last 4 (demo)" class="w-full max-w-sm rounded bg-white text-red-900 border border-red-300 px-3 py-2">
          </div>
        </fieldset>

        <div class="pt-2">
          <button class="rounded bg-red-600 px-4 py-2 font-semibold text-black hover:bg-red-500">
            Proceed to checkout
          </button>
        </div>
      </form>
    </div>
  @endif
</div>
