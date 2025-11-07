<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Edit Client</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('clients.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        @include('layouts.messages')

        <!-- Product Creation Form -->
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Client Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $client->name) }}">
                <small class="form-text text-muted">Any changes will affect <strong>ALL</strong> previous orders related to the client.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" name="cnpj" id="cnpj" value="{{ old('cnpj', $client->cnpj) }}">
                    <small class="form-text text-muted">Input client's CNPJ. Numbers only. <br>Ex.: 32805867000100</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $client->address) }}">
                    <small class="form-text text-muted">Input full address or just city and state. <br>Ex.: Curitiba-PR</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="whatsapp" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $client->whatsapp) }}">
                    <small class="form-text text-muted">Input client's WhatsApp number. Numbers only. <br>Ex.: 42988776655</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email', $client->email) }}">
                    <small class="form-text text-muted">Input a valid email address.</small>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </main>
    @endsection
</body>
</html>