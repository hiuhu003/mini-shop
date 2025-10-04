<script src="https://cdn.tailwindcss.com"></script>

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 text-red-900">
  @if (session('success'))
    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-3 py-2">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-3 py-2">{{ session('error') }}</div>
  @endif

  {{-- Back to shopping --}}
  <div class="mb-4">
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-700 hover:text-red-800 hover:underline">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M14.7 6.3a1 1 0 0 1 0 1.4L10.4 12l4.3 4.3a1 1 0 1 1-1.4 1.4l-5-5a1 1 0 0 1 0-1.4l5-5a1 1 0 0 1 1.4 0z"/>
      </svg>
      Go back and continue shopping
    </a>
  </div>

  {{-- One form wraps both columns so the right-side button submits everything --}}
  <form method="POST" action="{{ route('checkout.place') }}" class="grid gap-6 md:grid-cols-[1fr,340px]">
    @csrf

    <div class="space-y-6">
      {{-- STEP 1: CUSTOMER DETAILS --}}
      <section class="rounded-xl bg-white border border-red-100 shadow-sm">
        <div class="px-4 py-3 border-b border-red-100">
          <h2 class="font-extrabold">1. CUSTOMER DETAILS</h2>
        </div>
        <div class="p-4 grid sm:grid-cols-2 gap-3">
          <div class="sm:col-span-2">
            <label class="text-sm font-semibold">Full name</label>
            <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300" required>
          </div>
          <div>
            <label class="text-sm font-semibold">Phone</label>
            <input name="phone" value="{{ old('phone') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2" required>
          </div>
          <div>
            <label class="text-sm font-semibold">Email (optional)</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2">
          </div>
          <div class="sm:col-span-2">
            <label class="text-sm font-semibold">Address / Notes</label>
            <input name="address" value="{{ old('address') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2">
          </div>
        </div>
      </section>

      {{-- STEP 2: PICKUP STATION --}}
      <section class="rounded-xl bg-white border border-red-100 shadow-sm">
        <div class="px-4 py-3 border-b border-red-100">
          <h2 class="font-extrabold">2. DELIVERY DETAILS</h2>
          <p class="text-sm text-red-800/70 mt-1">Pick-up Station</p>
        </div>

        <div class="p-4 space-y-3">
          @forelse ($stations as $s)
            <label class="block rounded-lg border border-red-200 hover:border-red-300">
              <input type="radio" name="station_id" value="{{ $s->id }}" class="sr-only peer" {{ old('station_id') == $s->id ? 'checked' : '' }} required>
              <div class="p-3 peer-checked:bg-red-50">
                <div class="font-semibold">{{ $s->name }}</div>
                <div class="text-sm text-red-800/80">{{ $s->address }} @if($s->city) — {{ $s->city }} @endif</div>
                @if($s->notes)<div class="text-xs text-red-800/70 mt-1">{{ $s->notes }}</div>@endif
              </div>
            </label>
          @empty
            <p class="text-sm">No pickup stations yet. Please check back later.</p>
          @endforelse

          <div class="text-sm mt-2">
            <a href="{{ route('cart.index') }}" class="underline">Modify cart</a>
          </div>
        </div>
      </section>

      {{-- STEP 3: PAYMENT METHOD --}}
      <section class="rounded-xl bg-white border border-red-100 shadow-sm">
        <div class="px-4 py-3 border-b border-red-100">
          <h2 class="font-extrabold">3. PAYMENT METHOD</h2>
        </div>

        <div class="p-4 space-y-4">
          {{-- segmented control --}}
          <div class="flex gap-2">
            <label class="flex-1 cursor-pointer">
              <input type="radio" name="payment_method" value="mpesa" class="peer sr-only" {{ old('payment_method', 'mpesa') === 'mpesa' ? 'checked' : '' }}>
              <div class="rounded-lg border border-red-200 bg-white px-3 py-2 text-center font-semibold peer-checked:bg-red-600 peer-checked:text-white">
                M-Pesa
              </div>
            </label>
            <label class="flex-1 cursor-pointer">
              <input type="radio" name="payment_method" value="card" class="peer sr-only" {{ old('payment_method') === 'card' ? 'checked' : '' }}>
              <div class="rounded-lg border border-red-200 bg-white px-3 py-2 text-center font-semibold peer-checked:bg-red-600 peer-checked:text-white">
                Card
              </div>
            </label>
          </div>

          {{-- M-PESA FIELD --}}
          <div class="{{ old('payment_method', 'mpesa') === 'mpesa' ? '' : 'hidden' }} mpesa-field">
            <label class="text-sm font-semibold">M-Pesa phone</label>
            <input name="mpesa_phone" value="{{ old('mpesa_phone') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2" placeholder="07xx ..." >
          </div>

          {{-- CARD FIELD --}}
          <div class="{{ old('payment_method') === 'card' ? '' : 'hidden' }} card-field">
            <label class="text-sm font-semibold">Card last 4 (demo)</label>
            <input name="card_last4" value="{{ old('card_last4') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2" placeholder="1234" >
          </div>
        </div>
      </section>
    </div>

    {{-- RIGHT COLUMN: ORDER SUMMARY --}}
    <aside class="md:sticky md:top-20">
      <div class="rounded-xl bg-white border border-red-100 shadow-sm p-4">
        <div class="text-sm font-semibold">ORDER SUMMARY</div>

        <div class="mt-3 space-y-2">
          <div class="flex items-baseline justify-between">
            <span class="text-sm">Items total ({{ $count }})</span>
            <span class="text-xl font-extrabold">KSh {{ number_format($total, 2) }}</span>
          </div>
        </div>

        <button type="submit" class="mt-4 w-full rounded-lg bg-red-600 px-4 py-3 font-extrabold text-white shadow hover:bg-red-700">
          Confirm order (KSh {{ number_format($total, 0) }})
        </button>

        <p class="mt-3 text-[12px] text-red-800/70">
          By proceeding, you agree to the Terms & Conditions.
        </p>
      </div>
    </aside>
  </form>
</div>

{{-- Tiny toggle for payment inputs --}}
<script>
  document.addEventListener('change', (e) => {
    if (e.target.name === 'payment_method') {
      document.querySelector('.mpesa-field')?.classList.toggle('hidden', e.target.value !== 'mpesa');
      document.querySelector('.card-field')?.classList.toggle('hidden', e.target.value !== 'card');
    }
  });
</script>
