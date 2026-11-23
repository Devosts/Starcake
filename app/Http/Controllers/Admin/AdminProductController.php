<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));

        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%')
                        ->orWhere('slug', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    private function buildMeta(Request $request)
    {
        return [
            'weight' => $request->input('meta_weight'),
            'dimensions' => $request->input('meta_dimensions'),
            'calories' => $request->input('meta_calories'),
            'servings' => $request->input('meta_servings'),
        ];
    }

    private function saveProduct(Request $request, ?Product $product = null): Product
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $product ? Rule::unique('products', 'slug')->ignore($product->id) : 'unique:products,slug'],
            'sku' => ['nullable', 'string', 'max:255', $product ? Rule::unique('products', 'sku')->ignore($product->id) : 'unique:products,sku'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'is_sale' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'badge' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'image' => [$product ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_existing' => ['nullable', 'array'],
            'gallery_existing.*' => ['string'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']).'-'.Str::random(5);
        $data['is_sale'] = $request->boolean('is_sale');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        $oldImage = $product?->image;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Gallery images - keep existing ones that weren't removed, add new ones
        $gallery = [];
        $removedGallery = [];
        if ($product) {
            $validPaths = $product->gallery ?? [];
            $existingGallery = array_values((array) $request->input('gallery_existing', []));
            $gallery = array_values(array_intersect($existingGallery, $validPaths));
            $removedGallery = array_values(array_diff($validPaths, $gallery));
        }
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $gallery[] = $img->store('products', 'public');
            }
        }
        $data['gallery'] = $gallery;

        $data['meta'] = array_merge($this->buildMeta($request), [
            'seo_title' => $request->input('seo_title'),
            'seo_description' => $request->input('seo_description'),
        ]);

        if ($product) {
            $product->update($data);
        } else {
            $product = Product::create($data);
        }

        if ($oldImage && $oldImage !== $product->image) {
            $this->deleteLocalFile($oldImage);
        }

        foreach ($removedGallery as $path) {
            $this->deleteLocalFile($path);
        }

        return $product;
    }

    private function deleteLocalFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'http://') && ! str_starts_with($path, 'https://')) {
            Storage::disk('public')->delete($path);
        }
    }

    public function store(Request $request)
    {
        $product = $this->saveProduct($request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->saveProduct($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $image = $product->image;
        $gallery = $product->gallery ?? [];

        $product->delete();

        $this->deleteLocalFile($image);

        foreach ($gallery as $path) {
            $this->deleteLocalFile($path);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
