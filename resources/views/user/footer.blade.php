<footer class="bg-red-600 text-white md:mt-auto">



  {{-- Main Links --}}
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8">
      {{-- Brand --}}
      <div class="col-span-2 sm:col-span-1">
        <a href="" class="flex items-center gap-2">
          <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M7 4h-.7a1 1 0 0 0 0 2H7l1.1 6.4a3 3 0 0 0 3 2.6h6.6a1 1 0 1 0 0-2H11.1a1 1 0 0 1-1-.9L9.7 10h8.8a2 2 0 0 0 1.9-1.5l1-3.8A1 1 0 0 0 20.5 4H8.2L8 2.9A2 2 0 0 0 6 1H3a1 1 0 1 0 0 2h3l1 5.8" />
            <circle cx="10" cy="20" r="1.75" />
            <circle cx="17" cy="20" r="1.75" />
          </svg>
          <span class="text-lg font-bold tracking-tight">Mini-Shop</span>
        </a>
        <p class="mt-3 text-sm text-white/85">
          Quality products at fair prices—delivered fast.
        </p>

        {{-- Socials --}}
        <div class="mt-4 flex gap-3">
          <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white" aria-label="Facebook">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10h3V7h-3V5c0-.8.2-1.3 1.4-1.3H16V1.1C15.6 1.1 14.7 1 13.7 1 11.6 1 10 2.5 10 4.9V7H7v3h3v10h3V10z"/></svg>
          </a>
          <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white" aria-label="Instagram">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3.8a5.2 5.2 0 1 1 0 10.4 5.2 5.2 0 0 1 0-10.4Zm0 2a3.2 3.2 0 1 0 0 6.4 3.2 3.2 0 0 0 0-6.4ZM18.5 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z"/></svg>
          </a>
          <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white" aria-label="X">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h3l-7.5 8.6L22 22h-6.9l-5.1-6.6L3.7 22H1l8-9.2L2 2h7l4.6 6 4.4-6Z"/></svg>
          </a>
        </div>
      </div>

      {{-- Shop --}}
      <div>
        <h3 class="font-semibold">Shop</h3>
        <ul class="mt-3 space-y-2 text-sm text-white/90">
          <li><a href="" class="hover:text-white">All Products</a></li>
          <li><a href="" class="hover:text-white">Deals</a></li>
          <li><a href="" class="hover:text-white">Cart</a></li>
        </ul>
      </div>

      {{-- Support --}}
      <div>
        <h3 class="font-semibold">Support</h3>
        <ul class="mt-3 space-y-2 text-sm text-white/90">
          <li><a href="" class="hover:text-white">FAQ</a></li>
          <li><a href="" class="hover:text-white">Shipping & Delivery</a></li>
          <li><a href="" class="hover:text-white">Returns & Refunds</a></li>
          <li><a href="" class="hover:text-white">Contact Us</a></li>
        </ul>
      </div>

 

    {{-- Bottom bar --}}
    <div class="mt-8 border-t border-white/15 pt-6 text-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <p class="text-white/85">&copy; {{ date('Y') }} Mini-Shop. All rights reserved.</p>
      <ul class="flex flex-wrap items-center gap-4 text-white/90">
        <li><a href="" class="hover:text-white">Privacy Policy</a></li>
        <li><a href="" class="hover:text-white">Terms of Service</a></li>
        <li><a href="" class="hover:text-white">Cookie Policy</a></li>
      </ul>
    </div>
  </div>
</footer>
