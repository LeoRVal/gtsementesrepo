<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Products</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('products.create') }}" type="button" class="btn btn-sm btn-outline-secondary">Add Product</a>
                </div>
            </div>
        </div>

        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Cost</th>
                        <th>Profit</th>
                        <th>Stock</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2, ',', '.') }}</td>
                        <td class="table-warning">{{ number_format($product->cost, 2, ',', '.') }}</td>
                        <td class="table-warning">
                            <!-- Profit Calculation (Price - Cost) -->
                            {{ number_format($product->price - $product->cost, 2, ',', '.') }}
                        </td>
                        <td>
                            @if ($product->stock <= 0)
                                <span class="badge bg-danger">{{ $product->stock }}</span>
                            @elseif ($product->stock <= 10)
                                <span class="badge bg-warning">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    @endsection
</body>
</html>