<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main>
        <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Order Details</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('clients.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        @include('layouts.messages')

        <div class="mb-4">
            <h5 class="fw-bold">Order Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <strong>Order:</strong> {{ $order->id }} - {{ date('d/m/Y', strtotime($order->date)) }}
                    <br>
                    <strong>Client:</strong> {{ $order->client->name }}
                    <br>
                    <strong>CNPJ:</strong> {{ $order->client->cnpj }}
                    <br>
                    <strong>Address:</strong> {{ $order->client->address }}
                    <br>
                    <strong>WhatsApp:</strong> {{ $order->client->whatsapp }}
                    <br>
                    <strong>Email:</strong> {{ $order->client->email }}
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('orders.whatsappLink', $order->id) }}" class="btn btn-success" target="_blank">
                            Send via WhatsApp
                        </a>

                        <a href="{{ route('orders.receipt', $order->id) }}" class="btn btn-info" target="_blank">
                            Print Receipt
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5 d-flex justify-content-between align-items-center">Products in Order
        <button type="button" class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
        </h3>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Amount</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Cost</th>
                    <th>Subtotal</th>
                    <th>Subtotal Cost</th>
                    <th>Profit</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php
                $totalPrice = 0;
                $totalCost = 0;
                $totalProfit = 0;
                $totalQuantity = 0;
                $uniqueProducts = 0;
                @endphp

                @foreach ($order->products->sortBy('name') as $product)
                    @php
                    $subtotal = $product->pivot->price * $product->pivot->quantity;
                    $totalPrice += $subtotal;
                    $totalQuantity += $product->pivot->quantity;
                    $uniqueProducts++;

                    // Calculate total cost and profit
                    $cost = $product->pivot->cost * $product->pivot->quantity;
                    $profit = $subtotal - $cost;

                    // Adding total cost and profit
                    $totalCost += $cost;
                    $totalProfit += $profit;
                    @endphp

                <tr>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ $product->name }}</td>
                    <td>R$ {{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                    <td class="table-warning">R$ {{ number_format($product->pivot->cost, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                    <td class="table-warning">
                        R$ {{ number_format($product->pivot->cost * $product->pivot->quantity, 2, ',', '.') }}</td>
                    <td class="table-warning">R$ {{ number_format($profit, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('orders.removeProduct', [$order->id, $product->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="table-success">
                    <td><strong>{{ $totalQuantity }}</strong></td>
                    <td><strong>Unique Products: {{ $uniqueProducts }}</strong></td>
                    <td></td>
                    <td><strong>Total Price:</strong></td>
                    <td><strong>R$ {{ number_format($totalPrice, 2, ',', '.') }}</strong></td>
                    <td class="table-warning"><strong>R$ {{ number_format($totalCost, 2, ',', '.') }}</strong></td>
                    <td class="table-warning"><strong>R$ {{ number_format($totalProfit, 2, ',', '.') }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>


        <!-- Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('orders.addProduct', $order->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" name="product_id" id="product_id" required>
                                    <option value="" disabled selected>Select a product</option>

                                    @foreach ($products->sortBy('name') as $product)
                                    <option value="{{ $product->id }}"
                                        data-stock="{{ $product->stock }}"
                                        @if ($product->stock <= 0) disabled @endif>
                                        {{ $product->name }} - 
                                        R$ {{ number_format($product->price, 2, ',', '.') }} - 
                                        ({{ number_format($product->cost, 2, ',', '.') }})

                                        @if ($product->stock <= 0)
                                        - OUT OF STOCK
                                        @elseif ($product->stock <= 10)
                                        - Stock: {{ $product->stock }} (LOW)
                                        @else 
                                        - Stock {{ $product->stock }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>

                                <small class="form-text text-muted">
                                    Products without stock cannot be added to the order.
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" min="1" max="" required>
                                <small class="form-text text-muted" id="stock-info">
                                    Select a product to see available stock.
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script>
        // Update stock info when product is selected
        document.getElementById('product_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const quantityInput = document.getElementById('quantity');
            const stockInfo = document.getElementById('stock-info');

            if (stock > 0) {
                quantityInput.max = stock;
                quantityInput.value = Math.min(parseInt(quantityInput.value) || 1, stock);

                if (stock <= 10) {
                    stockInfo.innerHTML = `<span class="text-warning"><strong>Available stock: ${stock} units (LOW)</strong></span>`;
                } else {
                    stockInfo.innerHTML = `<span class="text-success">Available stock: ${stock} units</span>`;
                }
            } else {
                quantityInput.max = 0;
                stockInfo.innerHTML = `<span class="text-danger"><strong>Product out of stock</strong></span>`;
            }
        });
    </script>
    @endsection
</body>
</html>