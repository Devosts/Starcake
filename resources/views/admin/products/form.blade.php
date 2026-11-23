@php
    $product = $product ?? null;
    $isEdit = $product !== null;
    $meta = $isEdit ? ($product->meta ?? []) : [];
@endphp

<div class="space-y-5">
    <!-- Detail Produk -->
    <div class="card card-pad">
        <h2 class="font-display text-lg font-semibold text-surface-800">Detail Produk</h2>
        <div class="mt-4 space-y-4">
            <div>
                <label class="label" for="name">Nama Produk *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="input" />
                @error('name')<p class="field-error">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="label" for="category_id">Kategori *</label>
                    <select id="category_id" name="category_id" required class="input">
                        <option value="">Pilih kategori</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id', $product->category_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label" for="sku">SKU</label>
                    <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="input" />
                </div>
            </div>
            <div>
                <label class="label" for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="input resize-y">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="pt-2 border-t border-surface-100">
                <h3 class="font-medium text-surface-700 mb-3">Harga & Stok</h3>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="label" for="price">Harga *</label>
                        <input id="price" type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required class="input" />
                    </div>
                    <div>
                        <label class="label" for="sale_price">Harga Diskon</label>
                        <input id="sale_price" type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}" class="input" />
                    </div>
                    <div>
                        <label class="label" for="stock">Stok</label>
                        <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="input" />
                    </div>
                    <div>
                        <label class="label" for="unit">Satuan</label>
                        <input id="unit" type="text" name="unit" value="{{ old('unit', $product->unit ?? 'pcs') }}" class="input" />
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-surface-700">
                        <input type="checkbox" name="is_sale" value="1" {{ old('is_sale', $product->is_sale ?? false) ? 'checked' : '' }} class="h-4 w-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500" />
                        Diskon Aktif
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Gambar -->
    <div class="card card-pad">
        <h2 class="font-display text-lg font-semibold text-surface-800">Gambar Produk</h2>
        <div class="mt-4 space-y-4">
            <div>
                <label class="label" for="image">Gambar Utama {{ $isEdit ? '' : '*' }}</label>
                <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp" {{ $isEdit ? '' : 'required' }} class="input-file" />
                @error('image')<p class="field-error">{{ $message }}</p>@enderror
                @if($isEdit && $product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mt-2 h-20 w-20 rounded-xl object-cover ring-1 ring-surface-200" />
                @endif
            </div>
            <div>
                <label class="label" for="gallery">Galeri Gambar</label>
                <input id="gallery" type="file" name="gallery[]" accept="image/jpeg,image/png,image/webp" multiple class="input-file" />
                @error('gallery')<p class="field-error">{{ $message }}</p>@enderror
                @error('gallery.*')<p class="field-error">{{ $message }}</p>@enderror
                @if($isEdit && is_array($product->gallery) && count($product->gallery))
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($product->gallery as $index => $img)
                            <div class="relative group">
                                <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}"
                                    class="h-16 w-16 rounded-lg object-cover ring-1 ring-surface-200" />
                                <button type="button"
                                    class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-full bg-rose-500 text-white p-1 hover:bg-rose-600"
                                    onclick="removeGalleryImage(this, {{ $index }})"
                                    aria-label="Hapus gambar">
                                    <x-icon name="x" class="h-4 w-4" />
                                </button>
                                <input type="hidden" name="gallery_existing[{{ $index }}]" value="{{ $img }}" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Pengaturan Tambahan -->
    <div class="card card-pad">
        <h2 class="font-display text-lg font-semibold text-surface-800">Pengaturan Tambahan</h2>
        <div class="mt-4 space-y-5">
            <!-- Katalog -->
            <div>
                <h3 class="font-medium text-surface-700 mb-3">Tampilan Katalog</h3>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label class="label" for="badge">Badge</label>
                        <select id="badge" name="badge" class="input">
                            <option value="">Pilih</option>
                            @foreach(['new' => 'Baru', 'best' => 'Terlaris', 'sale' => 'Diskon'] as $v => $l)
                                <option value="{{ $v }}" {{ old('badge', $product->badge ?? '') == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-surface-700">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} class="h-4 w-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500" />
                            Unggulkan di Beranda
                        </label>
                    </div>
                    <div class="flex items-end">
                        <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-surface-700">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="h-4 w-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500" />
                            Aktif
                        </label>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="pt-4 border-t border-surface-100">
                <h3 class="font-medium text-surface-700 mb-3">Informasi Tambahan</h3>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="label" for="meta_weight">Berat</label>
                        <input id="meta_weight" type="text" name="meta_weight" value="{{ old('meta_weight', $meta['weight'] ?? '') }}" class="input" placeholder="Contoh: 500g" />
                    </div>
                    <div>
                        <label class="label" for="meta_dimensions">Dimensi</label>
                        <input id="meta_dimensions" type="text" name="meta_dimensions" value="{{ old('meta_dimensions', $meta['dimensions'] ?? '') }}" class="input" placeholder="Contoh: 20x20x10 cm" />
                    </div>
                    <div>
                        <label class="label" for="meta_calories">Kalori</label>
                        <input id="meta_calories" type="text" name="meta_calories" value="{{ old('meta_calories', $meta['calories'] ?? '') }}" class="input" placeholder="Contoh: 350" />
                    </div>
                    <div>
                        <label class="label" for="meta_servings">Porsi</label>
                        <input id="meta_servings" type="text" name="meta_servings" value="{{ old('meta_servings', $meta['servings'] ?? '') }}" class="input" placeholder="Contoh: 8" />
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="pt-4 border-t border-surface-100">
                <h3 class="font-medium text-surface-700 mb-3">SEO</h3>
                <div class="space-y-4">
                    <div>
                        <label class="label" for="seo_title">Meta Judul (SEO)</label>
                        <input id="seo_title" type="text" name="seo_title" value="{{ old('seo_title', $meta['seo_title'] ?? '') }}" class="input" placeholder="Kosongkan untuk pakai nama produk" />
                    </div>
                    <div>
                        <label class="label" for="seo_description">Meta Deskripsi (SEO)</label>
                        <textarea id="seo_description" name="seo_description" rows="2" class="input resize-y" placeholder="Kosongkan untuk pakai deskripsi produk">{{ old('seo_description', $meta['seo_description'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 pt-2">
        <a href="{{ route('admin.products.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">
            <x-icon name="check" class="h-4 w-4" /> Simpan Produk
        </button>
    </div>
</div>

@push('scripts')
<script>
    function removeGalleryImage(button, index) {
        if (confirm('Hapus gambar ini dari galeri?')) {
            const container = button.closest('.relative');
            container.remove();
        }
    }
</script>
@endpush