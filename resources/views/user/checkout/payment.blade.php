@extends('layouts.userNavbar')

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Complete Your Payment</h3>

                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Order #{{ $transaction->id }}</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($transaction->total_amount + $transaction->shipping_fee) }}</span>
                    </div>
                    <p class="text-sm text-gray-600">Status: <span class="font-semibold">{{ ucfirst($transaction->status) }}</span></p>
                </div>

                @if($transaction->payment_gateway_id)
                    @if(strpos($transaction->payment_gateway_id, 'test-snap-token') === 0)
                        <div id="payment-container" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
                            <p class="text-blue-700 mb-3 font-semibold">⚠️ Test Mode - Midtrans Keys Not Configured</p>
                            <p class="text-blue-600 text-sm mb-4">
                                This is a test token. In production, configure your Midtrans keys in the `.env` file:
                            </p>
                            <div class="bg-white p-3 rounded text-sm font-mono text-gray-700 mb-4 overflow-auto">
                                MIDTRANS_SERVER_KEY=your_server_key<br>
                                MIDTRANS_CLIENT_KEY=your_client_key
                            </div>
                            <p class="text-blue-600 text-sm mb-4">
                                For now, you can test the checkout flow. Click "Simulate Payment" to proceed:
                            </p>
                            <button onclick="simulatePaymentSuccess()" class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded hover:bg-blue-700">
                                Simulate Payment Success
                            </button>
                        </div>
                    @else
                        <div id="payment-container" class="mb-6">
                            <p class="text-center text-gray-600 mb-4">Click the button below to complete payment:</p>
                            <button id="pay-button" class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded hover:bg-blue-700">
                                Pay Now with Midtrans
                            </button>
                        </div>
                    @endif
                @else
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded text-yellow-700">
                        <p>Error: Payment gateway not initialized. Please try again.</p>
                    </div>
                @endif

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Your payment is being processed securely through Midtrans. You will be redirected after completion.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($transaction->payment_gateway_id && strpos($transaction->payment_gateway_id, 'test-snap-token') === false)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script>
            const payButton = document.getElementById('pay-button');
            const snapToken = '{{ $transaction->payment_gateway_id }}';

            payButton.addEventListener('click', function() {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        // Payment success
                        window.location.href = '/user/dashboard?payment=success&order=' + result.order_id;
                    },
                    onPending: function(result) {
                        // Payment pending
                        console.log('Payment pending:', result);
                    },
                    onError: function(result) {
                        // Payment error
                        alert('Payment failed. Please try again.');
                    },
                    onClose: function() {
                        console.log('Customer closed the popup without finishing the payment');
                    }
                });
            });
        </script>
    @else
        <script>
            function simulatePaymentSuccess() {
                // Simulate payment success for test mode
                const transactionId = '{{ $transaction->id }}';

                // In a real scenario, you would call an endpoint to mark the transaction as paid
                // For now, just redirect to dashboard
                alert('Payment simulated successfully! Transaction ID: ' + transactionId);
                window.location.href = '/user/dashboard?payment=success&order=' + transactionId;
            }
        </script>
    @endif
@endsection
