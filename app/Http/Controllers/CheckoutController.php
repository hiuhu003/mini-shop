<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['required','in:mpesa,card'],
            'mpesa_phone'    => ['nullable','string'],
            'card_last4'     => ['nullable','digits:4'],
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) continue;
            $p = $products[$id];
            $items[] = ['product' => $p, 'qty' => $qty, 'subtotal' => $p->price * $qty];
            $total += $p->price * $qty;
        }

        // Simple review page (stub — integrate real payment here)
        return view('user.checkout.review', [
            'items'       => $items,
            'total'       => $total,
            'method'      => $data['payment_method'],
            'mpesa_phone' => $data['mpesa_phone'] ?? null,
            'card_last4'  => $data['card_last4'] ?? null,
        ]);
    
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
