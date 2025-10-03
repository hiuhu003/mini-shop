{{-- resources/views/user/shop/_grid.blade.php --}}
@if (session('success'))
  <div class="mb-4 rounded border border-red-600 bg-red-600/10 px-3 py-2">
    {{ session('success') }}
  </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
  @forelse ($products as $p)
    <div class="rounded-lg border border-red-600/40 bg-black/10 overflow-hidden">
      <a href="{{ route('shop.show', $p) }}">
        <img
          src="{{ $p->image_path ? asset('storage/'.$p->image_path) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
          alt="{{ $p->name }}"
          class="h-40 w-full object-cover"
        />
      </a>

      <div class="p-4">
        <h3 class="font-semibold">{{ $p->name }}</h3>
        <p class="mt-1 text-red-600 font-bold">Ksh {{ number_format($p->price, 2) }}</p>
        <p class="mt-1 text-sm">Stock: {{ $p->stock }}</p>

        <div class="mt-3 flex items-center gap-2">
          <a href="{{ route('shop.show', $p) }}"
             class="rounded border border-red-600 px-3 py-1.5 text-sm hover:bg-red-600 hover:text-black">
            View details
          </a>

          <form method="POST" action="{{ route('cart.store') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $p->id }}">
            <button
              class="rounded bg-red-600 px-3 py-1.5 text-sm font-semibold text-black hover:bg-red-500 disabled:opacity-50"
              @if($p->stock < 1) disabled @endif>
              Add to cart
            </button>
          </form>
        </div>
      </div>
    </div>
  @empty
    <p>No products yet.</p>
  @endforelse
</div>

<div class="mt-6">
  {{ $products->links() }}
</div>
