<!-- Ajouter Vente Modale -->
<div class="modal fade bd-example-modal-xl" id="add_sales" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <a class="{{ route_is('sales.create') ? 'active' : '' }}" href="{{ route('sales.create') }}">Cliquer
                        ici pour faire une vente multiple</a>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('sales.store') }}">
                    @csrf
                    <div class="row form-row">
                        {{--  <div class="col-12">
                            <div class="form-group">
                                <label>Produit <span class="text-danger">*</span></label>
                                <select class="select2 form-select form-control" name="product">
                                    <option disabled selected> Sélectionner un produit</option>
                                    @foreach (\App\Models\Product::get() as $product)
                                        <?php
                                        $expiry_date = strtotime($product->purchase->expiry_date);
                                        $now = strtotime(now());
                                        $perime = $expiry_date - $now;
                                        $perime = floor($perime / 3600 / 24);
                                        ?>
                                        @if (!empty($product->purchase) && $perime >= 0)
                                            @if (!($product->purchase->quantity <= 0))
                                                <option value="{{ $product->id }}">{{ $product->purchase->product }}
                                                    [ {{__("Qté : ")}} {{ $product->purchase->quantity }}]
                                                    [ {{__("Prix : ")}} {{ $product->price }}]
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>  --}}

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Produit <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Nom produit"
                                        class="form-control form-control-sm @error('product') is-invalid @enderror"
                                        name="product" id="product" value="">
                                    <div id="productList">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" placeholder="Nom produit"
                                class="form-control form-control-sm @error('product') is-invalid @enderror"
                                name="id" id="id" value="">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Prix de vente</label>
                                    <input type="number" placeholder="Prix de revient"
                                        class="form-control form-control-sm @error('total_price') is-invalid @enderror"
                                        name="total_price" id="total_price" value="0.00" min="0">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Quantité en stock</label>
                                    <input type="number" placeholder="Quantité en stock"
                                        class="form-control form-control-sm @error('quantite_res') is-invalid @enderror"
                                        name="quantite_res" id="quantite_res" value="" min="1" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Quantité achetée</label>
                                    <input type="number" placeholder="Quantité achetée"
                                        class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                        name="quantity" id="quantity" value="1" min="1">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Client <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" type="text" name="nom_client"
                                        placeholder="Nom du client" value="Inconnue">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Téléphone </label>
                                    <input class="form-control form-control-sm" type="text" name="telephone_client"
                                        placeholder="Telephone du client" value="">
                                </div>
                            </div>
                        <div class="row">
                            <input class="form-control" type="hidden" name="modal_vente" placeholder="" value="oui">

                        </div>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="//code.jquery.com/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
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
        $('#total_price').val($(this).data("price"));
        $('#quantite_res').val($(this).data("quantity"));
        $('#id').val($(this).data("id"));
        $('#productList').fadeOut();
    });
</script>
