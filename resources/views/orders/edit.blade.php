<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Edit Order</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('orders.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        @include('layouts.messages')

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="date" id="date" 
                       value="{{ old('date', $order->date ? date('Y-m-d', strtotime($order->date)) : '') }}" required>
            </div>

            <div class="mb-3">
                <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                <select class="form-control" name="client_id" id="client_id" required>
                    <option value="" disabled>Select a client</option>

                    @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id', $order->client->id) == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} - {{ $client->cnpj }} - {{ $client->address }}
                    </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </main>
    @endsection
</body>
</html>