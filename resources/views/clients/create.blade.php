<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Client</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>New Client</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('clients.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        <!-- Client Creation Form -->
        @include('layouts.messages')

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Client Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                <small class="form-text text-muted">Input the client's name (individual or company).</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cnpj" class="form-label">CNPJ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="cnpj" id="cnpj" value="{{ old('cnpj') }}">
                    <small class="form-text text-muted">Input client's CNPJ. Numbers only. <br>Ex.: 32805867000100</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
                    <small class="form-text text-muted">Input full address or just city and state. <br>Ex.: Curitiba-PR</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="whatsapp" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}">
                    <small class="form-text text-muted">Input client's WhatsApp number. Numbers only. <br>Ex.: 42988776655</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    <small class="form-text text-muted">Input a valid email address.</small>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Add Client</button>
            </div>
         </form>
    </main>
    @endsection
</body>
</html>