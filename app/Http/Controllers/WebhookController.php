<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function midtrans(Request $request)
    {
        try {
            $serverKey = env('MIDTRANS_SERVER_KEY');
            $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            // Verify signature if available
            if (isset($request->signature_key) && $request->signature_key !== $hashed) {
                Log::warning('Invalid Midtrans signature', ['order_id' => $request->order_id]);
                return response()->json(['status' => 'error'], 403);
            }

            $transaction = Transaction::findOrFail($request->order_id);

            // Update transaction status based on Midtrans response
            $statusMap = [
                'settlement' => 'paid',
                'pending' => 'pending',
                'deny' => 'cancelled',
                'expire' => 'cancelled',
                'cancel' => 'cancelled',
            ];

            $newStatus = $statusMap[$request->transaction_status] ?? $transaction->status;

            $transaction->update([
                'status' => $newStatus,
                'paid_at' => in_array($newStatus, ['paid', 'shipped', 'completed']) ? now() : $transaction->paid_at,
            ]);

            Log::info('Midtrans webhook processed', [
                'order_id' => $request->order_id,
                'status' => $newStatus,
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error'], 500);
        }
    }
}
