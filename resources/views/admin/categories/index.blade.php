@extends('layouts.adminNavbar')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + New Category
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" placeholder="Search by category name..." value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
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
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Slug</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Parent</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $category->parent?->name ?? 'None' }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold" onclick="return confirm('Sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-600">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endsection
