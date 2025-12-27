@extends('layouts.userNavbar')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Images Carousel -->
                    <div>
                        <div class="relative aspect-square bg-gray-200 rounded-lg overflow-hidden mb-4 group">
                            <img id="carouselImage"
                                src="{{ asset('storage/' . ($product->images->first()->url ?? '')) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">

                            @if($product->images->count() > 1)

                            @endif
                        </div>

                        @if($product->images->count() > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->images as $idx => $image)
                                    <img src="{{ asset('storage/' . $image->url) }}"
                                        alt="{{ $image->alt_text }}"
                                        class="w-full aspect-square object-cover rounded cursor-pointer hover:opacity-75 thumbnail-img"
                                        data-index="{{ $idx }}"
                                        onclick="goToImage({{ $idx }})">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <script>
                        let currentImageIndex = 0;
                        const totalImages = {{ $product->images->count() }};

                        function goToImage(index) {
                            currentImageIndex = index;
                            updateImage();
                        }

                        function updateImage() {
                            const images = document.querySelectorAll('.thumbnail-img');
                            const img = images[currentImageIndex];
                            if (img) {
                                document.getElementById('carouselImage').src = img.src;
                            }
                        }
                    </script>

                    <!-- Details -->
                    <div>
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-medium">Category:</span> {{ $product->category?->name ?? 'N/A' }}
                        </p>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-medium">Weight:</span>
                            {{ $product->weight ? $product->weight . ' g (' . number_format($product->weight / 1000, 2) . ' kg)' : 'N/A' }}
                        </p>

                        <p class="text-3xl font-bold text-blue-600 mb-6">Rp {{ number_format($product->price) }}</p>

                        <div class="mb-6">
                            <span class="text-lg font-semibold text-gray-700">Stock: </span>
                            <span class="text-lg {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}
                            </span>
                        </div>

                        @if($product->short_description)
                            <p class="text-gray-700 mb-6">{{ $product->short_description }}</p>
                        @endif

                        @if($product->description)
                            <div class="mb-8 pb-8 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                                <p class="text-gray-700">{{ $product->description }}</p>
                            </div>
                        @endif

                        @auth
                            @if($product->stock > 0)
                                <form action="{{ route('user.cart.store') }}" method="POST" class="mb-6">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex gap-4 mb-4">
                                        <div class="flex items-center">
                                            <label class="mr-3 font-semibold">Quantity:</label>
                                            <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1"
                                                class="w-20 px-3 py-2 border border-gray-300 rounded">
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded hover:bg-blue-700">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="mb-6 p-4 bg-gray-100 rounded">
                                <p class="text-gray-700">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to add items to cart.</p>
                            </div>
                        @endauth

                        <div class="mt-6">
                            <a href="{{ route('user.products.index') }}" class="px-6 py-2 bg-gray-600 text-white font-semibold rounded hover:bg-gray-700">
                                Back to Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
