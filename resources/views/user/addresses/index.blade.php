@extends('layouts.userNavbar')

@section('content')
<div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">My Addresses</h1>
                <a href="{{ route('user.addresses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    + Add New Address
                </a>
            </div>
            @if($addresses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($addresses as $address)
                        <div class="bg-white rounded-lg shadow p-6">
                            @if($address->label)
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $address->label }}</h3>
                            @endif

                            @if($address->is_primary)
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full mb-3">
                                    Primary Address
                                </span>
                            @endif

                            <p class="text-gray-700 mb-2">{{ $address->address_text }}</p>

                            <p class="text-gray-600 text-sm">
                                @if($address->city)
                                    {{ $address->city }}{{ $address->province ? ', ' : '' }}
                                @endif
                                @if($address->province)
                                    {{ $address->province }}
                                @endif
                                @if($address->postal_code)
                                    {{ $address->postal_code }}
                                @endif
                            </p>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('user.addresses.edit', $address) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                    Edit
                                </a>
                                <form action="{{ route('user.addresses.destroy', $address) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold"
                                        onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <p class="text-gray-600 mb-4">No addresses added yet.</p>
                    <a href="{{ route('user.addresses.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Add Your First Address
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
