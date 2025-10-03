<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $cart = session('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $items = [];
        $count = 0;
        $total = 0;

        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) continue;
            $p = $products[$id];
            $items[] = [
                'product'  => $p,
                'qty'      => $qty,
                'subtotal' => $p->price * $qty,
            ];
            $count += $qty;
            $total += $p->price * $qty;
        }

        return view('user.cart.index', compact('items','count','total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'quantity'   => ['nullable','integer','min:1'],
        ]);

        $qty = (int)($data['quantity'] ?? 1);
        $cart = session('cart', []);
        $cart[$data['product_id']] = ($cart[$data['product_id']] ?? 0) + $qty;

        session(['cart' => $cart, 'cart.count' => array_sum($cart)]);
        return back()->with('success', 'Added to cart.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['required','integer','min:0']]);
        $qty  = min($data['quantity'], max(0, (int) $product->stock));

        $cart = session('cart', []);
        if ($qty === 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $qty;
        }
        session(['cart' => $cart, 'cart.count' => array_sum($cart)]);
        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);

        session(['cart' => $cart, 'cart.count' => array_sum($cart)]);
        return back()->with('success', 'Item removed.');

    }
}
