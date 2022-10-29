<!-- Ajouter Vente Modale -->
<div class="modal fade" id="add_sales" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vendre le produit</h5>
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
                                        @if (!empty($product->purchase))
                                            @if (!($product->purchase->quantity <= 0))
                                                <option value="{{ $product->id }}">{{ $product->purchase->product }} [{{ $product->purchase->quantity }}]
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Quantité</label>
                                <input type="number" value="1" class="form-control" name="quantity">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Effectuer la vente</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Ajouter Vente Modale -->
