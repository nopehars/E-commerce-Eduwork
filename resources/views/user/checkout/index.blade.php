{{-- resources/views/user/checkout/index.blade.php --}}
@extends('layouts.userNavbar')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('user.checkout.pay') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- LEFT: Billing  -->
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Billing Details</h2>

                <div class="bg-white rounded-lg shadow p-8">

                    @if($addresses->count() > 0)
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Choose a shipping address</p>
                            <div class="space-y-3">
                                @foreach($addresses as $address)
                                    <label class="flex items-start p-4 border rounded hover:border-gray-300 transition cursor-pointer {{ $loop->first ? 'border-gray-300' : 'border-gray-200' }}">
                                        <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            @if($address->label)
                                                <p class="font-semibold text-gray-900">{{ $address->label }}</p>
                                            @endif

                                            @if($address->recipient_name)
                                                <p class="text-sm text-gray-700">Recipient: <span class="font-medium">{{ $address->recipient_name }}</span></p>
                                            @endif

                                            @if($address->phone)
                                                <p class="text-sm text-gray-700">Phone: <span class="font-medium">{{ $address->phone }}</span></p>
                                            @endif

                                            <p class="text-gray-700 text-sm">{{ $address->address_text }}</p>
                                            <p class="mb-1">@if($address->district)District: {{ $address->district }}@endif</p>
                                            <p class="mb-1">@if($address->subdistrict)Subdistrict: {{ $address->subdistrict }}@endif</p>
                                            <p class="text-gray-600 text-xs">
                                                {{ $address->city ?? '' }}{{ $address->city && $address->province ? ', ' : '' }}{{ $address->province ?? '' }}
                                                {{ $address->postal_code ? ' ' . $address->postal_code : '' }}
                                            </p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message to seller (optional)
                        </label>
                        <textarea name="message" rows="4"
                            class="w-full bg-gray-50 border border-gray-200 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-200"
                            placeholder="Write a message to the seller (optional)...">{{ old('message') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Order Summary -->
            <div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Your Order</h3>

                    <div class="space-y-3 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if($item->product && $item->product->images->first())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->url) }}"
                                             class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded"></div>
                                    @endif
                                    <div>
                                        <p class="text-sm text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} • {{ number_format((($item->product->weight ?? 1000) * $item->quantity), 0, ',', '.') }} g</p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-900">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-gray-700 mt-2">
                            <span class="text-sm">Total Berat:</span>
                            <span id="weightText" class="text-sm">{{ ($totalWeight >= 1000) ? number_format($totalWeight / 1000, 2, ',', '.') . ' kg' : number_format($totalWeight, 0, ',', '.') . ' g' }}</span>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Courier</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="jne"> <span class="text-sm">JNE</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="jnt"> <span class="text-sm">J&T</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="sicepat"> <span class="text-sm">Sicepat</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="anteraja"> <span class="text-sm">Anteraja</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="pos"> <span class="text-sm">POS</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="tiki"> <span class="text-sm">TIKI</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="wahana"> <span class="text-sm">Wahana</span></label>
                                <label class="flex items-center gap-2"><input type="radio" name="courier" value="lion"> <span class="text-sm">Lion Parcel</span></label>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="btnCheckOngkir" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow">
                                    Check Shipping
                                </button>
                                <div id="checkLoader" class="mt-2" style="display:none;">
                                    <svg class="animate-spin h-6 w-6 text-red-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shipping</label>
                            <input type="hidden" name="shipping_fee" id="shippingFee" value="0">
                            <p id="shippingText" class="text-gray-700 text-sm">Rp 0</p>
                            <p id="shippingHint" class="text-xs text-gray-500"></p>
                        </div>

                        <div class="mt-4 results-section hidden">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Available Services</h4>
                            <div id="resultsContainer" class="grid grid-cols-1 gap-3"></div>
                        </div>

                        <div class="flex justify-between text-lg font-bold text-gray-900 mt-4">
                            <span>Total:</span>
                            <span id="totalAmount">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" id="checkout-submit"
                            class="w-full px-4 py-3 bg-red-600 text-white font-bold rounded hover:bg-red-700">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(function () {

    const subtotal = {{ $total }};
    const totalWeight = {{ $totalWeight }};

    function formatRp(n) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
    }

    function formatWeight(g) {
        if (!g) return '-';
        if (g >= 1000) return (g/1000).toFixed(2).replace('.', ',') + ' kg';
        return g + ' g';
    }

    function formatCurrency(n) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n);
    }

    function updateTotal(shipping) {
        $('#shippingText').text(formatRp(shipping));
        $('#totalAmount').text(formatRp(subtotal + shipping));
    }

    // Check Shipping button
    let isProcessing = false;
    $('#btnCheckOngkir').on('click', function () {
        if (isProcessing) return;

        const addressId = $('input[name="address_id"]:checked').val();
        const courier = $('input[name="courier"]:checked').val();

        if (!addressId || !courier) {
            alert('Please select an address and courier first.');
            return;
        }

        isProcessing = true;
        $('#checkLoader').show();
        $('#resultsContainer').empty();
        $('.results-section').addClass('hidden');
        $('#shippingHint').text('Calculating shipping...');

        $.post("{{ route('user.checkout.ongkir') }}", {
            _token: $('meta[name="csrf-token"]').attr('content'),
            address_id: addressId,
            courier: courier
        }).done(function (data) {
            if (!data || data.length === 0) {
                $('#shippingHint').text('Shipping not available');
                $('#shippingFee').val(0);
                updateTotal(0);
                return;
            }

            // Populate results
            $('#resultsContainer').empty();
            $.each(data, function (i, svc) {
                const cost = parseInt(svc.cost || 0);
                const etd = svc.etd || '-';
                const title = svc.service || svc.code || ('Service ' + (i+1));

                const card = $(`
                    <button type="button" class="ongkir-option w-full text-left p-3 bg-white rounded-xl shadow border border-gray-200 flex items-center justify-between hover:ring-2 hover:ring-red-200">
                        <div>
                            <div class="text-sm font-medium text-gray-800">${title}</div>
                            <div class="text-xs text-gray-500 mt-1">ETA: ${etd} days</div>
                        </div>
                        <div class="text-red-700 font-bold">${formatCurrency(cost)}</div>
                    </button>
                `);

                card.data('cost', cost);
                card.data('service', title);

                $('#resultsContainer').append(card);
            });

            $('.results-section').removeClass('hidden');
            $('#shippingHint').text('Select a service to set shipping');

        }).fail(function (xhr) {
            const json = xhr.responseJSON || {};
            const message = json.message || (json.error && json.error.message) || 'Failed to calculate shipping';
            $('#shippingHint').text(message);
            $('#shippingFee').val(0);
            updateTotal(0);
            console.error('Shipping error', xhr);
        }).always(function () {
            $('#checkLoader').hide();
            isProcessing = false;
        });
    });

    // When user selects a service
    $(document).on('click', '.ongkir-option', function () {
        $('.ongkir-option').removeClass('ring-2 ring-red-500');
        $(this).addClass('ring-2 ring-red-500');

        const cost = $(this).data('cost') || 0;
        const service = $(this).data('service') || '';

        $('#shippingFee').val(cost);
        $('#shippingHint').text(service);
        updateTotal(parseInt(cost));
    });

    // trigger initial selection
    const initialAddress = $('input[name="address_id"]:checked').val();
    if (initialAddress && !$('input[name="courier"]:checked').length) {
        $('input[name="courier"]').first().prop('checked', true);
    }

});
</script>
@endsection
