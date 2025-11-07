<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main>
        <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Orders</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('orders.create') }}" type="button" class="btn btn-sm btn-outline-secondary">Add Order</a>
                </div>
            </div>
        </div>

        @include('layouts.messages')

        <!-- Search Filter -->
        <form method="GET" action="{{ route('orders.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="id" class="form-control" placeholder="Order Number" value="{{ request('id') }}">
                </div>

                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                </div>

                <div class="col-md-3">
                    <input type="text" name="client" class="form-control" placeholder="Client Name" value="{{ request('client') }}">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary ml-2">Clear</a>
                </div>
            </div>
        </form>


        <!-- Table -->
        <div class="table-responive-small">
            <table class="table table-striped table-sm">
                <thead>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Products</th>
                    <th>Total Units</th>
                    <th>Total Price (R$)</th>
                    <th>Total Cost (R$)</th>
                    <th>Profit (R$)</th>
                    <th></th>
                </thead>

                <tbody>
                    @php
                    // Initializing variables to calculate totals
                    $totalOrders = 0;
                    $totalProducts = 0;
                    $totalUnits = 0;
                    $totalValueSum = 0;
                    $totalCostSum = 0;
                    $totalProfitSum = 0;
                    @endphp

                    @foreach ($orders as $order)
                        @php
                        // Calculating price, cost and profit for each order
                        $totalCost = $order->products->sum(function ($product) {
                            return $product->pivot->cost * $product->pivot->quantity;
                        });

                        $totalValue = $order->products->sum(function ($product) {
                            return $product->pivot->price * $product->pivot->quantity;
                        });

                        $profit = $totalValue - $totalCost;
                        @endphp

                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ date('d/m/Y', strtotime($order->date)) }}</td>
                        <td>{{ $order->client->name }}</td>
                        <td>{{ $order->product_count }}</td>
                        <td>{{ $order->total_units }}</td>
                        <td>R$ {{ number_format($totalValue, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($totalCost, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($profit, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right"><strong>Total Orders: </strong></td>
                        <td><strong>{{ $totalOrders }}</strong></td> <!-- Total number of Orders -->

                        <td><strong>{{ $totalProducts }}</strong></td>
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
        </div>
    </main>
    @endsection
</body>
</html>