<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>

    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 20px;
            font-size: 12px;
        }


        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            body {
                margin: 0;
            }

            .page {
                width: 210mm;
                height: 297mm;
                position: relative;
            }
        }


        h3 {
            text-align: center;
        }

        .page {
            position: relative;
        }

        hr.cut-line {
            position: absolute;
            top: 148.5mm;
            left: 0;
            right: 0;
            border: 0;
            border-top: 1px dashed #999;
            margin: 0;
        }

        .copy-2 {
            position: absolute;
            top: 148.5mm;
            left: 0;
            right: 0;
        }

        .container {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 0px solid #333;
            padding: 0px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row {
            font-weight: bold;
        }

        .signature-section {
            margin-top: 30px;
            text-align: left;
        }

        .info-table {
            width: 100%;
            margin-top: 10px;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
        }

        .signature-table {
            margin-top: 30px;
            width: 100%;
        }

        .signature-table td {
            width: 33%;
            text-align: center;
            border: none;
        }

        .qtd-column {
            text-align: center;
        }

        .right-align {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="container">
            <h3><strong>CATALOGGER - (42)99127-5631</strong> - <small>(Distributor Ticket)</small></h3>
            <table class="info-table">
                <tr>
                    <td><strong>Client:</strong> {{ $order->client->name }}</td>
                    <td><strong>Order:</strong> {{ $order->id }} - {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</td>
                </tr>

                <tr>
                    <td><strong>CNPJ:</strong> {{ $order->client->cnpj }}</td>
                    <td><strong>WhatsApp:</strong> {{ $order->client->whatsapp }}</td>
                </tr>

                <tr>
                    <td><strong>Address:</strong> {{ $order->client->address }}</td>
                    <td><strong>Email:</strong> {{ $order->client->email }}</td>
                </tr>
            </table>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="qtd-column">Amount</th>
                    <th>Product</th>
                    <th class="right-align">Unit Price</th>
                    <th class="right-align">Total</th>
                </tr>
            </thead>

            <tbody>
                @php
                $totalPrice = 0;
                $totalQuantity = 0;
                @endphp
                
                @foreach ($order->products->sortBy('name') as $product)
                    @php
                    $subtotal = $product->pivot->price * $product->pivot->quantity;
                    $totalPrice += $subtotal;
                    $totalQuantity += $product->pivot->quantity
                    @endphp

                    <tr>
                        <td class="qtd-column">{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->name }}</td>
                        <td class="right-align"> {{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                        <td class="right-align"> {{ number_format($subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="total-row">
                    <td class="qtd-column">[{{ $totalQuantity }}]</td>
                    <td colspan="2" class="right-align">TOTAL:</td>
                    <td class="right-align">R$ {{ number_format($totalPrice, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>____________________________ <br>Received by:</td>
                    <td>____________________________ <br>Signature:</td>
                    <td>_______/______/________<br>Date:</td>
                </tr>
            </table>
        </div>


        <hr class="cut-line">


        <div class="copy-2">
            <div class="container">
                <h3><strong>CATALOGGER - (42)99127-5631</strong> - <small>(Client Ticket)</small></h3>
                <table class="info-table">
                    <tr>
                        <td><strong>Client:</strong> {{ $order->client->name }}</td>
                        <td><strong>Order:</strong> {{ $order->id }} - {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</td>
                    </tr>

                    <tr>
                        <td><strong>CNPJ:</strong> {{ $order->client->cnpj }}</td>
                        <td><strong>WhatsApp:</strong> {{ $order->client->whatsapp }}</td>
                    </tr>

                    <tr>
                        <td><strong>Address:</strong> {{ $order->client->address }}</td>
                        <td><strong>Email:</strong> {{ $order->client->email }}</td>
                    </tr>
                </table>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="qtd-column">Amount</th>
                        <th>Product</th>
                        <th class="right-align">Unit Price</th>
                        <th class="right-align">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $totalPrice = 0;
                    $totalQuantity = 0;
                    @endphp
                    
                    @foreach ($order->products->sortBy('name') as $product)
                        @php
                        $subtotal = $product->pivot->price * $product->pivot->quantity;
                        $totalPrice += $subtotal;
                        $totalQuantity += $product->pivot->quantity
                        @endphp

                        <tr>
                            <td class="qtd-column">{{ $product->pivot->quantity }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="right-align"> {{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                            <td class="right-align"> {{ number_format($subtotal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr class="total-row">
                        <td class="qtd-column">[{{ $totalQuantity }}]</td>
                        <td colspan="2" class="right-align">TOTAL:</td>
                        <td class="right-align">R$ {{ number_format($totalPrice, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>