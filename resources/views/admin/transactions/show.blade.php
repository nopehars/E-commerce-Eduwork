@extends('layouts.adminNavbar')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $transaction->id }}</h1>
                        <p class="text-gray-600">{{ $transaction->created_at->format('F d, Y H:i') }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold text-white
                        {{ $transaction->status === 'paid' ? 'bg-green-600' : '' }}
                        {{ $transaction->status === 'pending' ? 'bg-yellow-600' : '' }}
                        {{ $transaction->status === 'cancelled' ? 'bg-red-600' : '' }}
                        {{ $transaction->status === 'shipped' ? 'bg-blue-600' : '' }}
                        {{ $transaction->status === 'completed' ? 'bg-purple-600' : '' }}
                    ">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-bold text-gray-900 mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach($transaction->items as $item)
                            <div class="flex justify-between pb-4 border-b border-gray-200 last:border-b-0">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-600">SKU: {{ $item->product_sku ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp {{ number_format($item->price * $item->quantity) }}</p>
                                    <p class="text-xs text-gray-600">Rp {{ number_format($item->price) }} each</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            @if(!in_array($transaction->status, ['completed', 'cancelled']))
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Update Status</h3>
                    <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" class="flex gap-3">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="flex-1 px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $transaction->status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="shipped" {{ $transaction->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                            Update
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div>
            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Customer</h3>
                <p class="font-semibold text-gray-900">{{ $transaction->user->name }}</p>
                <p class="text-sm text-gray-600">{{ $transaction->user->email }}</p>
                <p class="text-sm text-gray-600">{{ $transaction->user->phone ?? 'N/A' }}</p>
            </div>

            <!-- Shipping Address -->
            @if($transaction->address)
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4">Shipping Address</h3>
                    @if($transaction->address->label)
                        <p class="font-semibold text-gray-900 text-sm">{{ $transaction->address->label }}</p>
                    @endif
                    <p class="text-sm text-gray-600">{{ $transaction->address->address_text }}</p>
                    <p class="mb-1">@if($transaction->address->district)District: {{ $transaction->address->district }}@endif</p>
                    <p class="mb-1">@if($transaction->address->subdistrict)Subdistrict: {{ $transaction->address->subdistrict }}@endif</p>
                    <p class="text-xs text-gray-600 mt-1">
                        {{ $transaction->address->city }}{{ $transaction->address->city && $transaction->address->province ? ', ' : '' }}
                        {{ $transaction->address->province }}
                        {{ $transaction->address->postal_code }}
                    </p>
                </div>
            @endif

            <!-- Payment Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Payment Details</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($transaction->total_amount) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($transaction->shipping_fee) }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="font-semibold text-gray-900">Total</span>
                        <span class="font-bold text-lg text-gray-900">Rp {{ number_format($transaction->total_amount + $transaction->shipping_fee) }}</span>
                    </div>
                    @if($transaction->paid_at)
                        <div class="text-xs text-gray-600">
                            Paid on {{ $transaction->paid_at->format('M d, Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.transactions.index') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300">
            Back to Orders
        </a>
    </div>
@endsection
