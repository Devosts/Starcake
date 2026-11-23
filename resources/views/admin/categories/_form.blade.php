@php($category = $category ?? null)
<div class="card card-pad">
    <div class="space-y-4">
        <div>
            <label class="label" for="cat_name">Nama Kategori *</label>
            <input id="cat_name" type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="input {{ $errors->has('name') ? 'input-error' : '' }}" />
            @error('name')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="label" for="cat_slug">Slug</label>
            <input id="cat_slug" type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="input" placeholder="Kosongkan untuk auto-generate" />
        </div>
        <div>
            <label class="label" for="cat_image">Gambar</label>
            <input id="cat_image" type="file" name="image" accept="image/jpeg,image/png,image/webp" class="input-file" />
            @error('image')<p class="field-error">{{ $message }}</p>@enderror
            @if(! empty($category) && $category->image)
                <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="mt-2 h-20 w-20 rounded-xl object-cover ring-1 ring-surface-200" />
            @endif
        </div>
        <div>
            <label class="label" for="cat_description">Deskripsi</label>
            <textarea id="cat_description" name="description" rows="3" class="input resize-y">{{ old('description', $category->description ?? '') }}</textarea>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="flex items-center">
                <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-surface-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', ! empty($category) ? $category->is_active : true) ? 'checked' : '' }} class="h-4 w-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500" />
                    Aktif
                </label>
            </div>
            <div>
                <label class="label" for="cat_sort">Urutan</label>
                <input id="cat_sort" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="input" />
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.categories.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="h-4 w-4" /> Simpan
            </button>
        </div>
    </div>
</div>