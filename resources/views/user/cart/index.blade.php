@extends('layouts.userNavbar')

@section('content')
<div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if($cartItems->count() > 0)
                <div id="cart-grid" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            @foreach($cartItems as $item)
                                <div class="border-b border-gray-200 p-6 hover:bg-gray-50 transition">
                                    <div class="flex gap-4">
                                        <!-- Image -->
                                        <div class="w-24 h-24 bg-gray-200 rounded overflow-hidden">
                                            @if($item->product->images->first())
                                                <img src="{{ asset('storage/' . $item->product->images->first()->url) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-cover">
                                            @endif
                                        </div>

                                        <!-- Details -->
                                        <div class="flex-1">
                                            <a href="{{ route('user.products.show', $item->product->slug) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                                {{ $item->product->name }}
                                            </a>
                                            <p class="text-gray-600 mt-1">Rp {{ number_format($item->product->price) }} each</p>
                                            <div class="mt-3 flex items-center gap-2">
                                                <label class="text-sm font-semibold">Qty:</label>
                                                <form action="{{ route('user.cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="100"
                                                        class="w-16 px-2 py-1 border border-gray-300 rounded">
                                                    <button type="submit" class="text-blue-600 text-sm hover:text-blue-800">Update</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Price & Actions -->
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-900">
                                                Rp {{ number_format($item->product->price * $item->quantity) }}
                                            </p>
                                            <form action="{{ route('user.cart.destroy', $item->id) }}" method="POST" class="mt-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 text-sm hover:text-red-800">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div id="order-summary">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>

                            <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($total) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>Shipping:</span>
                                    <span>TBD</span>
                                </div>
                            </div>

                            <div class="flex justify-between text-lg font-bold text-gray-900 mb-6">
                                <span>Total:</span>
                                <span>Rp {{ number_format($total) }}</span>
                            </div>

                            <a href="{{ route('user.checkout.index') }}" class="w-full px-4 py-3 bg-blue-600 text-white text-center font-semibold rounded hover:bg-blue-700 block">
                                Proceed to Checkout
                            </a>

                            <a href="{{ route('user.products.index') }}" class="w-full px-4 py-3 mt-3 bg-gray-200 text-gray-900 text-center font-semibold rounded hover:bg-gray-300 block">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h3>
                    <p class="text-gray-600 mb-6">Add some items to get started!</p>
                    <a href="{{ route('user.products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
