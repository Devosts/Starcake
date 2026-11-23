@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="space-y-5">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Edit Produk</h1>
        <p class="text-sm text-surface-500">{{ $product->name }}</p>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        @include('admin.products.form')
    </form>
</div>
@endsection