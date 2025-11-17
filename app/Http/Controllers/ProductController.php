<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::orderBy('name')->get();
        return view('products.index', compact('products'));
    }


    public function create() {
        return view('products.create');
    }


    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|regex:/^\d+([.,]\d{1,2})?$/',
            'cost' => 'required|regex:/^\d+([.,]\d{1,2})?$/',
            'stock' => 'nullable|integer|min:0'
        ]);

        $price = str_replace(',', '.', $request->input('price'));
        $cost = str_replace(',', '.', $request->input('cost'));
        $stock = $request->input('stock', 0);

        Product::create([
            'name' => $request->input('name'),
            'price' => $price,
            'cost' => $cost,
            'stock' => $stock
        ]);

        return redirect()->route('products.index')->with('success', 'Product created.');
    }


    public function show(Product $product) {
        return view('products.show', compact('product'));
    }


    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }


    public function update(Request $request, Product $product) {
        $request->validate([
            'price' => 'required|regex:/^\d+([.,]\d{1,2})?$/',
            'cost' => 'required|regex:/^\d+([.,]\d{1,2})?$/',
            'stock' => 'nullable|integer|min:0'
        ]);

        $price = str_replace(',', '.', $request->input('price'));
        $cost = str_replace(',', '.', $request->input('cost'));
        $stock = $request->input('stock', $product->stock);

        $product->update([
            'price' => $price,
            'cost' => $cost,
            'stock' => $stock
        ]);

        return redirect()->route('products.show', $product)->with('success', 'Product updated.');
    }


    public function destroy(Product $product) {
        if ($product->orders()->exists()) {
            return redirect()->route('products.show', $product->id)
                ->with('error', 'Can"t delete product, related orders still exist.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
