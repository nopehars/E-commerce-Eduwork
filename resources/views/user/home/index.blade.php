@extends('layouts.userNavbar')

@section('content')
    <div class="border mt-5">
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
                    <p class="text-md opacity-80">iPhone 14 Series</p>
                    <h2 class="text-6xl font-bold mt-2">Up to 10% <br> off Voucher</h2>
                    <a href="#" class="inline-block mt-4 underline">Shop Now →</a>
                </div>

                <img src="{{ asset('img/hero.png') }}" alt="" class="hidden md:block w-90">
            </div>
        </section>
        <section class="max-w-7xl mx-auto px-4 mt-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold ">Flash Sales</h2>
                <div class="flex gap-2 text-sm font-mono bg-red-600 text-white px-5 py-3">
                    <span id="cd-days">03</span>:
                    <span id="cd-hours">23</span>:
                    <span id="cd-minutes">19</span>:
                    <span id="cd-seconds">56</span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Product Card -->
                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk1.jpeg') }}" class="mb-3">
                    <h3 class="font-medium">Keyboard Gamen</h3>
                    <p class="text-red-500">Rp.310.000</p>
                    <p class="text-xs line-through text-gray-400">Rp.660.000</p>
                </div>

                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk2.jpeg') }}" class="mb-3">
                    <h3 class="font-medium">Monitor SPC</h3>
                    <p class="text-red-500">Rp.610.000</p>
                    <p class="text-xs line-through text-gray-400">Rp.1.100.000</p>
                </div>

                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk3.jpeg') }}" class="mb-3">
                    <h3 class="font-medium">Gaming Pad Rexus</h3>
                    <p class="text-red-500">Rp.210.000</p>
                    <p class="text-xs line-through text-gray-400">Rp.400.000</p>
                </div>
                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk1.jpeg') }}" class="mb-3">
                    <h3 class="font-medium">Keyboard Gamen</h3>
                    <p class="text-red-500">Rp.310.000</p>
                    <p class="text-xs line-through text-gray-400">Rp.660.000</p>
                </div>
                <div class="border rounded-lg p-4 text-sm">
                    <img src="{{ asset('img/produk2.jpeg') }}" class="mb-3">
                    <h3 class="font-medium">Monitor SPC</h3>
                    <p class="text-red-500">Rp.610.000</p>
                    <p class="text-xs line-through text-gray-400">Rp.1.100.000</p>
                </div>
            </div>


            <div class="text-center mt-8">
                <a class="inline-block bg-red-500 text-white px-6 py-3 rounded">
                    View All Products
                </a>
            </div>
        </section>
        <section class="max-w-7xl mx-auto px-4 mt-20 mb-10">
            <h2 class="text-2xl font-semibold mb-6">Browse By Category</h2>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-10">
                <div class="border rounded-lg py-6 flex flex-col items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                        stroke="currentColor" class="size-10">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>

                    <span class="text-sm">Camera</span>
                </div>

                <div class="bg-red-500 text-white rounded-lg py-6 flex flex-col items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <span class="text-sm">Phone</span>
                </div>

                <div class="border rounded-lg py-6 flex flex-col items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                    </svg>
                    <span class="text-sm">Computers</span>
                </div>

                <div class="border rounded-lg py-6 flex flex-col items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <span class="text-sm">Phones</span>
                </div>
                <div class="border rounded-lg py-6 flex flex-col items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <span class="text-sm">TV</span>
                </div>

            </div>
        </section>


    </div>
@endsection
