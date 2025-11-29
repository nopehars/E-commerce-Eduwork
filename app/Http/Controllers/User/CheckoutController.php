<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product', 'product.images')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Cart is empty.');
        }

        // Ambil alamat via query agar tidak men-trigger static analyzer
        $addresses = \App\Models\Address::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('user.checkout.index', compact('cartItems', 'addresses', 'total'));
    }

    public function pay(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'shipping_fee' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $total = $subtotal + $validated['shipping_fee'];

        $transaction = DB::transaction(function () use ($user, $cartItems, $validated, $subtotal, $total) {
            // Create transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'address_id' => $validated['address_id'],
                'status' => 'pending',
                'total_amount' => $subtotal,
                'shipping_fee' => $validated['shipping_fee'],
                'payment_method' => 'midtrans',
            ]);

            // Create transaction items
            foreach ($cartItems as $cartItem) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $cartItem->product_id,
                    'product_sku' => $cartItem->product->sku,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Reduce stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Get Snap token from Midtrans
            $snapToken = $this->midtransService->createSnapToken(
                $transaction->id,
                $total,
                $user
            );

            $transaction->update(['payment_gateway_id' => $snapToken]);

            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();
            return $transaction;
        });

        $transaction->refresh();
        return view('user.checkout.payment', compact('transaction'));
    }
}
