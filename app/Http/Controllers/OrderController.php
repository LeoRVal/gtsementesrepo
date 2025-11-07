<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{

    /* CRUD Functionality */


    // Lists all entries
    public function index(Request $request) {
        // Search filters
        $query = Order::query();


        // Filter by ID
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }


        // Filter by Client
        if ($request->filled('client')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->client . '%');
            });
        }


        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }


        // Order and sort clients and products
        $orders = $query->with('client', 'products')->orderBy('date', 'desc')->get();

        // Calculate total
        foreach($orders as $order) {
            $this->calcOrderTotal($order);
        }

        return view('orders.index', compact('orders'));
    }



    /**
     * Calculate total units and value for the order.
     *
     * @param Order $order
     * @return void
     */

    private function calcOrderTotal(Order $order) {
        $order->product_count = $order->products->count();
        $order->total_units = $order->products->sum('pivot.quantity');
        $order->total_value = $order->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price;
        });
    }



    // Create an order
    public function create() {
        $clients = Client::orderBy('name')->get();
        return view('orders.create', compact('clients'));
    }


    // Store orders
    public function store(Request $request) {
        $this->validateOrder($request);

        $order = Order::create($request->all());
        return redirect()->route('orders.show', $order)->with('success', 'Order created.');
    }


    // Show an order in detail
    public function show(Order $order) {
        $products = Product::all();
        return view('orders.show', compact('order', 'products'));
    }


    // Add products to order
    public function addProduct(Request $request, $id) {
        $this->validateProduct($request);

        $order = Order::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        $this->updateOrderProduct($order, $product, $request->quantity);

        return redirect()->route('orders.show', $order->id)->with('success', 'Product added to order.');
    }


    /**
     * Update or attach a product to the order
     *
     * @param Order $order
     * @param Product $product
     * @param int $quantity
     * @return void
     */

    private function updateOrderProduct(Order $order, Product $product, int $quantity) {
        if ($order->products()->where('product_id', $product->id)->exists()) {
            $order->products()->updateExistingPivot($product->id, [
                'quantity' => DB::raw('quantity +' . $quantity),
                'price' => $product->price,
                'cost' => $product->cost
            ]);
        } else {
            $order->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $product->price,
                'cost' => $product->cost
            ]);
        }
    }


    // Remove products from order
    public function removeProduct($orderId, $productId) {
        $order = Order::findOrFail($orderId);
        $order->products()->detach($productId);

        return redirect()->route('orders.show', $order->id)->with('success', 'Product removed from order.');
    }


    // Show form to edit order
    public function edit(Order $order) {
        $clients = Client::orderBy('name')->get();
        return view('orders.edit', compact('order', 'clients'));
    }


    // Update order in storage
    public function update(Request $request, Order $order) {
        $this->validateOrder($request);

        $order->update($request->all());

        return redirect()->route('orders.show', $order)->with('success', 'Order updated.');
    }


    // Delete order from storage
    public function destroy(Order $order) {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }



    /**
     * Validate the order request.
     *
     * @param Request $request
     * @return void
     */

    private function validateOrder(Request $request) {
        $request->validate([
            'client_id' => 'required',
            'date' => 'required|date'
        ]);
    }


    /**
     * Validate the product request.
     *
     * @param Request $request
     * @return void
     */

    private function validateProduct(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
    }


    /* WhatsApp Functionality */


    public function generateWhatsappLink(Order $order) {

        // Formatting phone number (55)
        $clientPhone = preg_replace('/\D/', '', $order->client->whatsapp); // Removes non-numerical chars
        $clientPhone = '55' . ltrim($clientPhone, '0'); // Adds country code (55) and removes excess ZEROs to the left


        // Message header in bold
        $message = "*Produtolandia*\n\n";
        $message .= "Order: *{$order->id}*\n";
        $message .= "Date: *" . date('d/m/Y', strtotime($order->date)) . "*\n";
        $message .= "Client: *{$order->client->name}*\n\n";


        // Sort products by alphabetical name
        $products = $order->products->orderBy('name');


        // Iterate products, format message with names and values in bold
        foreach ($products as $product) {

            // Value iteration
            $quantity = $product->pivot->quantity;
            $price = number_format($product->pivot->price, 2, ',', '.');
            $subtotal = number_format($quantity * $product->pivot->price, 2, ',', '.');

            // Bold names and prices
            $message .= "*{$product->name}*\n"; // Name of product
            $message .= "{$quantity} x R$ {$price} = *R$ {$subtotal}*\n\n"; // No. of items, total cost
        }


        // Order summary, prices in bold
        $uniqueProducts = $products->count();
        $totalQuantity = $products->sum('pivot.quantity');
        $totalValue = number_format($products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price;
        }), 2, ',', '.');

        $message .= "Unique Products: *{$uniqueProducts}*\n";
        $message .= "Total Items: *{$totalQuantity}*\n";
        $message .= "Total Price: *{$totalValue}*\n";


        // Append date and time sent
        $currentDateTime = date('d/m/Y H:i');
        $message .= "Sent: *{$currentDateTime}*";


        // Encode message as URL
        $whatsappMessage = urlencode($message);


        // Generate direct WhatsApp message link
        // EXAMPLE: https://wa.me/[phoneNumber (without hyphens)]?text=[message]
        $whatsappLink = "https:/wa.me/{$clientPhone}?text={$whatsappMessage}";


        // Redirect/return link
        return redirect($whatsappLink);
    }


    /* Receipt Generation */


    public function generatePdf(Order $order) {
        
        // Load client's order and products
        $order->load('client', 'products');

        // Render receipt view in HTML
        $pdf = PDF::loadView('orders.receipt', compact('order'))->setPaper('A4', 'portrait');

        // Generate downloadable PDF
        $clientName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $order->client->name);
        return $pdf->stream("RECEIPT-{$order->client->name}-ORDER-{$order->id}.pdf");
    }
}
