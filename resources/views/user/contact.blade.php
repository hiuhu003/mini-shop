{{-- resources/views/user/contact.blade.php --}}

{{-- Page container --}}
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">

  {{-- SECTION: Hero --}}
  <section class="mb-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <h1 class="text-3xl font-extrabold text-red-700">Contact Us</h1>
        <p class="mt-1 text-sm text-red-800/70">
          We’d love to hear from you. Send us a message and we’ll respond as soon as possible.
        </p>
        <div class="mt-3 h-1 w-16 rounded bg-red-600/80"></div>
      </div>
    </div>
  </section>

  {{-- Flash + errors --}}
  <div class="mb-6">
    @if (session('success'))
      <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2">{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2">
        <ul class="list-disc pl-4 text-sm">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- SECTION: Content (info + form) --}}
  <section class="grid gap-8 lg:grid-cols-2">
    {{-- DIV: Contact info --}}
    <div class="rounded-2xl border border-red-100 bg-white p-6 shadow-sm">
      <h2 class="text-xl font-bold text-red-700">Our Contacts</h2>
      <p class="mt-1 text-sm text-red-800/70">Reach us through any of the channels below.</p>

      <div class="mt-4 grid gap-4">
        <div class="flex items-start gap-3">
          <span class="grid h-9 w-9 place-items-center rounded-lg bg-red-600 text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/></svg>
          </span>
          <div>
            <div class="font-semibold">Address</div>
            <div class="text-sm text-red-800/80">123 Market Street, Nairobi, Kenya</div>
          </div>
        </div>

        <div class="flex items-start gap-3">
          <span class="grid h-9 w-9 place-items-center rounded-lg bg-red-600 text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15.7 15.7 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.26 11.2 11.2 0 0 0 3.5.56 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17.6 17.6 0 0 1 3 6a1 1 0 0 1 1-1h3.48a1 1 0 0 1 1 1 11.2 11.2 0 0 0 .56 3.5 1 1 0 0 1-.26 1l-2.18 2.3Z"/></svg>
          </span>
          <div>
            <div class="font-semibold">Phone</div>
            <div class="text-sm text-red-800/80">+254 700 000 000</div>
          </div>
        </div>

        <div class="flex items-start gap-3">
          <span class="grid h-9 w-9 place-items-center rounded-lg bg-red-600 text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.35l-8 5.33-8-5.33V6Zm0 2.86V18a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8.86l-7.38 4.92a2 2 0 0 1-2.24 0L4 8.86Z"/></svg>
          </span>
          <div>
            <div class="font-semibold">Email</div>
            <div class="text-sm text-red-800/80">support@example.com</div>
          </div>
        </div>
      </div>

      <div class="mt-6">
        <div class="aspect-video w-full rounded-xl border border-red-100 bg-red-50 grid place-items-center text-sm text-red-700/70">
          Map / Location Embed
        </div>
      </div>
    </div>

    {{-- DIV: Contact form --}}
    <div class="rounded-2xl border border-red-100 bg-white p-6 shadow-sm">
      <h2 class="text-xl font-bold text-red-700">Send us a message</h2>
      <p class="mt-1 text-sm text-red-800/70">Fill the form and we’ll get back to you shortly.</p>

      <form method="POST" action="" class="mt-4 grid gap-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <label class="text-sm font-semibold">Full name</label>
            <input name="name" value="{{ old('name') }}" required
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
          </div>
          <div>
            <label class="text-sm font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
          </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <label class="text-sm font-semibold">Phone (optional)</label>
            <input name="phone" value="{{ old('phone') }}"
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
          </div>
          <div>
            <label class="text-sm font-semibold">Subject</label>
            <input name="subject" value="{{ old('subject') }}" required
                   class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
          </div>
        </div>

        <div>
          <label class="text-sm font-semibold">Message</label>
          <textarea name="message" rows="5" required
                    class="mt-1 w-full rounded-lg border border-red-200 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">{{ old('message') }}</textarea>
        </div>

        <div class="pt-2">
          <button class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 font-semibold text-white hover:bg-red-700 transition">
            Send Message
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m13 6 5 6-5 6H11l4-6-4-6h2Z"/></svg>
          </button>
        </div>
      </form>
    </div>
  </section>
</div>
