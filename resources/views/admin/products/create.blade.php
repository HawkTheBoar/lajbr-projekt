@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Create Product</h1>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.products.partials.form')
        <div class="flex justify-end space-x-3">
            <a href="#" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Create Product</button>
        </div>
    </form>
</div>
@endsection
