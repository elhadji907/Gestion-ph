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
        <div class="container row justify-content-center pt-5">
            <div class="col-lg-12">
                <a class="btn btn-outline-primary" href="{{ route('sales.index') }}"> <i
                        class="fas fa-undo-alt"></i>&nbsp;Arrière</a>
            </div>
        </div>
    </div>
@endpush

@section('content')
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
        <div class="col-sm-6 col-md-12">
            <div class="card">
                <div class="card-body custom-edit-service">
                    @csrf
                    <div class="row form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Client <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Client"
                                    class="form-control form-control-sm @error('nom_client') is-invalid @enderror"
                                    name="nom_client" id="nom_client" value="">

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Téléphone </label>
                                <input type="text" placeholder="Telephone du client"
                                    class="form-control form-control-sm @error('telephone_client') is-invalid @enderror"
                                    name="telephone_client" id="telephone_client" value="">
                            </div>
                        </div>
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Prix de vente</label>
                                <input type="text" placeholder="Entrer prix de vente"
                                    class="form-control form-control-sm @error('total_price') is-invalid @enderror"
                                    name="total_price" id="total_price" value="" min="0">
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
                                <label for="">Quantity</label>
                                <input type="number" placeholder="Entrer prix de vente"
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
                                <button id="addMore" class="btn btn-success btn-sm">Ajouter</button>
                            </div>
                        </div>
                        <div class="row  form-row justify-content-center" style="margin-top:26px;">
                            <div class="col-md-6">
                                {{--  <form action="{{ route('task') }}" method="post">  --}}
                                <form method="POST" action="{{ route('sales.store') }}">
                                    @csrf

                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered" style="display: none;">
                                                    <thead>
                                                        <tr>
                                                            <th>Produit</th>
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
                                                            <td colspan="3" class="text-center">
                                                                <strong>NET À PAYER :</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" id="estimated_ammount"
                                                                    class="estimated_ammount" value="0" readonly>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                   {{--   <tbody>
                                                        <tr>
                                                            <td colspan="1" class="text-right">
                                                                <strong>Avoir:</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" id="avoir_ammount"
                                                                    class="avoir_ammount" value="0">
                                                            </td>
                                                        </tr>
                                                    </tbody>  --}}
                                                    {{--  <tbody>
                                                        <tr>
                                                            <td colspan="1" class="text-right">
                                                                <strong>Reste:</strong>
                                                            </td>
                                                            <td>
                                                                <input type="number" id="reste_ammount"
                                                                    class="reste_ammount" value="0" readonly>
                                                            </td>
                                                        </tr>
                                                    </tbody>  --}}
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="1" class="text-right">
                                                            </td>
                                                            <td>
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm">Valider</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                {{--  <div>
                                                    <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                                </div>  --}}
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>

    <script id="document-template" type="text/x-handlebars-template">
      <tr class="delete_add_more_item" id="delete_add_more_item">    
          <td>
            <input type="text" name="product[]" value="@{{ product }}" required>
          </td>
            <input type="hidden" name="nom_client" value="@{{ nom_client }}">
            <input type="hidden" name="telephone_client" value="@{{ telephone_client }}">
            <td>
              <input type="number" class="quantity" name="quantity[]" value="@{{ quantity }}" required min="1">
            </td>
            <td>
            <input type="number" class="price" name="price[]" value="@{{ price }}" required min="1">
          </td>
            <td>
            <input type="number" class="total_price" name="total_price[]" value="@{{ total_price }}" required min="1">
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
            var price = $("#total_price").val();
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
                price: total_price
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
            $('.total_price').each(function() {
                var value = $(this).val();
                if (value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            $('#estimated_ammount').val(sum);
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
            {{--  $('#productList').fadeOut();  --}}
        });
        
    </script>
@endsection

@push('page-js')
@endpush
