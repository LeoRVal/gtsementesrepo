<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Clients</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('clients.create') }}" type="button" class="btn btn-sm btn-outline-secondary">Add Client</a>
                </div>
            </div>
        </div>

        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>CNPJ</th>
                        <th>Address</th>
                        <th>WhatsApp</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->cnpj }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $client->whatsapp }}</td>
                        <td>{{ $client->email }}</td>
                        
                        <td>
                            <a href="{{ route('clients.show', $client->id) }}" class="btn btn-info">Details</a>
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