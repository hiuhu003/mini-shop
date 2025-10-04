<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PickupStation;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $count    = array_sum($cart);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $total = 0;
        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) continue;
            $p = $products[$id];
            $items[] = ['product' => $p, 'qty' => $qty, 'subtotal' => $p->price * $qty];
            $total  += $p->price * $qty;
        }

        // ✅ load pickup stations and pass them to the view
        $stations = PickupStation::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('user.checkout.review', compact('items','count','total','stations'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * places the order
     */
    public function place(Request $request)
    {
         $rules = [
            'name'           => ['required','string','max:255'],
            'phone'          => ['required','string','max:30'],
            'email'          => ['nullable','email'],
            'address'        => ['nullable','string','max:255'],
            'station_id'     => ['required','exists:pickup_stations,id'],
            'payment_method' => ['required','in:mpesa,card'],
            'mpesa_phone'    => ['nullable','string'],
            'card_last4'     => ['nullable','digits:4'],
        ];
        $data = $request->validate($rules);

        // Conditional requirements
        if ($data['payment_method'] === 'mpesa' && empty($data['mpesa_phone'])) {
            return back()->withInput()->with('error', 'Please provide your M-Pesa phone.');
        }
        if ($data['payment_method'] === 'card' && empty($data['card_last4'])) {
            return back()->withInput()->with('error', 'Please provide the card’s last 4 digits.');
        }

        // TODO: create Order + OrderItems and integrate payment gateway here

        // Clear cart
        session()->forget('cart');
        session(['cart.count' => 0]);

        return redirect()->route('home')->with('success', 'Order placed! You will receive a confirmation shortly.');
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
