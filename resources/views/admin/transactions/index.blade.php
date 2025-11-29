@extends('layouts.adminNavbar')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Recent Orders</h1>
    </div>

    <!-- Search & Filter Form -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" placeholder="Search by customer name or order #..." value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Search
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.transactions.index') }}" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Order #</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Customer</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Amount</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">#{{ $transaction->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->user->name }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($transaction->total_amount + $transaction->shipping_fee) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $transaction->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $transaction->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $transaction->status === 'shipped' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $transaction->status === 'completed' ? 'bg-purple-100 text-purple-800' : '' }}
                            ">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-800 font-semibold">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-600">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
@endsection
