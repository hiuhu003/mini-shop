<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PickupStation;
use Illuminate\Support\Facades\DB;

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
        // Validate customer inputs (kept for UX; not all are stored on the order)
        $data = $request->validate([
            'name'           => ['required','string','max:255'],
            'phone'          => ['required','string','max:30'],
            'email'          => ['nullable','email'],
            'address'        => ['nullable','string','max:255'],

            // form sends station_id; DB column is pickup_station_id
            'station_id'     => ['required','exists:pickup_stations,id'],

            'payment_method' => ['required','in:mpesa,card'],
            'mpesa_phone'    => ['nullable','string'],
            'card_last4'     => ['nullable','digits:4'],
        ]);

        if ($data['payment_method'] === 'mpesa' && empty($data['mpesa_phone'])) {
            return back()->withInput()->with('error', 'Please provide your M-Pesa phone.');
        }
        if ($data['payment_method'] === 'card' && empty($data['card_last4'])) {
            return back()->withInput()->with('error', 'Please provide the card’s last 4 digits.');
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            DB::transaction(function () use ($request, $data, $cart) {
                // Lock products while we compute & update stock
                $products = Product::whereIn('id', array_keys($cart))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $itemsData  = [];
                $itemsCount = 0;
                $subtotal   = 0;

                foreach ($cart as $productId => $qty) {
                    if (!isset($products[$productId])) {
                        continue; // product removed meanwhile
                    }
                    $p   = $products[$productId];
                    $qty = (int) $qty;
                    if ($qty < 1) continue;

                    // Clear, user-friendly stock message
                    if ($qty > (int) $p->stock) {
                        $available = (int) $p->stock;
                        $msg = $available > 0
                            ? "Only {$available} left in stock for '{$p->name}'."
                            : "Sorry, '{$p->name}' is out of stock.";
                        throw new \RuntimeException($msg);
                    }

                    $unit = (int) round($p->price);
                    $line = $unit * $qty;

                    $itemsData[] = [
                        'product_id' => $p->id,
                        'quantity'   => $qty,
                        'unit_price' => $unit,   // matches order_items column
                        'line_total' => $line,   // matches order_items column
                    ];

                    $itemsCount += $qty;
                    $subtotal   += $line;
                }

                if (empty($itemsData)) {
                    throw new \RuntimeException('No valid items to place.');
                }

                // Fees & totals
                $delivery = 0; // adjust if you charge delivery
                $total    = $subtotal + $delivery;

                // Create order according to your migration schema
                $order = Order::create([
                    'user_id'           => optional($request->user())->id,
                    'pickup_station_id' => (int) $data['station_id'],
                    'status'            => 'pending',
                    'payment_method'    => $data['payment_method'],
                    'mpesa_phone'       => $data['payment_method'] === 'mpesa' ? $data['mpesa_phone'] : null,
                    'card_last4'        => $data['payment_method'] === 'card'  ? $data['card_last4']  : null,
                    'items_count'       => $itemsCount,
                    'subtotal'          => $subtotal,
                    'delivery_fee'      => $delivery,
                    'total'             => $total,
                ]);

                // Create order items + decrement stock
                foreach ($itemsData as $row) {
                    $order->items()->create($row); // uses fillable: unit_price, line_total
                    $products[$row['product_id']]->decrement('stock', $row['quantity']);
                }
            });

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', 'Something went wrong placing your order. Please try again.');
        }

        // Clear cart on success
        session()->forget('cart');
        session(['cart.count' => 0]);

        return redirect()->route('orders.index')->with('success', 'Order placed! 🎉');
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
