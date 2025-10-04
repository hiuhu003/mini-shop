{{-- Admin sidenav (red + black) --}}
<aside class="w-full md:w-64 md:shrink-0 bg-black text-white">
  {{-- Mobile header --}}
  <div class="md:hidden flex items-center justify-between px-4 py-3 border-b border-white/10">
    <div class="flex items-center gap-2">
      <span class="grid h-8 w-8 place-items-center rounded-md bg-red-600 text-black font-extrabold">A</span>
      <span class="font-bold">Admin</span>
    </div>
    <button type="button"
            class="rounded-md p-2 hover:bg-white/10"
            onclick="document.getElementById('admin-sidenav-links')?.classList.toggle('hidden')">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
      </svg>
    </button>
  </div>

  {{-- Links --}}
  <nav id="admin-sidenav-links" class="hidden md:block">
    <ul class="px-2 py-3 space-y-1">
      {{-- Add Product --}}
      <li>
        <a href="{{ route('admin.products.create') }}"
           class="group flex items-center gap-2 rounded-md px-3 py-2
                  {{ request()->routeIs('admin.products.create') ? 'bg-red-600 text-black' : 'hover:bg-white/10' }}">
          <svg class="h-5 w-5 {{ request()->routeIs('admin.products.create') ? 'text-black' : 'text-white/80 group-hover:text-white' }}" viewBox="0 0 24 24" fill="currentColor">
            <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/>
          </svg>
          <span class="font-medium">Add Product</span>
        </a>
      </li>

      {{-- View Products --}}
      <li>
        <a href="{{ route('admin.products.view') }}"
           class="group flex items-center gap-2 rounded-md px-3 py-2
                  {{ request()->routeIs('admin.products.index') ? 'bg-red-600 text-black' : 'hover:bg-white/10' }}">
          <svg class="h-5 w-5 {{ request()->routeIs('admin.products.index') ? 'text-black' : 'text-white/80 group-hover:text-white' }}" viewBox="0 0 24 24" fill="currentColor">
            <path d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z"/>
          </svg>
          <span class="font-medium">View Products</span>
        </a>
      </li>

      {{-- Check Stock (filters low stock via query) --}}
      <li>
        <a href="{{ route('admin.products.index', ['filter' => 'low-stock']) }}"
           class="group flex items-center gap-2 rounded-md px-3 py-2
                  {{ request('filter') === 'low-stock' ? 'bg-red-600 text-black' : 'hover:bg-white/10' }}">
          <svg class="h-5 w-5 {{ request('filter') === 'low-stock' ? 'text-black' : 'text-white/80 group-hover:text-white' }}" viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 3h10v2H7V3Zm10 4H7l-2 4v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V11l-2-4Zm-1 12H8v-6h8v6Z"/>
          </svg>
          <span class="font-medium">Check Stock</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>
