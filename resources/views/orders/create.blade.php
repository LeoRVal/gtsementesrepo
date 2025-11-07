<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place New Order</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>New Order</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('orders.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        @include('layouts.messages')

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}" required>
            </div>

            <div class="mb-3">
                <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                <select class="form-control" name="client_id" id="client_id" required>
                    <option value="" disabled>Select a client</option>

                    @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} - {{ $client->cnpj }} - {{ $client->address }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Add Order</button>
            </div>
        </form>
    </main>
    @endsection
</body>
</html>