<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // List resources
    public function index() {
        $clients = Client::orderBy('name')->get();
        return view('clients.index', compact('clients'));
    }


    // Create new resource
    public function create() {
        return view('clients.create');
    }


    // Store created resource
    public function store(Request $request) {
        $this->validateRequest($request);
        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client created.');
    }


    // Display specified resource in more detail
    public function show(Client $client) {
        // Load orders related to client
        $orders = $client->orders()->with('products')->get();

        return view('clients.show', compact('client', 'orders'));
    }


    // Edit specified resource
    public function edit(Client $client) {
        return view('clients.edit', compact('client'));
    }


    // Updates edited resource in storage
    public function update(Request $request, Client $client) {
        $this->validateRequest($request);
        $client->update($request->all());

        return redirect()->route('clients.show', $client)->with('success', 'Client updated.');
    }


    // Deletes specified resource
    public function destroy(Client $client) {
        if($client->orders()->exists()) {
            return redirect()->route('clients.index')->with('error', 'Cannot delete client, associated orders still exist.');
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted.');
    }



    // Validate requests for storing and updating
    protected function validateRequest(Request $request) {
        $clientId = $request->route('client') ? $request->route('client')->id : null;

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'cnpj' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $cpf = strlen($value) === 11;  // Checks if CPF has 11 digits max
                    $cnpj = strlen($value) === 14; // Checks if CNPJ has 14 digits max

                    if (!$cpf && !$cnpj) {
                        $fail('Field' . $attribute . ' must be a valid CPF or CNPJ code.');
                    }
                },
                'unique:clients,cnpj,' . $clientId,  // Verifies if unique
            ],
            'address' => 'required|string|nullable',
            'whatsapp' => 'required|string|max:11|nullable',
            'email' => 'nullable|email|unique:clients,email,' . $clientId
        ]);
    }
}
