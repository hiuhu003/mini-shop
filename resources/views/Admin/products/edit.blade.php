{{-- resources/views/Admin/products/edit.blade.php --}}
@extends('admin.layout')
@section('title','Edit Product')

@section('content')
  <header class="border-b border-white/10 px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-bold">Edit Product</h1>
      <a href="{{ route('admin.products.index') }}" class="rounded-md border border-white/20 px-3 py-1.5 text-sm hover:bg-white/10">Back</a>
    </div>
  </header>

  <div class="p-4 sm:p-6 lg:p-8">
    @if ($errors->any())
      <div class="mb-4 rounded border border-red-600 bg-red-600/10 px-3 py-2">
        <ul class="list-disc list-inside text-sm">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="grid gap-6 md:grid-cols-2">
      @csrf
      @method('PUT')

      <div class="space-y-4">
        <div>
          <label class="text-sm font-semibold">Name</label>
          <input name="name" value="{{ old('name', $product->name) }}"
                 class="mt-1 w-full rounded-lg bg-white text-red-900 border border-red-200 px-3 py-2" required>
        </div>
    

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm font-semibold">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                   class="mt-1 w-full rounded-lg bg-white text-red-900 border border-red-200 px-3 py-2" required>
          </div>
          <div>
            <label class="text-sm font-semibold">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                   class="mt-1 w-full rounded-lg bg-white text-red-900 border border-red-200 px-3 py-2" required>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
          <label for="is_active" class="text-sm font-semibold">Active</label>
        </div>

        <div>
          <label class="text-sm font-semibold">Description</label>
          <textarea name="description" rows="5"
                    class="mt-1 w-full rounded-lg bg-white text-red-900 border border-red-200 px-3 py-2">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
          <button class="rounded-md bg-red-600 px-4 py-2 font-semibold text-black hover:bg-red-500">
            Save changes
          </button>
          <a href="{{ route('admin.products.index') }}" class="rounded-md border border-white/20 px-4 py-2 hover:bg-white/10">Cancel</a>
        </div>
      </div>

      {{-- Right: Image --}}
      <div class="space-y-4">
        <div>
          <label class="text-sm font-semibold">Product image</label>
          <input type="file" name="image" accept="image/*"
                 class="mt-1 block w-full text-sm file:mr-3 file:rounded-md file:border-0 file:bg-red-600 file:px-3 file:py-2 file:font-semibold file:text-black hover:file:bg-red-500">
        </div>

        <div>
          <div class="text-sm mb-2">Current</div>
          <img
            src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://via.placeholder.com/400x260?text=No+Image' }}"
            class="h-48 w-full max-w-sm rounded-lg object-cover ring-1 ring-white/10"
            alt="{{ $product->name }}">
        </div>
      </div>
    </form>
  </div>
@endsection
