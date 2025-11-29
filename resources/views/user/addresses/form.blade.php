@extends('layouts.userNavbar')

@section('content')
<div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ isset($address) ? route('user.addresses.update', $address) : route('user.addresses.store') }}" method="POST">
                    @csrf
                    @if(isset($address))
                        @method('PUT')
                    @endif

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Address Label (e.g., Home, Office)</label>
                        <input type="text" name="label" value="{{ $address->label ?? old('label') }}" placeholder="Home"
                            class="@class(['w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500', 'border-red-500' => $errors->has('label'), 'border-gray-300' => ! $errors->has('label')])">
                        @error('label')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Address *</label>
                        <textarea name="address_text" rows="3" placeholder="Street address, building, etc." required
                            class="@class(['w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500', 'border-red-500' => $errors->has('address_text'), 'border-gray-300' => ! $errors->has('address_text')])">{{ $address->address_text ?? old('address_text') }}</textarea>
                        @error('address_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                            <input type="text" name="city" value="{{ $address->city ?? old('city') }}" placeholder="City"
                                class="@class(['w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500', 'border-red-500' => $errors->has('city'), 'border-gray-300' => ! $errors->has('city')])">
                            @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Province</label>
                            <input type="text" name="province" value="{{ $address->province ?? old('province') }}" placeholder="Province"
                                class="@class(['w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500', 'border-red-500' => $errors->has('province'), 'border-gray-300' => ! $errors->has('province')])">
                            @error('province')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ $address->postal_code ?? old('postal_code') }}" placeholder="12345"
                            class="@class(['w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500', 'border-red-500' => $errors->has('postal_code'), 'border-gray-300' => ! $errors->has('postal_code')])">
                        @error('postal_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_primary" value="1" {{ (isset($address) && $address->is_primary) || old('is_primary') ? 'checked' : '' }}
                                class="rounded border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Set as primary address</span>
                        </label>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                            {{ isset($address) ? 'Update Address' : 'Add Address' }}
                        </button>
                        <a href="{{ route('user.addresses.index') }}" class="px-6 py-2 bg-gray-200 text-gray-900 font-semibold rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
