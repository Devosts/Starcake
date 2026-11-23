@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="space-y-5">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Edit Kategori</h1>
        <p class="text-sm text-surface-500">{{ $category->name }}</p>
    </div>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="max-w-xl">
        @csrf @method('PUT')
        @include('admin.categories._form')
    </form>
</div>
@endsection