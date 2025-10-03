 <script src="https://cdn.tailwindcss.com"></script>

 
<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8">
  <div class="grid md:grid-cols-2 gap-8 items-start">
    {{-- Image --}}
    <div class="relative">
      <div class="overflow-hidden rounded-2xl ring-1 ring-red-200 bg-white">
        <img
          src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://via.placeholder.com/800x600?text=No+Image' }}"
          alt="{{ $product->name }}"
          class="w-full h-64 sm:h-80 md:h-[420px] object-cover"
        />
      </div>
    </div>

    {{-- Details --}}
    <div class="text-red-900">
      <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-red-700">
        {{ $product->name }}
      </h1>

      <p class="mt-3 text-2xl font-extrabold text-red-600">
        Ksh {{ number_format($product->price, 2) }}
      </p>

      @if($product->description)
        <p class="mt-4 leading-relaxed">
          {{ $product->description }}
        </p>
      @endif

      <div class="mt-3">
        <span class="inline-flex items-center rounded-full bg-red-50 text-red-700 ring-1 ring-red-200 px-3 py-1 text-sm">
          Stock: {{ $product->stock }}
        </span>
      </div>

      <form method="POST" action="{{ route('cart.store') }}" class="mt-6 flex flex-wrap items-center gap-3">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <label for="qty" class="sr-only">Quantity</label>
        <input
          id="qty"
          type="number"
          name="quantity"
          value="1"
          min="1"
          max="{{ max(1, $product->stock) }}"
          class="w-24 rounded-full bg-white border border-red-300 px-4 py-2 text-center text-red-700 focus:outline-none focus:ring-2 focus:ring-red-400"
        />

        <button
          class="inline-flex items-center justify-center rounded-full bg-red-600 px-5 py-2.5 font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 disabled:opacity-60"
          @if($product->stock < 1) disabled @endif
        >
          Add to cart
        </button>

        <a
          href="{{ route('shop.index') }}"
          class="inline-flex items-center justify-center rounded-full border border-red-600 px-5 py-2.5 font-semibold text-red-700 hover:bg-red-600 hover:text-white"
        >
          ← Back to products
        </a>
      </form>
    </div>
  </div>
</div>
