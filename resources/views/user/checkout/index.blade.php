@extends('layouts.userNavbar')

@section('content')
<div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('user.checkout.pay') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf

                <!-- Shipping Address -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Shipping Address</h3>

                        @if($addresses->count() > 0)
                            <div class="space-y-3">
                                @foreach($addresses as $address)
                                    <label class="flex items-start p-4 border-2 border-gray-200 rounded cursor-pointer hover:border-blue-500 transition"
                                        {{ $loop->first ? 'checked' : '' }}>
                                        <input type="radio" name="address_id" value="{{ $address->id }}"
                                            class="mt-1 {{ $loop->first ? 'checked' : '' }}" required>
                                        <div class="ml-3">
                                            @if($address->label)
                                                <p class="font-semibold text-gray-900">{{ $address->label }}</p>
                                            @endif
                                            <p class="text-gray-700 text-sm">{{ $address->address_text }}</p>
                                            <p class="text-gray-600 text-xs">
                                                {{ $address->city ?? '' }}{{ $address->city && $address->province ? ', ' : '' }}{{ $address->province ?? '' }}
                                                {{ $address->postal_code ? ' ' . $address->postal_code : '' }}
                                            </p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 mb-4">No addresses yet. Please add one first.</p>
                            <a href="{{ route('user.addresses.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Add Address
                            </a>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->product->price * $item->quantity) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Shipping & Total -->
                <div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Shipping & Payment</h3>

                        <!-- Shipping Fee -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Shipping Fee (Rp)</label>
                            <input type="number" name="shipping_fee" value="10000" min="0" required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                                id="shippingFee">
                        </div>

                        <!-- Summary -->
                        <div class="space-y-4 pb-6 border-b border-gray-200">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($total) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Shipping:</span>
                                <span id="shippingDisplay">Rp 10,000</span>
                            </div>
                        </div>

                        <div class="flex justify-between text-lg font-bold text-gray-900 mb-6 mt-4">
                            <span>Total:</span>
                            <span id="totalAmount">Rp {{ number_format($total + 10000) }}</span>
                        </div>

                        @if($addresses->count() > 0)
                            <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white font-bold rounded hover:bg-green-700">
                                Proceed to Payment
                            </button>
                        @else
                            <button type="button" disabled class="w-full px-4 py-3 bg-gray-400 text-white font-bold rounded cursor-not-allowed">
                                Add Address First
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const subtotal = {{ $total }};
        const shippingFeeInput = document.getElementById('shippingFee');
        const shippingDisplay = document.getElementById('shippingDisplay');
        const totalAmount = document.getElementById('totalAmount');

        shippingFeeInput.addEventListener('change', function() {
            const shippingFee = parseInt(this.value) || 0;
            shippingDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(shippingFee);
            totalAmount.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal + shippingFee);
        });
    </script>
@endsection
