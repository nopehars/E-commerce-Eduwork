<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Get user statistics (use auth id to avoid analyzer warnings about $user->id)
        $cartCount = CartItem::where('user_id', Auth::id())->count();
        $orderCount = Transaction::where('user_id', Auth::id())->count();
        $recentOrders = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', [
            'cartCount' => $cartCount,
            'orderCount' => $orderCount,
            'recentOrders' => $recentOrders,
        ]);
    }
}
