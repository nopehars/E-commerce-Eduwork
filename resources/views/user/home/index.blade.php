@extends('layouts.userNavbar')

@section('content')
    <div class="border">
        <section class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- Sidebar -->
            <aside class="hidden lg:block col-span-1 border-r pr-4">
                <ul class="space-y-3 text-sm">
                    <li class="font-medium">Woman’s Fashion</li>
                    <li class="font-medium">Men’s Fashion</li>
                    <li class="text-gray-600">Electronics</li>
                    <li class="text-gray-600">Home & Lifestyle</li>
                    <li class="text-gray-600">Medicine</li>
                    <li class="text-gray-600">Sports & Outdoor</li>
                    <li class="text-gray-600">Baby’s & Toys</li>
                    <li class="text-gray-600">Groceries & Pets</li>
                    <li class="text-gray-600">Health & Beauty</li>
                </ul>
            </aside>

            <!-- Banner -->
            <div class="lg:col-span-3 bg-black rounded-lg p-8 flex items-center justify-between text-white">
                <div>
                    <p class="text-sm opacity-80">iPhone 14 Series</p>
                    <h2 class="text-3xl font-bold mt-2">Up to 10% <br> off Voucher</h2>
                    <a href="#" class="inline-block mt-4 underline">Shop Now →</a>
                </div>

                <img src="/images/iphone.png" alt="" class="hidden md:block w-60">
            </div>
        </section>
        <section class="max-w-7xl mx-auto px-4 mt-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold">Flash Sales</h2>
                <div class="flex gap-2 text-sm font-mono">
                    <span>03</span>:<span>23</span>:<span>19</span>:<span>56</span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Product Card -->
                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk1.jpeg') }}"
                        class="mb-3">
                    <h3 class="font-medium">Gaming Pad Rexus</h3>
                    <p class="text-red-500">Rp.210.000</p>
                    <p class="text-xs line-through text-gray-400">$160</p>
                </div>

                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk2.jpeg') }}"
                        class="mb-3">
                    <h3 class="font-medium">Gaming Pad Rexus</h3>
                    <p class="text-red-500">Rp.210.000</p>
                    <p class="text-xs line-through text-gray-400">$160</p>
                </div>

                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk3.jpeg') }}"
                        class="mb-3">
                    <h3 class="font-medium">Gaming Pad Rexus</h3>
                    <p class="text-red-500">Rp.210.000</p>
                    <p class="text-xs line-through text-gray-400">$160</p>
                </div>
                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk1.jpeg') }}"
                        class="mb-3">
                    <h3 class="font-medium">Gaming Pad Rexus</h3>
                    <p class="text-red-500">Rp.210.000</p>
                    <p class="text-xs line-through text-gray-400">$160</p>
                </div>
                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk2.jpeg') }}"
                        class="mb-3">
                    <h3 class="font-medium">Gaming Pad Rexus</h3>
                    <p class="text-red-500">Rp.210.000</p>
                    <p class="text-xs line-through text-gray-400">$160</p>
                </div>
            </div>


            <div class="text-center mt-8">
                <a class="inline-block bg-red-500 text-white px-6 py-3 rounded">
                    View All Products
                </a>
            </div>
        </section>


    </div>
@endsection
