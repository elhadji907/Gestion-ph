<!-- Ajouter Vente Modale -->
<div class="modal fade" id="add_sales" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vendre un produit</h5>
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
                                <select class="select2 form-select form-control" name="product">
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
                                                    {{--  [{{ $product->purchase->quantity }}]  --}}
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Quantité <span class="text-danger">*</span></label>
                                <input type="number" value="1" class="form-control" name="quantity" min="1">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Client <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="nom_client"
                                    placeholder="Nom du client">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Téléphone </label>
                                <input class="form-control" type="text" name="telephone_client"
                                    placeholder="Telephone du client" value="+221">
                            </div>
                        </div>
                                <input class="form-control" type="hidden" name="modal_vente"
                                    placeholder="" value="oui">
                            
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Effectuer la vente</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Ajouter Vente Modale -->
