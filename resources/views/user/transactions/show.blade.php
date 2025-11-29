@extends('layouts.userNavbar')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Order Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ __('Order Details') }}</h1>
                            <p class="text-gray-600 text-sm mt-1">{{ __('Order ID') }}: #{{ $transaction->id }}</p>
                        </div>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-green-100 text-green-800',
                            ];
                            $sc = $statusClasses[$transaction->status] ?? 'bg-red-100 text-red-800';
                        @endphp

                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $sc }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>

                    <!-- Timeline -->
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <div>
                            <p class="font-medium">{{ __('Order Date') }}</p>
                            <p>{{ $transaction->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @if($transaction->paid_at)
                            <div class="border-l border-gray-300 pl-4">
                                <p class="font-medium">{{ __('Paid Date') }}</p>
                                <p>{{ $transaction->paid_at->format('d M Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <hr class="my-6">

                <!-- Order Items -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Order Items') }}</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">{{ __('Product') }}</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">{{ __('Quantity') }}</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">{{ __('Price') }}</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->items as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-4">
                                                @if($item->product && $item->product->images->first())
                                                    <img src="{{ asset('storage/' . $item->product->images->first()->url) }}" alt="{{ $item->product_name }}" class="w-12 h-12 object-cover rounded">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                                    <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center text-gray-900">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-right text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right font-medium text-gray-900">
                                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-6">

                <!-- Shipping Address & Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Shipping Address -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Shipping Address') }}</h2>
                        @if($transaction->address)
                            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                <p class="font-medium text-gray-900">{{ $transaction->address->label }}</p>
                                <p class="text-gray-600 mt-2">{{ $transaction->address->address_text }}</p>
                                <p class="text-gray-600">{{ $transaction->address->city }}, {{ $transaction->address->province }} {{ $transaction->address->postal_code }}</p>
                            </div>
                        @else
                            <p class="text-gray-500">{{ __('Address not available') }}</p>
                        @endif
                    </div>

                    <!-- Order Summary -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Order Summary') }}</h2>
                        <div class="bg-gray-50 p-4 rounded border border-gray-200 space-y-3">
                            <div class="flex justify-between text-gray-700">
                                <span>{{ __('Subtotal') }}</span>
                                <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>{{ __('Shipping Fee') }}</span>
                                <span>Rp {{ number_format($transaction->shipping_fee, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>{{ __('Total') }}</span>
                                <span>Rp {{ number_format($transaction->total_amount + $transaction->shipping_fee, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="mb-6 bg-blue-50 border border-blue-200 p-4 rounded">
                    <p class="text-sm text-gray-600 mb-2">
                        <span class="font-medium">{{ __('Payment Status') }}:</span>
                        @if($transaction->status === 'paid' || $transaction->status === 'completed' || $transaction->status === 'shipped')
                            <span class="text-green-600 font-medium">{{ __('Paid') }}</span>
                        @elseif($transaction->status === 'pending')
                            <span class="text-yellow-600 font-medium">{{ __('Awaiting Payment') }}</span>
                        @elseif($transaction->status === 'cancelled')
                            <span class="text-red-600 font-medium">{{ __('Cancelled') }}</span>
                        @endif
                    </p>
                    @if($transaction->payment_gateway_id)
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">{{ __('Payment Gateway ID') }}:</span>
                            {{ $transaction->payment_gateway_id }}
                        </p>
                    @endif
                </div>

                <!-- Back Button -->
                <div class="flex gap-3">
                    <a href="{{ route('user.dashboard') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded transition">
                        {{ __('Back to Dashboard') }}
                    </a>
                    <a href="{{ route('user.products.index') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition">
                        {{ __('Continue Shopping') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
