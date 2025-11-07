<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Public catalog page for clients
Route::get('catalog', function() {
    $products = Product::query()->select(['id', 'name', 'price'])->orderBy('name')->get();

    return view('catalog', [
        'products' => $products,
        'today' => now()
    ]);
})->name('catalog');

// Clients
Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('clients/new', [ClientController::class, 'create'])->name('clients.create');
Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');


// Products
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/new', [ProductController::class, 'create'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


// Orders
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/new', [OrderController::class, 'create'])->name('orders.create');
Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::post('orders/{order}/add-products', [OrderController::class, 'addProduct'])->name('orders.addProduct');
Route::delete('orders/{order}/remove-product', [OrderController::class, 'removeProduct'])->name('orders.removeProduct');
Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

Route::get('orders/{order}/whatsapp', [OrderController::class, 'generateWhatsappLink'])->name('orders.whatsappLink');
Route::get('orders/{order}/receipt-pdf',[OrderController::class, 'generatePdf'])->name('orders.receipt');