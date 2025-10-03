<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin')</title>

    {{-- Tailwind (CDN) — don’t also load Vite CSS at the same time --}}
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-black text-white antialiased">

    {{-- Header --}}
    @include('Admin.header')

    {{-- Page content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('Admin.footer')

    @stack('scripts')
</body>
</html>
