@if (session('success'))
  <div class="mb-4 rounded border border-red-600 bg-red-600/10 px-3 py-2">
    {{ session('success') }}
  </div>
@endif

<div class="w-full flex justify-center mb-10">
  <div class="text-center">
    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-red-900">
      Products
    </h1>
    <div class="mx-auto mt-1 h-1 w-24 rounded-full bg-gradient-to-r from-red-600 to-red-400"></div>
  </div>
</div>


<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
  @forelse ($products as $p)
    <div class="overflow-hidden rounded-lg border border-red-600/40 bg-black/10">
      <a href="{{ route('shop.show', $p) }}">
        <img
          src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
          alt="{{ $p->name }}"
          class="h-40 w-full object-cover"
        />
      </a>

      <div class="p-4">
        <h3 class="font-semibold">{{ $p->name }}</h3>
        <p class="mt-1 font-bold text-red-600">Ksh {{ number_format($p->price, 2) }}</p>
        <p class="mt-1 text-sm">Stock: {{ $p->stock }}</p>

        {{-- ACTION BUTTONS --}}
        <div class="mt-3 flex flex-wrap items-center gap-2">
          {{-- View details (outline -> red on hover) --}}
          <a href="{{ route('shop.show', $p) }}"
             class="inline-flex items-center gap-2 rounded-lg border border-red-600 px-3 py-2 text-sm font-semibold text-red-600
                    hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-400">
            View details
          </a>

          {{-- Add to cart / Login --}}
          @auth
            <form method="POST" action="{{ route('cart.store') }}" class="flex items-center gap-2">
              @csrf
              <input type="hidden" name="product_id" value="{{ $p->id }}">
            
              <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow
                       hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 disabled:cursor-not-allowed disabled:opacity-50"
                @if($p->stock < 1) disabled @endif>
                Add to cart
              </button>
            </form>
          @else
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow
                      hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400">
              Add to cart
            </a>
          @endauth
        </div>
        {{-- /ACTION BUTTONS --}}
      </div>
    </div>
  @empty
    <p>No products yet.</p>
  @endforelse
</div>

<div class="mt-6">
  {{ $products->links() }}
</div>
