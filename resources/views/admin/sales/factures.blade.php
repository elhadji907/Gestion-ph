<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            font-size: 12px;
            line-height: 24px;
            color: #555;
        }

        /** RTL **/
        .rtl {
            imputation: rtl;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        table {
            border-left: 0px solid rgb(0, 0, 0);
            border-right: 0;
            border-top: 0px solid rgb(0, 0, 0);
            border-bottom: 0;
            width: 100%;
            border-spacing: 0px;
        }

        table td,
        table th {
            border-left: 0;
            border-right: 0px solid rgb(0, 0, 0);
            border-top: 0;
            border-bottom: 0px solid rgb(0, 0, 0);
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//db.onlinewebfonts.com/c/dd79278a2e4c4a2090b763931f2ada53?family=ArialW02-Regular" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>



<body>
    <div class="invoice-box">
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td colspan="2">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/pharma-niaguis.png'))) }}"
                            style="width: 100%; max-width: 200px" />
                    </td>
                    <td colspan="2" align="right" valign="top">
                        <p>
                            <b>Pharmacie de Niaguis </b> <span><br />
                                <b>Facture n° </b> : <span>
                                    {{ $code ?? '' }}</span><br />
                                <b>Date </b> : <span>
                                    {{ $sale->created_at->format('d-m-Y') ?? '' }}
                                </span><br />
                                <b>Email </b> : <span>
                                    {{ Auth::user()->email ?? '' }}</span><br />
                                <b>Téléphone </b> : <span>
                                    {{ Auth::user()->phone ?? '78 264 08 02' }}</span><br />
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td colspan="4"><b>{{ __('Client') }}</b> :
                        {{ $sale->nom_client }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><b>{{ __('Téléphone') }}</b> :
                        {{ $sale->telephone_client }}
                </tr>
            </tbody>
        </table>
        <br /><br />
        <table class="table table-responsive table-striped">
            <tbody>
                <tr class="heading">
                    <td colspan="1"><b>{{ __('N°') }}</b>

                    </td>
                    <td colspan="1"><b>{{ __('Produit') }}</b>

                    </td>
                    <td colspan="1"><b>{{ __('Quantité') }}</b>

                    </td>
                    <td colspan="1"><b>{{ __('PU') }}</b>

                    </td>
                    <td align="right" colspan="1"><b>{{ __('TOTAL') }}</b>

                    </td>
                </tr>
                <?php $i = 1; ?>
                @foreach ($sales as $sale)
                    <tr class="item">
                        <td colspan="1">
                            {!! $i++ !!}<br>
                        </td>
                        <td colspan="1">
                            {!! $sale->name !!}<br>
                        </td>
                        <td colspan="1">
                            {!! $sale->quantity !!}<br>
                        </td>
                        <?php $price = $sale->total_price / $sale->quantity; ?>
                        <td colspan="1">
                            {!! number_format($price, 2, ',', ' ') !!}<br>
                        </td>
                        <td align="right" colspan="1">
                            {!! number_format($sale->total_price, 2, ',', ' ') !!}<br>
                        </td>
                    </tr>
                @endforeach
                <tr class="total" align="center">
                    <td colspan="4">
                        TOTAL
                    </td>

                    <td align="right" colspan="1">
                        {{ number_format($total, 2, ',', ' ') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
