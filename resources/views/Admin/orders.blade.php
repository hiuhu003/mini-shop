{{-- resources/views/Admin/orders/index.blade.php --}}
@extends('admin.layout')

@section('title','Orders')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<header class="border-b border-white/10 px-4 sm:px-6 lg:px-8 py-4">
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h1 class="text-xl font-bold">Orders</h1>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="w-full sm:w-auto">
      <div class="relative">
        <input
          type="text" name="q" value="{{ $search ?? '' }}"
          placeholder="Search ID / name / email / phone…"
          class="w-full sm:w-80 rounded-lg bg-white text-red-900 placeholder:text-red-800/60 border border-red-200 px-3 py-2 pr-9 focus:outline-none focus:ring-2 focus:ring-red-400"
        />
        @if(($status ?? null) && $status !== 'all')
          <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <button class="absolute inset-y-0 right-0 grid w-9 place-items-center" aria-label="Search">
          <svg class="h-5 w-5 text-red-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.1-4.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
          </svg>
        </button>
      </div>
    </form>
  </div>

  {{-- Status filters --}}
  @php
    $current = $status ?? 'all';
    $tabs = ['all' => 'All'] + $statuses;
  @endphp
  <div class="mt-4 flex flex-wrap items-center gap-2">
    @foreach($tabs as $key => $label)
      <a href="{{ route('admin.orders.index', ['status' => $key === 'all' ? null : $key] + request()->except('page')) }}"
         class="rounded-full border px-3 py-1.5 text-sm
           {{ $current === $key ? 'border-red-600 bg-red-600 text-black' : 'border-white/20 hover:bg-white/10' }}">
        {{ is_array($label) ? $label : $label }}
      </a>
    @endforeach
  </div>
</header>

<div class="px-4 sm:px-6 lg:px-8">
  @if(session('success'))
    <div class="mt-4 rounded-lg border border-red-600 bg-red-600/10 px-3 py-2">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="mt-4 rounded-lg border border-red-600 bg-red-600/10 px-3 py-2">{{ session('error') }}</div>
  @endif
</div>

<div class="p-4 sm:p-6 lg:p-8">
  @if($orders->isEmpty())
    <div class="rounded-xl border border-white/10 p-8 text-center">
      <p class="text-white/80">No orders found.</p>
    </div>
  @else
    {{-- Desktop table --}}
    <div class="hidden md:block overflow-hidden rounded-xl border border-white/10">
      <table class="min-w-full divide-y divide-white/10">
        <thead class="bg-black">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Order</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Customer</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Items</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Total</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Payment</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Status</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-white/80">Placed</th>
            <th class="px-4 py-3 text-right text-sm font-semibold text-white/80">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-white/10 bg-black/70">
          @foreach($orders as $o)
            <tr class="hover:bg-white/5">
              <td class="px-4 py-3 font-semibold">{{ $o->id }}</td>
              <td class="px-4 py-3">
                <div class="font-medium">{{ $o->name ?? $o->user?->name ?? '—' }}</div>
                <div class="text-xs text-white/60">{{ $o->user->email }} @if($o->phone) · {{ $o->phone }} @endif</div>
              </td>
              <td class="px-4 py-3">{{ $o->items->count() }}</td>
              <td class="px-4 py-3 font-semibold">KSh {{ number_format($o->total ?? ($o->computed_total ?? 0), 2) }}</td>
              <td class="px-4 py-3 text-sm">
                {{ strtoupper($o->payment_method ?? 'mpesa') }}
              </td>
              <td class="px-4 py-3">
                {{-- Inline status update --}}
                <form method="POST" action="{{ route('admin.orders.update', $o) }}">
                  @csrf @method('PATCH')
                  <select name="status"
                          class="rounded-md border border-white/20 bg-black px-2 py-1 text-sm"
                          onchange="this.form.submit()">
                    @foreach(\App\Models\Order::STATUS_MAP as $value => $label)
                      <option value="{{ $value }}" @selected($o->status === $value)>{{ $label }}</option>
                    @endforeach
                  </select>
                </form>
              </td>
              <td class="px-4 py-3 text-sm">
                <div>{{ $o->created_at?->diffForHumans() }}</div>
                <div class="text-xs text-white/60">{{ $o->created_at?->format('Y-m-d H:i') }}</div>
              </td>
              <td class="px-4 py-3 text-right">
                @if(Route::has('admin.orders.show'))
                  <a href="{{ route('admin.orders.show', $o) }}"
                     class="rounded-md border border-red-600 px-3 py-1.5 text-sm font-semibold text-red-500 hover:bg-red-600 hover:text-black">
                    View
                  </a>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    

    <div class="mt-6">
      {{ $orders->links() }}
    </div>
  @endif
</div>
@endsection
