<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details: {{ $product->name }}</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Product Details</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('products.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <strong>Product:</strong>
                <div>{{ $product->name }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Sell Price:</strong>
                <div>{{ number_format($product->price, 2, ',', '.') }}</div>
            </div>

            <div class="col-md-6">
                <strong>Cost:</strong>
                <div>{{ number_format($product->cost, 2, ',', '.') }}</div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('products.index') }}" class=" btn btn-secondary">Back</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>

            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
    @endsection
</body>
</html>