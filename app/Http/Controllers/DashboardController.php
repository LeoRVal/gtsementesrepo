<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $totalClients = Client::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        return view('dashboard', compact('totalClients', 'totalProducts', 'totalOrders'));
    }
}
