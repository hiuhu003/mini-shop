@extends('admin.layout')
@section('title','New Product')

@section('content')
<div class="mx-auto max-w-3xl p-6">
  <h1 class="text-xl font-bold mb-4">Add Product</h1>

  @if ($errors->any())
    <div class="mb-4 rounded bg-red-600/20 border border-red-600 p-3">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
      <label class="block mb-1">Name</label>
      <input name="name" class="w-full rounded bg-black/20 border border-red-600 px-3 py-2" required />
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block mb-1">Price</label>
        <input name="price" type="number" step="0.01" min="0" class="w-full rounded bg-black/20 border border-red-600 px-3 py-2" required />
      </div>
      <div>
        <label class="block mb-1">Stock</label>
        <input name="stock" type="number" min="0" class="w-full rounded bg-black/20 border border-red-600 px-3 py-2" required />
      </div>
    </div>
    <div>
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" checked>
        <span>Active</span>
      </label>
    </div>
    <div>
      <label class="block mb-1">Image</label>
      <input name="image" type="file" accept="image/*" class="block" />
    </div>
    <div>
      <label class="block mb-1">Description</label>
      <textarea name="description" rows="4" class="w-full rounded bg-black/20 border border-red-600 px-3 py-2"></textarea>
    </div>
    <button class="rounded bg-red-600 px-4 py-2 font-semibold text-black hover:bg-red-500">Save</button>
  </form>
</div>
@endsection
