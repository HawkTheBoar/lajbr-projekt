@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"class="space-y-6">
        @csrf
        @method('PATCH')
        @include('admin.products.partials.form')
        <div class="flex justify-end space-x-3">
            <a href="#" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Product</button>
        </div>
    </form>
</div>
@endsection
