<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4 class="mb-1">Catalog</h4>
            <div class="text-end">
                <span class="text-muted">Prices in: {{ $today->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="bg-white rounded shadow-sm p-2">
                <table class="table table-sm align-middle mb-0 w-auto">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-end text-nowrap">Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="text-break">{{ $product->name }}</td>
                            <td class="text-end text-nowrap">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No product found...</td>
                        </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</body>
</html>