<section class="relative overflow-hidden bg-white">
  {{-- soft red background wash --}}
  <div class="pointer-events-none absolute inset-0 -z-10 bg-gradient-to-br from-red-600/10 via-red-600/5 to-transparent"></div>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-20 grid md:grid-cols-2 items-center gap-10">
    {{-- Left: copy + CTAs --}}
    <div>
      <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-700 ring-1 ring-red-200">
        New season • Hot deals
      </span>

      <h1 class="mt-4 text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">
        <span class="text-red-700">Fresh deals</span> at fair prices — delivered fast
      </h1>

      <p class="mt-4 text-gray-600 max-w-prose">
        From everyday essentials to must-have gadgets. Shop now and enjoy same-day delivery in select locations.
      </p>

      <div class="mt-6 flex flex-wrap gap-3">
        <a href=""
           class="inline-flex items-center justify-center rounded-full bg-red-600 px-6 py-3 text-white font-semibold shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400">
          Shop now
        </a>
        <a href=""
           class="inline-flex items-center justify-center rounded-full border border-red-600 px-6 py-3 font-semibold text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-200">
          Today’s deals
        </a>
      </div>

      {{-- Quick categories --}}
      <div class="mt-6 flex flex-wrap gap-2 text-sm">
        <a href="" class="rounded-full bg-red-50 px-3 py-1 text-red-700 ring-1 ring-red-200 hover:bg-red-100">Electronics</a>
        <a href="" class="rounded-full bg-red-50 px-3 py-1 text-red-700 ring-1 ring-red-200 hover:bg-red-100">Home & Living</a>
        <a href="" class="rounded-full bg-red-50 px-3 py-1 text-red-700 ring-1 ring-red-200 hover:bg-red-100">Groceries</a>
      </div>

      {{-- Trust badges --}}
      <dl class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
        <div class="flex items-center gap-3">
          <svg class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
          <div>
            <dt class="font-semibold">Easy returns</dt>
            <dd class="text-sm text-gray-600">14-day policy</dd>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <svg class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m3 12 2-2 4 4 10-10 2 2-12 12z"/></svg>
          <div>
            <dt class="font-semibold">Secure checkout</dt>
            <dd class="text-sm text-gray-600">MPesa & cards</dd>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <svg class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2 10h10l2-7H8"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
          <div>
            <dt class="font-semibold">Fast delivery</dt>
            <dd class="text-sm text-gray-600">Same-day in CBD</dd>
          </div>
        </div>
      </dl>
    </div>

    {{-- Right: image / banner --}}
    <div class="relative">
      <div class="relative overflow-hidden rounded-2xl ring-1 ring-red-100 shadow-lg">
        {{-- Replace with your asset image --}}
        <img
           src="{{ asset('build/assets/images/hero-main.jpeg') }}"
          alt="Bestsellers from Mini-Shop"
          class="h-[260px] w-full object-cover sm:h-[320px] md:h-[380px]"
        />
      </div>

      {{-- floating promo card --}}
      <div class="absolute -bottom-6 -left-4 hidden sm:flex items-center gap-3 rounded-xl bg-white px-4 py-3 shadow ring-1 ring-red-100">
        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-600 text-white font-bold">%</span>
        <p class="text-sm"><span class="font-semibold">Up to 30% off</span> select items</p>
      </div>
    </div>
  </div>
</section>
