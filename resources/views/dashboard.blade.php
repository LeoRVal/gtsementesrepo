<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <main class="col-md-9 col-lg-10">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
                <h2>Dashboard</h2>
            </div>

            <!-- Cards showing amount of each item -->
             
            <div class="row mb-4 mt-4">
                <!-- Total Clients Card -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Clients</h5>
                            <p class="card-text">{{ $totalClients }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Products Card -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text">{{ $totalProducts }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Orders Card -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <p class="card-text">{{ $totalOrders }}</p>
                        </div>
                    </div>
                </div>
            </div>

            
        </main>
    @endsection
</body>
</html>