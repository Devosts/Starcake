@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="space-y-5">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Tambah Produk</h1>
        <p class="text-sm text-surface-500">Lengkapi detail produk baru.</p>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.products.form')
    </form>
</div>
@endsection