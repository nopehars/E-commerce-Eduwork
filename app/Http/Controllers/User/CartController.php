<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product', 'product.images')
            ->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        return view('user.cart.index', compact('cartItems', 'total'));
    }

    public function create()
    {
        // Not needed
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $cartItem = CartItem::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
            ],
            [
                'quantity' => $validated['quantity'],
                'added_at' => now(),
            ]
        );

        if ($cartItem->wasRecentlyCreated === false) {
            $cartItem->update(['quantity' => $cartItem->quantity + $validated['quantity']]);
        }

        // Return JSON when requested (AJAX/fetch) so frontend can update badge without full reload
        $count = CartItem::where('user_id', Auth::id())->count();
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => 'Item added to cart.'
            ]);
        }

        return redirect()->route('user.cart.index')->with('success', 'Item added to cart.');
    }

    public function show(string $id)
    {
        // Not needed
    }

    public function edit(string $id)
    {
        // Not needed
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->update(['quantity' => $validated['quantity']]);
        return redirect()->route('user.cart.index')->with('success', 'Cart updated.');
    }

    public function destroy(string $id)
    {
        CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
        return redirect()->route('user.cart.index')->with('success', 'Item removed from cart.');
    }

    /**
     * Return current authenticated user's cart item count (JSON).
     */
    public function count()
    {
        $count = CartItem::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}
