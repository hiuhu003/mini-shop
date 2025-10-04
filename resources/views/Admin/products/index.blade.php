<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Add Product • Admin</title>
</head>
<body class="min-h-screen bg-neutral-100 text-white">
  <div class="md:flex md:min-h-screen">
    {{-- Side nav --}}
    @include('Admin.partials.sidenav')

    {{-- Main content --}}
    <main class="flex-1 bg-black/95">
      <header class="border-b border-white/10 px-4 sm:px-6 lg:px-8 py-4">
        <h1 class="text-xl font-bold">Add Product</h1>
      </header>

      <div class="p-4 sm:p-6 lg:p-8">
        @include('Admin.products.create')
      </div>
    </main>

  </div>
  
</body>
</html>
