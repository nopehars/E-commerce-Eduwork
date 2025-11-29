@extends('layouts.adminNavbar')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PATCH')
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ $product->name ?? old('name') }}" required
                        @class([
                            'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                            'border-red-500' => $errors->has('name'),
                            'border-gray-300' => !$errors->has('name'),
                        ])>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Slug *</label>
                        <input type="text" name="slug" value="{{ $product->slug ?? old('slug') }}" required
                            @class([
                                'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                                'border-red-500' => $errors->has('slug'),
                                'border-gray-300' => !$errors->has('slug'),
                            ])>
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <select name="category_id"
                            @class([
                                'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                                'border-red-500' => $errors->has('category_id'),
                                'border-gray-300' => !$errors->has('category_id'),
                            ])>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (isset($product) && $product->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SKU</label>
                        <input type="text" name="sku" value="{{ $product->sku ?? old('sku') }}"
                            @class([
                                'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                                'border-red-500' => $errors->has('sku'),
                                'border-gray-300' => !$errors->has('sku'),
                            ])>
                        @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price (Rp) *</label>
                        <input type="number" name="price" value="{{ $product->price ?? old('price') }}" required min="0"
                            @class([
                                'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                                'border-red-500' => $errors->has('price'),
                                'border-gray-300' => !$errors->has('price'),
                            ])>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stock *</label>
                    <input type="number" name="stock" value="{{ $product->stock ?? old('stock') }}" required min="0"
                        @class([
                            'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                            'border-red-500' => $errors->has('stock'),
                            'border-gray-300' => !$errors->has('stock'),
                        ])>
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description</label>
                    <input type="text" name="short_description" value="{{ $product->short_description ?? old('short_description') }}"
                        @class([
                            'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                            'border-gray-300' => true,
                        ])>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Description</label>
                    <textarea name="description" rows="5"
                        @class([
                            'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                            'border-gray-300' => true,
                        ])>{{ $product->description ?? old('description') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Images</label>
                    <input id="imagesInput" type="file" name="images[]" multiple accept="image/*"
                        data-existing-count="{{ isset($product) ? $product->images->count() : 0 }}"
                        @class([
                            'w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500',
                            'border-gray-300' => true,
                        ])>
                    <p id="imagesNote" class="text-sm text-gray-500 mt-1">Upload JPG, PNG, or GIF. Total images (existing + new) max 3. Images will be compressed to ~1MB.</p>

                    @if(isset($product) && $product->images->count() > 0)
                        <div class="mt-4">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Current Images:</p>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->images()->orderBy('position')->get() as $image)
                                    <div class="relative bg-gray-50 rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->url) }}" class="w-full aspect-square object-cover">
                                            <div class="p-2 flex justify-between items-center">
                                                <button type="button" class="text-xs px-2 py-1 bg-green-600 text-white rounded btn-set-primary" data-set-primary-url="{{ route('admin.products.images.setPrimary', [$product, $image]) }}">Set Primary</button>

                                                <button type="button" class="text-xs px-2 py-1 bg-red-600 text-white rounded btn-delete-image" data-delete-url="{{ route('admin.products.images.destroy', $image) }}">Delete</button>
                                            </div>
                                        @if($image->position === 0)
                                            <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">Primary</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
        <script>
            (function(){
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                // Set Primary
                document.querySelectorAll('.btn-set-primary').forEach(btn => {
                    btn.addEventListener('click', async function(){
                        const url = this.dataset.setPrimaryUrl;
                        if (!confirm('Set this image as primary?')) return;
                        try {
                            const res = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json',
                                }
                            });
                            if (!res.ok) throw new Error('Request failed');
                            // refresh page to show change
                            location.reload();
                        } catch (e) {
                            alert('Gagal set primary image.');
                            console.error(e);
                        }
                    });
                });

                // Delete Image
                document.querySelectorAll('.btn-delete-image').forEach(btn => {
                    btn.addEventListener('click', async function(){
                        const url = this.dataset.deleteUrl;
                        if (!confirm('Delete this image?')) return;
                        try {
                            const res = await fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json',
                                }
                            });
                            if (!res.ok) throw new Error('Request failed');
                            location.reload();
                        } catch (e) {
                            alert('Gagal menghapus gambar.');
                            console.error(e);
                        }
                    });
                });
            })();
        </script>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="active" value="1" {{ (isset($product) && $product->active) || old('active') ? 'checked' : '' }} class="rounded border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                        {{ isset($product) ? 'Update' : 'Create' }} Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-gray-200 text-gray-900 font-semibold rounded hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
            <script>
                (function(){
                    const input = document.getElementById('imagesInput');
                    if (!input) return;
                    const existing = parseInt(input.dataset.existingCount || '0', 10);
                    const maxTotal = 3;
                    input.addEventListener('change', function(e){
                        const files = Array.from(this.files || []);
                        const remaining = maxTotal - existing;
                        if (files.length > remaining) {
                            alert('You can only upload ' + remaining + ' more image(s).');
                            // Reset selection
                            this.value = null;
                        }
                    });
                })();
            </script>
        </div>
    </div>
@endsection
