@extends('layouts.adminNavbar')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + New Product
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" placeholder="Search by product name..." value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Price</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Stock</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Weight</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:underline">
                                {{ Str::limit($product->name, 50) }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($product->price) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-xs font-semibold">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $product->weight ? $product->weight . ' g' : '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 {{ $product->active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }} rounded-full text-xs font-semibold">
                                {{ $product->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold" onclick="return confirm('Sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-600">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection
