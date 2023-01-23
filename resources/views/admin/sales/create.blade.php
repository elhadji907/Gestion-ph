@extends('admin.layouts.app')
@push('page-css')
@endpush
@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">Créer une vente </h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Créer une vente</li>
        </ul>
        {{--  <div class="container row" align="left">
            <div class="col-lg-12">
                <a class="btn btn-outline-primary" href="{{ route('sales.index') }}"> <i
                        class="fas fa-undo-alt"></i>&nbsp;Arrière</a>
            </div>
        </div>  --}}
    </div>
@endpush
@section('content')
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <small class="pb-2">
            <a class="btn btn-outline-primary  btn-sm" href="{{ route('sales.index') }}"> <i
                    class="fas fa-undo-alt"></i>&nbsp;Arrière</a>
        </small>
    </div>
    {{--   <div class="row justify-content-center">
        <div class="col-sm-6 col-md-6">
            <div class="card">
                <div class="card-body custom-edit-service">
                    <!-- Create Sale -->
                    <form method="POST" action="{{ route('sales.store') }}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Produit <span class="text-danger">*</span></label>
                                    <select class="select2 form-select form-control" name="product">
                                        <option disabled selected> Sélectionner un produit </option>
                                        @foreach ($products as $product)
                                            <?php
                                            $expiry_date = strtotime($product->purchase->expiry_date);
                                            $now = strtotime(now());
                                            $perime = $expiry_date - $now;
                                            $perime = floor($perime / 3600 / 24);
                                            ?>
                                            @if (!empty($product->purchase))
                                                @if (!($product->purchase->quantity <= 0) && $perime > 0)
                                                    <option value="{{ $product->id }}">{{ $product->purchase->product }}
                                                        <span> [{{ $product->purchase->quantity }}] </span>
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Quantité <span class="text-danger">*</span></label>
                                    <input type="number" value="1" class="form-control" name="quantity"
                                        min="1">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Client <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="nom_client"
                                        placeholder="Nom du client">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Téléphone </label>
                                    <input class="form-control" type="text" name="telephone_client"
                                        placeholder="Telephone du client">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enregistrer les modifications</button>
                    </form>
                    <!--/ Create Sale -->
                </div>
            </div>
        </div>
    </div>  --}}
    <div class="container-fluid row justify-content-center">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body custom-edit-service">
                    @csrf
                    <div class="row form-row">
                        {{--   <div class="col-lg-4">
                            <div class="form-group">
                                <label>Prénom du client <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Prénom du client"
                                    class="form-control form-control-sm @error('nom_client') is-invalid @enderror"
                                    name="nom_client" id="nom_client" value="">

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Téléphone du client </label>
                                <input type="text" placeholder="Téléphone du client"
                                    class="form-control form-control-sm @error('telephone_client') is-invalid @enderror"
                                    name="telephone_client" id="telephone_client" value="">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Montant du client </label>
                                <input type="number" placeholder="Avoir client"
                                    class="form-control form-control-sm @error('avoir_client') is-invalid @enderror"
                                    name="avoir_client" id="avoir_client" value="0.00" min="0">
                            </div>
                        </div>  --}}
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Nom produit</label>
                                <input type="text" placeholder="Nom produit"
                                    class="form-control form-control-sm @error('product') is-invalid @enderror"
                                    name="product" id="product" value="">
                                <div id="productList">
                                </div>
                                @error('product')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Prix de vente</label>
                                <input type="number" placeholder="Entrer prix de vente"
                                    class="form-control form-control-sm @error('total_price') is-invalid @enderror"
                                    name="total_price" id="total_price" value="0.00" min="0">
                                @error('total_price')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                                {{--  <font style="col-lgor:red"> {{ $errors->has('total_price') ? $errors->first('total_price') : '' }} </font>  --}}
                            </div>
                        </div>
                        <input type="hidden" placeholder="Entrer quantite"
                            class="form-control form-control-sm @error('quantite') is-invalid @enderror" name="quantite"
                            id="quantite" value="0.0" min="0">

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Quantité Restante</label>
                                <input type="number" placeholder="Restant en stock"
                                    class="form-control form-control-sm @error('quantite_res') is-invalid @enderror"
                                    name="quantite_res" id="quantite_res" value="" min="1" readonly>
                                @error('quantite_res')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                                {{--  <font style="color:red"> {{ $errors->has('total_price') ? $errors->first('total_price') : '' }} </font>  --}}
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Quantité achetée</label>
                                <input type="number" placeholder="Quantité à acheter"
                                    class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                    name="quantity" id="quantity" value="1" min="1" required>
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                                {{--  <font style="color:red"> {{ $errors->has('total_price') ? $errors->first('total_price') : '' }} </font>  --}}
                            </div>
                        </div>
                        {{--  <div class="col-2">
                            <div class="form-group">
                                <label for="">Quantité</label>
                                <input type="number" placeholder="Entrer quantité"
                                    class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                    name="quantity" id="quantity" value="1" min="1">
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                        </div>  --}}
                        <div class="col-md-2" style="margin-top:32px;">
                            <div class="form-group">
                                <button id="addMore" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Ajouter au panier</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <small class="row form-row justify-content-center pb-4">
                    @foreach ($sales as $sale)
                        <a href="{{ url('admin/sales/facture', ['$id' => $sale->id]) }}" class="showbtn" target="_blank"
                            title="Télécharger la dernière facture"><button class="btn btn-outline-secondary btn-sm"><i
                                    class="fa fa-print" aria-hidden="true">&nbsp;Télécharger la facture de la dernière
                                    vente</i></button></a>
                    @endforeach
                </small>
                <div class="card">
                    <div class="card-body">
                        <div class="row form-row justify-content-center">
                            {{--  <form action="{{ route('task') }}" method="post">  --}}
                            <form method="POST" action="{{ route('sales.store') }}">
                                @csrf
                                {{--  <div class="card-header">
                                        <p class="card-title">Télécharger le dernier reçu de vente du jour
                                        </p>
                                    </div>  --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="display: none;">
                                        {{--   <thead>
                                        <tr style="background-color: rgb(66, 186, 150)">
                                            <th colspan="4" style="text-align:center">Panier des
                                                produit à ventre</th>
                                        </tr>
                                    </thead>  --}}
                                        <thead>
                                            <tr>
                                                <th style="width: 30%">Produit</th>
                                                <th>Quantité</th>
                                                <th>Prix Unitaire (PU)</th>
                                                <th>Prix Total</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addRow" class="addRow">
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="text-right">
                                                    {{--  <label>Prénom du client <span class="text-danger">*</span></label>  --}}
                                                    <input type="text" placeholder="Prénom du client"
                                                        class="form-control form-control-sm @error('nom_client') is-invalid @enderror"
                                                        name="nom_client" id="nom_client" value="Inconnue" required>
                                                </td>
                                                <td colspan="1" class="text-right">
                                                    <strong>Net à payer :</strong>
                                                </td>
                                                <td>
                                                    {{--  <input type="number" id="estimated_ammount"
                                                            class="estimated_ammount form-control form-control-sm" value="0"
                                                            readonly>  --}}

                                                    <input id="estimated_ammount" type="number" value="0"
                                                        class="estimated_ammount form-control form-control-sm"
                                                        onchange="computeLoan()" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="text-right">
                                                    {{--   <label>Téléphone du client </label>  --}}
                                                    <input type="text" placeholder="Téléphone du client"
                                                        class="form-control form-control-sm @error('telephone_client') is-invalid @enderror"
                                                        name="telephone_client" id="telephone_client" value="">
                                                </td>
                                                <td colspan="1" class="text-right">
                                                    <strong>Montant du client :</strong>
                                                </td>
                                                <td>
                                                    {{--  <input type="number" id="avoir_ammount"
                                                            class="avoir_ammount form-control form-control-sm" value="0">  --}}
                                                    <input id="amount" type="number" min="1" max="1000000"
                                                        class="form-control form-control-sm" placeholder="Montant en chiffres"
                                                        onchange="computeLoan()" required value="0.00">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-right">
                                                    <strong>Monnaie du client :</strong>
                                                </td>
                                                <td>
                                                    {{--  <input type="number" id="reste_ammount"
                                                            class="reste_ammount form-control form-control-sm" value="0" readonly>  --}}
                                                    <h2 id="payment"></h2>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Valider la vente</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>

                                            {{--   <p>Loan Amount: $<input id="amount" type="number"
                                                        min="1" max="1000000"
                                                        onchange="computeLoan()"></p>  --}}
                                            {{--  <p>Interest Rate: <input id="interest_rate" type="number"
                                                        min="0" max="100" value="10"
                                                        step=".1" onchange="computeLoan()"></p>  --}}
                                            <p><input id="months" type="hidden" min="1" max="72"
                                                    value="1" step="1" onchange="computeLoan()"></p>
                                            {{--  <h2 id="payment"></h2>  --}}
                                        </tbody>
                                    </table>
                                </div>
                                {{--  <div>
                                    <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                </div>  --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="//code.jquery.com/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
        {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  --}}
        <script id="document-template" type="text/x-handlebars-template">
      <tr class="delete_add_more_item" id="delete_add_more_item">    
          <td>
            <input type="text" name="product[]" value="@{{ product }}" required placeholder="Nom du produit" class="form-control form-control-sm" readonly>
          </td>
            <input type="hidden" name="nom_client" value="@{{ nom_client }}">
            <input type="hidden" name="telephone_client" value="@{{ telephone_client }}">
            <td>
              <input type="text" class="quantity form-control form-control-sm" name="quantity[]" value="@{{ quantity }}" required min="1" placeholder="la quantité achetée" readonly>
            </td>
            <td>
            <input type="text" class="price form-control form-control-sm" name="price[]" value="@{{ price }}" required min="1" placeholder="le prix de vente" readonly>
          </td>
            <td>
            <input type="text" class="total_price form-control form-control-sm" name="total_price[]" value="@{{ total_price }}" required min="1" placeholder="le prix total" readonly>
            <input type="hidden" class="avoir_client" name="avoir_client[]" value="@{{ avoir_client }}" required min="1" placeholder="avoir du client">
          </td>
            <input type="hidden" class="quantite" name="quantite[]" value="@{{ quantite }}">
          <td>
           <i class="removeaddmore" style="cursor:pointer;color:red;" title="supprimer"><i class="fas fa-trash"></i></i>
          </td>    
      </tr>
     </script>
        <script type="text/javascript">
            $(document).on('click', '#addMore', function() {
                $('.table').show();
                var product = $("#product").val();
                var quantity = $("#quantity").val();
                var total_price = $("#total_price").val();
                var price = $("#price").val();
                var avoir_client = $("#avoir_client").val();
                var quantite = $("#quantite").val();
                var nom_client = $("#nom_client").val();
                var telephone_client = $("#telephone_client").val();
                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var data = {
                    product: product,
                    quantity: quantity,
                    quantite: quantite,
                    nom_client: nom_client,
                    telephone_client: telephone_client,
                    total_price: total_price * quantity,
                    price: total_price,
                    avoir_client: avoir_client
                }
                var html = template(data);
                $("#addRow").append(html)
                total_ammount_price();
            });
            $(document).on('click', '.removeaddmore', function(event) {
                $(this).closest('.delete_add_more_item').remove();
                total_ammount_price();
            });

            function total_ammount_price() {
                var sum = 0;
                var avoir = 0;
                $('.total_price').each(function() {
                    var value = $(this).val();
                    if (value.length != 0) {
                        sum += parseFloat(value);
                    }
                });
                $('.avoir_client').each(function() {
                    var value = $(this).val();
                    if (value.length != 0) {
                        avoir = parseFloat(value);
                    }
                });
                $('.reste_ammount').each(function() {
                    var value = $(this).val();
                    if (value.length != 0) {
                        reste = avoir - sum;
                    }
                });
                $('#estimated_ammount').val(sum);
                $('#avoir_ammount').val(avoir);
                $('#reste_ammount').val(reste);
            }
            $('#product').keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('product.fetch') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        success: function(data) {
                            $('#productList').fadeIn();
                            $('#productList').html(data);
                        }
                    });
                }
            });
            $(document).on('click', 'li', function() {
                {{--  Ici je récupère le produit selectioné sur la liste autoload  --}}
                $('#product').val($(this).text());
                $('#total_price').val($(this).data("price"));
                $('#quantite_res').val($(this).data("quantity"));
                $('#productList').fadeOut();
            });

            /**$(function() {
                
                $('.amount').mask('#,###.##', {
                    reverse: true
                });

                var total_amount = function() {

                    var reste = 0;
                    $('.amount').each(function() {
                        var num = $(this).val().replace(',', '');
                        if (num != 0) {
                            sum += parseFloat(num);
                        }
                    });

                    $('.total_amount').val(sum);

                }
                $('.amount').keyup(function() {
                    total_amount();
                });

            });**/
        </script>
        <script>
            // This script is explained line by line in depth in the following video:
            // http://www.developphp.com/view.php?tid=1389
            function computeLoan() {
                var amount = document.getElementById('amount').value;
                var estimated_ammount = document.getElementById('estimated_ammount').value;
                var months = document.getElementById('months').value;
                var interest = (amount - (estimated_ammount)) / months;
                var payment = (interest).toFixed(2);
                payment = payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                //document.getElementById('payment').innerHTML = "Monthly Payment = $" + payment;
                document.getElementById('payment').innerHTML = " " + payment;
            }
        </script>
    @endsection
    @push('page-js')
    @endpush
