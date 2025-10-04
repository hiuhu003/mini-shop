<header class="sticky top-0 z-50 bg-red-600 text-white shadow">
  {{-- Top Bar --}}
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">

      {{-- Left: Logo --}}
      <a href="" class="flex items-center gap-2 group" aria-label="Mini-Shop Home">
        {{-- Simple cart-logo mark --}}
        <svg class="h-8 w-8 transition-transform group-hover:scale-105" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M7 4h-.7a1 1 0 0 0 0 2H7l1.1 6.4a3 3 0 0 0 3 2.6h6.6a1 1 0 1 0 0-2H11.1a1 1 0 0 1-1-.9L9.7 10h8.8a2 2 0 0 0 1.9-1.5l1-3.8A1 1 0 0 0 20.5 4H8.2L8 2.9A2 2 0 0 0 6 1H3a1 1 0 1 0 0 2h3l1 5.8" />
          <circle cx="10" cy="20" r="1.75" />
          <circle cx="17" cy="20" r="1.75" />
        </svg>
        <span class="text-lg font-bold tracking-tight">Mini-Shop</span>
      </a>

      {{-- Center: Search (desktop) --}}
      <form action="" method="GET" class="hidden md:block md:flex-1 md:max-w-xl md:mx-8">
        <label for="site-search" class="sr-only">Search products</label>
        <div class="relative">
          <input
            id="site-search"
            name="q"
            type="search"
            placeholder="Search products…"
            class="w-full rounded-full bg-white/95 py-2.5 pl-4 pr-10 text-gray-800 placeholder:text-gray-500 shadow focus:outline-none focus:ring-2 focus:ring-white/80"
          />
          <button type="submit" class="absolute inset-y-0 right-0 grid w-10 place-items-center rounded-r-full focus:outline-none" aria-label="Search">
            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.1-4.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
            </svg>
          </button>
        </div>
      </form>

      {{-- Right: Actions --}}
      <div class="flex items-center gap-1 sm:gap-3">

        {{-- Mobile search button --}}
        <a href="" class="md:hidden p-2 rounded-full hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70" aria-label="Search">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.1-4.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
          </svg>
        </a>

        {{-- Cart --}}
        <a href="{{route('cart.index')}}" class="relative p-2 rounded-full hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/70" aria-label="Cart">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M7 4h-.7a1 1 0 0 0 0 2H7l1.1 6.4a3 3 0 0 0 3 2.6h6.6a1 1 0 1 0 0-2H11.1a1 1 0 0 1-1-.9L9.7 10h10.1" />
            <circle cx="10" cy="20" r="1.75" />
            <circle cx="17" cy="20" r="1.75" />
          </svg>
        
            <span class="absolute -top-1 -right-1 min-w-[1.25rem] rounded-full bg-white px-1.5 py-0.5 text-center text-xs font-bold text-red-600 shadow-sm">
              {{ $cartCount = array_sum(session('cart', [])); }}
            </span>
         
        </a>

        {{-- Account --}}
        <details class="relative">
          <summary class="list-none p-2 rounded-full hover:bg-white/10 cursor-pointer focus:outline-none focus:ring-2 focus:ring-white/70" aria-label="Account">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-8 2.5-8 5.5A1.5 1.5 0 0 0 5.5 21h13A1.5 1.5 0 0 0 20 19.5C20 16.5 17 14 12 14Z" />
            </svg>
          </summary>
          <div class="absolute right-0 mt-2 w-48 rounded-lg bg-white py-2 text-sm text-gray-800 shadow-lg ring-1 ring-black/5">
            @auth
              <a href="" class="block px-3 py-2 hover:bg-gray-50">My Profile</a>
              <a href="" class="block px-3 py-2 hover:bg-gray-50">Orders</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-3 py-2 hover:bg-gray-50">Sign out</button>
              </form>
            @else
              <a href="{{ route('login') }}" class="block px-3 py-2 hover:bg-gray-50">Sign in</a>
              <a href="{{ route('register') }}" class="block px-3 py-2 hover:bg-gray-50">Create account</a>
            @endauth
          </div>
        </details>

        {{-- Mobile menu toggle --}}
        <details class="relative md:hidden">
          <summary class="list-none p-2 rounded-full hover:bg-white/10 cursor-pointer focus:outline-none focus:ring-2 focus:ring-white/70" aria-label="Open menu">
            {{-- Hamburger --}}
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
          </summary>
          <nav class="absolute right-0 mt-2 w-64 rounded-lg bg-white text-gray-800 shadow-lg ring-1 ring-black/5">
            <ul class="py-2">
              <li><a href="" class="block px-4 py-2 hover:bg-gray-50">Home</a></li>
              <li><a href="" class="block px-4 py-2 hover:bg-gray-50">Shop</a></li>
              <li><a href="" class="block px-4 py-2 hover:bg-gray-50">Deals</a></li>
              <li><a href="" class="block px-4 py-2 hover:bg-gray-50">Contact</a></li>
            </ul>
          </nav>
        </details>

      </div>
    </div>
  </div>

  {{-- Bottom Nav (desktop) --}}
  <div class="hidden md:block border-t border-white/15">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <ul class="flex gap-6 py-2 text-sm">
        <li><a href="" class="inline-flex items-center rounded-md px-2 py-1 hover:bg-white/10">Shop</a></li>
        <li><a href="" class="inline-flex items-center rounded-md px-2 py-1 hover:bg-white/10">Deals</a></li>
        <li><a href="" class="inline-flex items-center rounded-md px-2 py-1 hover:bg-white/10">About</a></li>
        <li><a href="" class="inline-flex items-center rounded-md px-2 py-1 hover:bg-white/10">Contact</a></li>
      </ul>
    </nav>
  </div>
</header>
