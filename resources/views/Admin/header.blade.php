{{-- Admin Header (Red + Black) --}}
<header class="sticky top-0 z-50 bg-black text-white border-b border-white/10">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between gap-3">
      {{-- Left: Brand + Mobile menu toggle --}}
      <div class="flex items-center gap-2">
        {{-- Mobile menu toggle (shows nav below on small screens) --}}
        <details class="relative md:hidden" id="admin-mobile-menu">
          <summary
            class="list-none inline-flex items-center justify-center rounded-md p-2 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-red-600"
            aria-label="Open menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
          </summary>
          <nav class="absolute left-0 mt-2 w-64 rounded-lg bg-black text-white shadow-lg ring-1 ring-white/10">
            <ul class="py-2 text-sm">
              <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-white/10">Dashboard</a></li>
              <li><a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 hover:bg-white/10">Orders</a></li>
              <li><a href="{{ route('admin.products.index') }}" class="block px-4 py-2 hover:bg-white/10">Products</a></li>
              <li><a href="{{ route('admin.customers.index') }}" class="block px-4 py-2 hover:bg-white/10">Customers</a></li>
              <li><a href="{{ route('admin.reports.index') }}" class="block px-4 py-2 hover:bg-white/10">Reports</a></li>
              <li><a href="{{ route('admin.settings') }}" class="block px-4 py-2 hover:bg-white/10">Settings</a></li>
            </ul>
          </nav>
        </details>

        {{-- Brand --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
          <span class="grid h-8 w-8 place-items-center rounded-md bg-red-600 text-black font-extrabold">A</span>
          <span class="font-bold tracking-tight">Admin</span>
        </a>
      </div>

      {{-- Center: Search (desktop) --}}
      <form action="{{ route('admin.search') }}" method="GET" class="hidden md:block md:flex-1 md:max-w-xl">
        <label for="admin-search" class="sr-only">Search</label>
        <div class="relative">
          <input
            id="admin-search"
            name="q"
            type="search"
            placeholder="Search orders, products, customers…"
            class="w-full rounded-lg bg-white/95 py-2.5 pl-4 pr-11 text-gray-900 placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-red-600"
          />
          <button type="submit" class="absolute inset-y-0 right-0 grid w-10 place-items-center rounded-r-lg" aria-label="Search">
            <svg class="h-5 w-5 text-red-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.1-4.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
            </svg>
          </button>
        </div>
      </form>

      {{-- Right: Quick actions --}}
      <div class="flex items-center gap-2 sm:gap-3">
        {{-- Quick create (desktop) --}}
        <a href="{{ route('admin.products.create') }}"
           class="hidden sm:inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-black shadow hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
          New Product
        </a>

        {{-- Notifications --}}
        @php($notifCount = session('admin.notifications', 0))
        <a href="{{ route('admin.notifications') }}"
           class="relative rounded-md p-2 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-red-600"
           aria-label="Notifications">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22Zm7-6v-5a7 7 0 0 0-5-6.7V3a2 2 0 1 0-4 0v1.3A7 7 0 0 0 5 11v5l-2 2v1h18v-1l-2-2Z"/>
          </svg>
          @if($notifCount > 0)
            <span class="absolute -top-0.5 -right-0.5 min-w-[1.1rem] rounded-full bg-red-600 px-1 text-center text-[11px] font-bold text-black">
              {{ $notifCount }}
            </span>
          @endif
        </a>

        {{-- Profile --}}
        <details class="relative">
          <summary class="list-none inline-flex items-center gap-2 rounded-md p-2 hover:bg-white/10 cursor-pointer focus:outline-none focus:ring-2 focus:ring-red-600">
            <span class="hidden sm:block text-sm">
              {{ Str::limit(auth()->user()->name ?? 'Admin', 14) }}
            </span>
            <span class="grid h-8 w-8 place-items-center rounded-full bg-white/10 text-white font-semibold">
              {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </span>
          </summary>
          <div class="absolute right-0 mt-2 w-56 rounded-lg bg-black text-white shadow-lg ring-1 ring-white/10">
            <div class="px-3 py-2 text-xs text-white/70">Signed in as</div>
            <div class="px-3 pb-2 text-sm font-semibold">{{ auth()->user()->email ?? 'admin@example.com' }}</div>
            <div class="my-1 border-t border-white/10"></div>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm hover:bg-white/10">Profile</a>
            <a href="{{ route('admin.settings') }}" class="block px-3 py-2 text-sm hover:bg-white/10">Settings</a>
            <div class="my-1 border-t border-white/10"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="block w-full text-left px-3 py-2 text-sm hover:bg-white/10">Sign out</button>
            </form>
          </div>
        </details>
      </div>
    </div>
  </div>

  {{-- Secondary Nav (desktop) --}}
  <div class="hidden md:block bg-black">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <ul class="flex items-center gap-6 text-sm">
        <li>
          <a href="{{ route('admin.dashboard') }}"
             class="inline-flex items-center border-b-2 px-1.5 py-3
               {{ request()->routeIs('admin.dashboard') ? 'border-red-600 text-white' : 'border-transparent text-white/80 hover:text-white hover:border-red-600' }}">
            Dashboard
          </a>
        </li>
        <li>
          <a href="{{ route('admin.orders.index') }}"
             class="inline-flex items-center border-b-2 px-1.5 py-3
               {{ request()->routeIs('admin.orders.*') ? 'border-red-600 text-white' : 'border-transparent text-white/80 hover:text-white hover:border-red-600' }}">
            Orders
          </a>
        </li>
        <li>
          <a href="{{ route('admin.products.index') }}"
             class="inline-flex items-center border-b-2 px-1.5 py-3
               {{ request()->routeIs('admin.products.*') ? 'border-red-600 text-white' : 'border-transparent text-white/80 hover:text-white hover:border-red-600' }}">
            Products
          </a>
        </li>
        <li>
          <a href="{{ route('admin.customers.index') }}"
             class="inline-flex items-center border-b-2 px-1.5 py-3
               {{ request()->routeIs('admin.customers.*') ? 'border-red-600 text-white' : 'border-transparent text-white/80 hover:text-white hover:border-red-600' }}">
            Customers
          </a>
        </li>
        <li>
          <a href="{{ route('admin.reports.index') }}"
             class="inline-flex items-center border-b-2 px-1.5 py-3
               {{ request()->routeIs('admin.reports.*') ? 'border-red-600 text-white' : 'border-transparent text-white/80 hover:text-white hover:border-red-600' }}">
            Reports
          </a>
        </li>
        
      </ul>
    </nav>
  </div>
</header>
