<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display the specified transaction (order).
     * User can only view their own transactions.
     */
    public function show(Transaction $transaction)
    {
        // Check if transaction belongs to authenticated user
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. This order does not belong to you.');
        }

        // Load transaction with relationships
        $transaction->load('items.product', 'address', 'user');

        return view('user.transactions.show', [
            'transaction' => $transaction,
        ]);
    }
}
