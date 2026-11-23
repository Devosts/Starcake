@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="space-y-5">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Tambah Kategori</h1>
        <p class="text-sm text-surface-500">Buat kategori baru untuk katalog.</p>
    </div>
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="max-w-xl">
        @csrf
        @include('admin.categories._form')
    </form>
</div>
@endsection