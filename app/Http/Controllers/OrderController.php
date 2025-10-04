<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('user.orders.index', compact('orders'));
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
    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load(['items.product']);
        return view('user.orders.show', compact('order'));
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

    public function cancel(Order $order)
{
    // Must belong to the current user
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    // Only allow cancel while it's early enough
    $cancellable = ['pending', 'in_progress'];
    if (! in_array($order->status, $cancellable, true)) {
        return back()->with('error', 'This order can no longer be cancelled.');
    }

    try {
        DB::transaction(function () use ($order) {
            // Restock items
            $order->load('items');
            foreach ($order->items as $item) {
                Product::whereKey($item->product_id)->increment('stock', (int) $item->quantity);
            }

            // Update status
            $order->status = 'cancelled';
            $order->save();
        });
    } catch (\Throwable $e) {
        report($e);
        return back()->with('error', 'Could not cancel the order. Please try again.');
    }

    return back()->with('success', 'Your order was cancelled.');
}
}
