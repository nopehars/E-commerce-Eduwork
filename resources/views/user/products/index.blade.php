@extends('layouts.userNavbar')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="mb-8">
                <form method="GET" action="{{ route('user.products.index') }}" class="flex gap-4">
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Search
                    </button>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <div class="aspect-square bg-gray-200 rounded-t-lg overflow-hidden">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->url) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <a href="{{ route('user.products.show', $product->slug) }}" class="font-semibold text-gray-800 hover:text-blue-600">
                                {{ \Illuminate\Support\Str::limit($product->name, 50) }}
                            </a>
                            <p class="text-sm text-gray-600 mt-1">{{ $product->category?->name }}</p>
                            <p class="text-lg font-bold text-blue-600 mt-2">Rp {{ number_format($product->price) }}</p>
                            <p class="text-sm text-gray-500 mt-1">Stock: {{ $product->stock }}</p>
                            <a href="{{ route('user.products.show', $product->slug) }}"
                                class="mt-4 block w-full px-4 py-2 bg-blue-600 text-white text-center rounded hover:bg-blue-700">
                                View Details
                            </a>
                            @auth
                                @if($product->stock > 0)
                                    <form action="{{ route('user.cart.store') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full mt-2 px-4 py-2 bg-green-600 text-white text-center rounded hover:bg-green-700">Add to Cart</button>
                                    </form>
                                @else
                                    <div class="mt-2 text-sm text-red-600 font-semibold">Out of stock</div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12">
                        <p class="text-gray-600">No products found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
