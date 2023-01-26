<!-- Ajouter Vente Modale -->
<div class="modal fade" id="add_sales" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        {{--   <button type="submit" class="btn btn-outline-warning bg-gradient-default">&nbsp;Cliquer
                                ici pour faire une vente multiple</button>  --}}
                        <a class="btn btn-warning bg-gradient-default" href="{{ route('sales.create') }}">Cliquer
                            ici pour faire une vente multiple</a>
                    </div>

                    {{--  <a class="{{ route_is('sales.create') ? 'active' : '' }}" href="{{ route('sales.create') }}">Cliquer
                        ici pour faire une vente multiple</a>  --}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('sales.store') }}">
                    @csrf
                    <div class="row form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Produit <span class="text-danger">*</span></label>
                                {{--  <select class="select2 form-select form-control" name="product">
                                    <option disabled selected> Sélectionner un produit</option>
                                    @foreach (\App\Models\Product::get() as $product)
                                        <?php
                                        $expiry_date = strtotime($product->purchase->expiry_date);
                                        $now = strtotime(now());
                                        $perime = $expiry_date - $now;
                                        $perime = floor($perime / 3600 / 24);
                                        ?>
                                        @if (!empty($product->purchase) && $perime > 0)
                                            @if (!($product->purchase->quantity <= 0))
                                                <option value="{{ $product->id }}">{{ $product->purchase->product }}
                                            @endif
                                        @endif
                                    @endforeach
                                </select>  --}}
                                <input type="text" placeholder="Nom produit"
                                    class="form-control form-control-sm @error('product') is-invalid @enderror"
                                    name="product" id="product" required>
                                <input type="hidden" placeholder="Nom produit"
                                    class="form-control form-control-sm @error('id_producte') is-invalid @enderror"
                                    name="id_producte" id="id_producte" value="">
                                <div id="productList">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Prix de vente </label>
                                <input type="number" placeholder="Entrer prix de vente"
                                    class="form-control form-control-sm @error('price') is-invalid @enderror"
                                    name="price" id="price" value="0.00" min="0">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Quantité Restante</label>
                                <input type="number" placeholder="Restant en stock"
                                    class="form-control form-control-sm @error('quantite') is-invalid @enderror"
                                    name="quantite" id="quantite" value="" min="1" readonly>
                                @error('quantite')
                                    <span class="invalid-feedback" role="alert">
                                        <div>{{ $message }}</div>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
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
                            </div>
                        </div>
                        {{--   <div class="col-6">
                            <div class="form-group">
                                <label>Quantité <span class="text-danger">*</span></label>
                                <input type="number" value="1" class="form-control" name="quantity"
                                    min="1">
                            </div>
                        </div>  --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Client <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" type="text" name="nom_client"
                                    placeholder="Nom du client" value="Inconnue">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Téléphone </label>
                                <input class="form-control form-control-sm" type="text" name="telephone_client"
                                    placeholder="Telephone du client" value="">
                            </div>
                        </div>
                        <input class="form-control" type="hidden" name="modal_vente" placeholder="" value="oui">

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-outline-primary"><i
                                class="far fa-paper-plane"></i>&nbsp;Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Ajouter Vente Modale -->
{{--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">  --}}
<link href="{{asset('assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
{{--  <script src="//code.jquery.com/jquery.js"></script>  --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>  --}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  --}}
<script type="text/javascript">
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
        $('#price').val($(this).data("price"));
        $('#quantite').val($(this).data("quantity"));
        $('#id_producte').val($(this).data("id"));
        $('#productList').fadeOut();
    });
</script>
