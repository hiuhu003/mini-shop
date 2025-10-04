{{-- resources/views/user/checkout/review.blade.php --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 text-red-900">
  {{-- Flash --}}
  @if (session('success'))
    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-3 py-2">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-3 py-2">{{ session('error') }}</div>
  @endif

  {{-- Validation summary --}}
  @if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-3 py-2">
      <div class="font-semibold">Please fix the following:</div>
      <ul class="mt-1 list-disc list-inside text-sm">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
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
            <label class="text-sm font-semibold">Full name <span class="text-red-600">*</span></label>
            <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300" required>
            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="text-sm font-semibold">Phone <span class="text-red-600">*</span></label>
            <input name="phone" value="{{ old('phone') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2" required>
            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="text-sm font-semibold">Email (optional)</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2">
            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>
          <div class="sm:col-span-2">
            <label class="text-sm font-semibold">Address / Notes</label>
            <input name="address" value="{{ old('address') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2">
            @error('address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
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
              <input type="radio"
                     name="station_id"
                     value="{{ $s->id }}"
                     class="sr-only peer"
                     {{ old('station_id') == $s->id ? 'checked' : '' }}
                     required>
              <div class="p-3 peer-checked:bg-red-50">
                <div class="font-semibold">{{ $s->name }}</div>
                <div class="text-sm text-red-800/80">
                  {{ $s->address }} @if($s->city) — {{ $s->city }} @endif
                </div>
                @if($s->notes)
                  <div class="text-xs text-red-800/70 mt-1">{{ $s->notes }}</div>
                @endif
              </div>
            </label>
          @empty
            <p class="text-sm">No pickup stations yet. Please check back later.</p>
          @endforelse
          @error('station_id')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

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
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2" placeholder="07xx …">
            @error('mpesa_phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          {{-- CARD FIELD --}}
          <div class="{{ old('payment_method') === 'card' ? '' : 'hidden' }} card-field">
            <label class="text-sm font-semibold">Card last 4 (demo)</label>
            <input name="card_last4" value="{{ old('card_last4') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2" placeholder="1234">
            @error('card_last4')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          </div>

          @error('payment_method')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
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

        <button type="submit"
                class="mt-4 w-full rounded-lg bg-red-600 px-4 py-3 font-extrabold text-white shadow hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                {{ ($count ?? 0) < 1 ? 'disabled' : '' }}>
          Confirm order (KSh {{ number_format($total, 0) }})
        </button>

        <p class="mt-3 text-[12px] text-red-800/70">
          By proceeding, you agree to the Terms & Conditions.
        </p>
      </div>
    </aside>
  </form>
</div>

{{-- Toggle payment inputs --}}
<script>
  function setPaymentVisibility(value) {
    document.querySelector('.mpesa-field')?.classList.toggle('hidden', value !== 'mpesa');
    document.querySelector('.card-field')?.classList.toggle('hidden', value !== 'card');
  }
  document.addEventListener('change', (e) => {
    if (e.target.name === 'payment_method') setPaymentVisibility(e.target.value);
  });
  // ensure correct state on load as well
  document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="payment_method"]:checked');
    setPaymentVisibility(checked ? checked.value : 'mpesa');
  });
</script>
