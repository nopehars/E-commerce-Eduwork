<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get dashboard statistics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalOrders = Transaction::count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $completedOrders = Transaction::where('status', 'completed')->count();

        // Calculate total revenue from completed orders
        $completedTransactions = Transaction::where('status', 'completed')->get();
        $totalRevenue = $completedTransactions->sum(function($transaction) {
            return $transaction->total_amount + $transaction->shipping_fee;
        });

        // Get recent orders for display
        $recentOrders = Transaction::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
        ]);
    }
}
