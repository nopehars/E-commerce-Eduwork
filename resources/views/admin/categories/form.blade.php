@extends('layouts.adminNavbar')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h1>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300">Back</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                @csrf
                @if(isset($category))
                    @method('PATCH')
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category Name *</label>
                    <input type="text" name="name" value="{{ $category->name ?? old('name') }}" required
                        class="@class(['w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500', 'border-red-500' => $errors->has('name'), 'border-gray-300' => ! $errors->has('name')])">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Slug *</label>
                    <input type="text" name="slug" value="{{ $category->slug ?? old('slug') }}" required
                        class="@class(['w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500', 'border-red-500' => $errors->has('slug'), 'border-gray-300' => ! $errors->has('slug')])">
                    @error('slug')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Parent Category</label>
                    <select name="parent_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <option value="">None (Top Level)</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ (isset($category) && $category->parent_id == $parent->id) || old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">{{ $category->description ?? old('description') }}</textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                        {{ isset($category) ? 'Update' : 'Create' }} Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-gray-200 text-gray-900 font-semibold rounded hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
