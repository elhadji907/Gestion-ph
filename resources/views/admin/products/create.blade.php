@extends('admin.layouts.app')

@push('page-css')
@endpush
@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">Ajouter un produit</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Ajouter un produit</li>
        </ul>
    </div>
    <div class="container row justify-content-center pt-5">
        <div class="col-lg-12">
            <a class="btn btn-outline-primary" href="{{ route('products.index') }}"> <i
                    class="fas fa-undo-alt"></i>&nbsp;Arrière</a>
        </div>
    </div>
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body custom-edit-service">
                    <!-- Ajouter un produit -->
                    <form method="post" enctype="multipart/form-data" id="update_service"
                        action="{{ route('products.store') }}">
                        @csrf
                        <div class="service-fields">
                            <div class="row">
                                {{--     <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Produit <span class="text-danger">*</span></label>
                                        <select class="select2 form-select form-control" name="product">
                                            <option disabled selected> Sélectionner un produit</option>
                                            @foreach ($purchases->sortByDesc('created_at') as $purchase)
                                                @if (!($purchase->quantity <= 0) && $purchase->vendu != 'Oui')
                                                    <option value="{{ $purchase->id }}">{{ $purchase->product }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  --}}

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
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Prix de revient</label>
                                        <input type="number" placeholder="Prix de revient"
                                            class="form-control form-control-sm @error('total_price') is-invalid @enderror"
                                            name="total_price" id="total_price" value="0.00" min="0" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Quantité en stock</label>
                                        <input type="number" placeholder="Quantité en stock"
                                            class="form-control form-control-sm @error('quantite_res') is-invalid @enderror"
                                            name="quantite_res" id="quantite_res" value="" min="1" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Prix de vente</label>
                                        <input type="number" placeholder="Prix de vente"
                                            class="form-control form-control-sm @error('price') is-invalid @enderror"
                                            name="price" id="price" value="" min="1">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Rabais (%)</label>
                                        <input type="number" placeholder="Prix de vente"
                                            class="form-control form-control-sm @error('discount') is-invalid @enderror"
                                            name="discount" id="discount" value="0" min="0">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Descriptions</label>
                                        <textarea class="form-control service-desc" name="description" rows="2" placeholder="Faire une petite description du produit">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit" name="form_submit"
                                    value="submit">Mettre en vente</button>
                            </div>
                        </div>
                        {{--   <div class="service-fields mb-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prix de vente<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="price"
                                            value="{{ old('price') }}" placeholder="Prix de vente du médicament">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Rabais (%)<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="discount" value="0">
                                    </div>
                                </div>

                            </div>
                        </div>  --}}
                      {{--    <div class="service-fields mb-3">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Descriptions</label>
                                        <textarea class="form-control service-desc" name="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>  --}}
                    </form>
                    <!-- /Add Product -->
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
    <script type="text/javascript">
        $('#product').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('product.fetche') }}",
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
@endsection

@push('page-js')
@endpush
