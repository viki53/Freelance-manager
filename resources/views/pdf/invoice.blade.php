<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Facture {{ $invoice->id }}</title>

    <style>
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    .container {
        width: 18cm;
    }
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }
    .clear,
    .clear::before,
    .clear::after {
        content: '';
        clear: both;
    }
    .header {
        padding: 2.5mm 5mm;
        background-color: #c1c1c1;
        border-radius: 2mm;
    }
    .header p {
        margin: 0;
        padding: 0;
        font-weight: bold;
    }
    .header .invoice-title {
        float: left;
        text-align: left;
    }
    .header .invoice-title em {
        font-style: normal;
        font-weight: normal;
    }
    .header .invoice-date {
        flex: 1 0 auto;
        text-align: right;
    }

    .addresses {
        margin-top: .5cm;
        margin-bottom: .5cm;
        height: 5cm;
    }
    .company-address {
        float: left;
        width: 40%;
    }
    .customer-address {
        float: right;
        width: 40%;
        padding-top: 2cm;
    }
    address {
        font-style: normal;
    }

    .invoice {
        display: table;
        border: none;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 1cm;
        width: 100%;
    }
    .invoice th,
    .invoice td {
        padding: 2mm;
        text-align: right;
    }
    .invoice .item > td {
        border-top: .25mm solid #c1c1c1;
    }
    .invoice .item:first-child > td {
        border-top: none;
    }
    .invoice .item p {
        margin: 0;
        padding: 0;
    }
    .invoice .item p + p {
        margin-top: 1mm;
    }
    .invoice .item:last-child td {
        padding-bottom: 2mm;
    }
    .invoice thead th:first-child,
    .invoice tbody td:first-child {
        text-align: left;
    }
    .invoice .item-label {
        max-width: 55%;
        vertical-align: top;
        text-align: left;
    }
    .invoice .item-quantity {
        min-width: 25%;
        vertical-align: top;
    }
    .invoice .item-untaxed-price {
        width: 20%;
        vertical-align: top;
    }
    .invoice-totals {
        display: table-footer-group;
        border-top: .5mm solid #c1c1c1;
    }
    .invoice-totals tr:first-child > * {
        border-top: .5mm solid #c1c1c1;
    }
    .invoice-totals th:first-child {
        text-align: right;
    }
    .invoice .total-label {
        padding-top: 2mm;
        padding-bottom: 2mm;
    }
    .invoice-taxed-total {
        border-radius: 2mm;
    }
    .invoice-taxed-total th {
        background-color: #c1c1c1;
        border-top-left-radius: 2mm;
        border-bottom-left-radius: 2mm;
    }
    .invoice-taxed-total td {
        background-color: #c1c1c1;
        border-top-right-radius: 2mm;
        border-bottom-right-radius: 2mm;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="header clear">
            <p class="invoice-title">Facture <em>{{ $invoice->id }}</em></p>
            <p class="invoice-date">Le {{ $invoice->sent_at->isoFormat('D MMMM YYYY') }}</p>
        </div>

        <div class="addresses clear">
            <div class="company-address">
                <address class="not-italic p-2">
                    <p>
                        <strong>{{ $invoice->company->name }}</strong><br>
                        {!! nl2br(e($invoice->company->headquarters_address->street_address)) !!}<br>
                        {{ $invoice->company->headquarters_address->postal_code }} {{ $invoice->company->headquarters_address->city }}<br>
                        {{ $invoice->company->headquarters_address->country->name }}
                    </p>
                </address>
            </div>
            <div class="customer-address">
                <address class="not-italic p-2">
                    <p>
                        <strong>{{ $invoice->customer->name }}</strong><br>
                        {!! nl2br(e($invoice->customer->headquarters_address->street_address)) !!}<br>
                        {{ $invoice->customer->headquarters_address->postal_code }} {{ $invoice->customer->headquarters_address->city }}<br>
                        {{ $invoice->customer->headquarters_address->country->name }}
                    </p>
                </address>
            </div>
        </div>

        <table class="invoice">
            <thead>
                <tr>
                    <th class="item-label"></th>
                    <th class="item-quantity"></th>
                    <th class="item-untaxed-price">
                        Montant <acronym title="Hors taxes">HT</acronym>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr class="item">
                    <td class="item-label">
                        <p><strong>{{ $item->label }}</strong></p>
                        @if(!empty($item->description))
                        <p>{!! nl2br(e($item->description)) !!}</p>
                        @endif
                    </td>
                    <td class="item-quantity">
                        <p>
                            @number_format($item->quantity)
                            @choice($item->item_type->label_singular.'|'.$item->item_type->label_plural, $item->quantity)
                            à
                            @money_format($item->unit_price, 'EUR')
                        </p>
                        <p>
                            <acronym title="Taxe sur la Valeur Ajoutée">TVA</acronym>
                            @number_format($item->tax_rate->percentage)&nbsp;%
                        </p>
                    </td>
                    <td class="item-untaxed-price">
                        @money_format($item->untaxed_price, 'EUR')
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="invoice-totals">
                <tr class="invoice-untaxed-total">
                    <th scope="row" colspan="2" class="total-label">
                        Total
                        <acronym title="Hors taxes">HT</acronym>
                    </th>
                    <td class="total-amount">
                        @money_format($invoice->untaxed_total, 'EUR')
                    </td>
                </tr>
                <tr class="invoice-paxes-total">
                    <th scope="row" colspan="2" class="total-label">
                        Total
                        <acronym title="Taxe sur la Valeur Ajoutée">TVA</acronym>
                    </th>
                    <td class="total-amount">
                        @money_format($invoice->taxes_total, 'EUR')
                    </td>
                </tr>
                <tr class="invoice-taxed-total">
                    <th scope="row" colspan="2" class="total-label">
                        Total
                        <acronym title="Toutes Taxes Comprises">TTC</acronym>
                    </th>
                    <td class="total-amount">
                        @money_format($invoice->taxed_total, 'EUR')
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
