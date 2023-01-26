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
    {{--  <div class="col-sm-12">
	<a href="{{route('products.index')}}" class="btn btn-primary float-right mt-2">Retour</a>
</div>  --}}


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
                        <div class="service-fields mb-3">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Produit <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Nom produit"
                                            class="form-control form-control-sm @error('producte') is-invalid @enderror"
                                            name="producte" id="producte" value="{{ old('producte') }}">
                                        @error('producte')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                        <input type="hidden" placeholder="Id produit"
                                            class="form-control form-control-sm @error('id_product') is-invalid @enderror"
                                            name="id_product" id="id_product" value="{{ old('id_product') }}">
                                        <div id="producteList">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Prix de revient <span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Entrer prix de vente"
                                            class="form-control form-control-sm @error('total_price') is-invalid @enderror"
                                            name="total_price" id="total_price" value="0.00" min="0" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Quantité en stock <span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Quantité en stock"
                                            class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                            name="quantity" id="quantity" value="0.00" min="0" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Prix de vente <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm @error('pice') is-invalid @enderror"
                                            type="text" name="price" value="{{ old('price') }}"
                                            placeholder="Prix de vente du médicament">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Rabais (%)<span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm" type="text" name="discount"
                                            value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="service-fields mb-3">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Descriptions</label>
                                        <textarea class="form-control service-desc" name="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" name="form_submit"
                                value="submit">Envoyer</button>
                        </div>
                    </form>
                    <!-- /Add Product -->
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
    {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  --}}
    <script type="text/javascript">
        $('#producte').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('producte.autocomplete') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#producteList').fadeIn();
                        $('#producteList').html(data);
                    }
                });
            }
        });
        $(document).on('click', 'li', function() {
            {{--  Ici je récupère le produit selectioné sur la liste autoload  --}}
            $('#producte').val($(this).text());
            $('#total_price').val($(this).data("price"));
            $('#quantity').val($(this).data("quantity"));
            $('#id_product').val($(this).data("id"));
            $('#producteList').fadeOut();
        });
    </script>
@endsection
@push('page-js')
@endpush
