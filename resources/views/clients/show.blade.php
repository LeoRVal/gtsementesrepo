<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details: {{ $client->name }}</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Client Details</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('clients.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        @include('layouts.messages')

        <div class="row mb-3">
            <div class="col-md-12">
                <h3>{{ $client->name }}</h3>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>CNPJ:</strong>
                <div>{{ $client->cnpj }}</div>
            </div>

            <div class="col-md-6">
                <strong>Address:</strong>
                <div>{{ $client->address }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>WhatsApp:</strong>
                <div>{{ $client->whatsapp }}</div>
            </div>

            <div class="col-md-6">
                <strong>Address:</strong>
                <div>{{ $client->email }}</div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('clients.index') }}" class=" btn btn-secondary">Back</a>
            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">Edit</a>

            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger">Delete</button>
            </form>
        </div>


        <!-- Client Orders -->
        <h2 class="mt-5">Client Orders</h2>
        @if($orders->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Products</th>
                    <th>Total Units</th>
                    <th>Total Price (R$)</th>
                    <th>Total Cost (R$)</th>
                    <th>Profit (R$)</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php
                $totalOrders = $orders->count();
                $totalProducts = 0;
                $totalUnits = 0;
                $totalValueSum = 0;
                $totalCostSum = 0;
                $totalProfitSum = 0;
                @endphp

                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ date('d/m/Y', strtotime($order->date)) }}</td>
                    <td>{{ $order->products->count() }}</td> <!-- Counting products in the order -->
                    <td>{{ $order->products->sum('pivot.quantity') }}</td>
                    <td>R$ {{ number_format($order->products->sum(function ($product) {
                        return $product->pivot->quantity * $product->pivot->price;
                    }), 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($order->products->sum(function ($product) {
                        return $product->pivot->quantity * $product->cost; // Assuming cost is available
                    }), 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($order->products->sum(function ($product) {
                        return ($product->pivot->quantity * $product->pivot->price) - ($product->pivot->quantity * $product->cost); // Profit
                    }), 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Details</a>
                    </td>
                </tr>

                @php
                // Total Units
                $totalUnits += $order->products->sum('pivot.quantity');

                // Accumulate Total Price
                $totalValueSum += $order->products->sum(function ($product) {
                    return $product->pivot->quantity * $product->pivot->price;
                });

                // Accumulate Total Cost
                $totalCostSum += $order->products->sum(function ($product) {
                    return $product->pivot->quantity * $product->cost;
                });

                // Total Profit
                $totalProfitSum += $order->products->sum(function ($product) {
                    return ($product->pivot->quantity * $product->pivot->price) - ($product->pivot->quantity * $product->cost);
                });
                @endphp

                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2" class="text-right"><strong>Total Orders: </strong></td>
                    <td><strong>{{ $totalOrders }}</strong></td> <!-- Total number of Orders -->

                    <td><strong>{{ $totalUnits }}</strong></td> <!-- Total number of Items/Units -->

                    <!-- Total Price -->
                    <td><strong>R$ {{ number_format($totalValueSum, 2, ',', '.') }}</strong></td>

                    <!-- Total Cost -->
                    <td><strong>R$ {{ number_format($totalCostSum, 2, ',', '.') }}</strong></td>

                    <!-- Total Profit -->
                    <td><strong>R$ {{ number_format($totalProfitSum, 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        @else
        <div class="alert alert-warning" role="alert">
            No orders found for this client.
        </div>
        @endif
    </main>
    @endsection
</body>
</html>