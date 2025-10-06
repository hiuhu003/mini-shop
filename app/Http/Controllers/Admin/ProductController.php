<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q      = (string) $request->query('q', '');
        $filter = (string) $request->query('filter', '');
        $LOW_STOCK_THRESHOLD = 5; // keep in sync with UI badge in view.blade.php

        $products = Product::query()
            ->when($q !== '', function ($builder) use ($q) {
                $builder->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%");
                });
            })
            ->when($filter === 'low-stock', function ($builder) use ($LOW_STOCK_THRESHOLD) {
                $builder->where('stock', '<=', $LOW_STOCK_THRESHOLD);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();
        return view('Admin.products.view', compact('products')); 
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['nullable','boolean'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','max:2048'],
        ]);

        $slug = Str::slug($data['name']);
        $base = $slug; $i = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $data['is_active'] = (bool)($data['is_active'] ?? true);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('Admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'slug'         => ['nullable','string','max:64'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['nullable','boolean'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','max:2048'],
        ]);

        // If name changed, regenerate unique slug
        if ($product->name !== $data['name']) {
            $slug = Str::slug($data['name']);
            $base = $slug; $i = 1;
            while (Product::where('slug', $slug)->where('id', '<>', $product->id)->exists()) {
                $slug = $base.'-'.$i++;
            }
            $data['slug'] = $slug;
        }

        // Replace image if new uploaded
        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        $product->update($data);

        return redirect()->route('admin.products.view')->with('success', 'Product updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.view')->with('success', 'Product deleted.');
    
    }
}
