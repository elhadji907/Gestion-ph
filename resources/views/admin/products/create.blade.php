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
                                        <select class="select2 form-select form-control" name="product">
                                            <option disabled selected> Sélectionner un produit</option>
                                            @foreach ($purchases->sortByDesc('created_at') as $purchase)
                                                @if (!($purchase->quantity <= 0) && ($purchase->vendu !="Oui"))
                                                    <option value="{{ $purchase->id }}">{{ $purchase->product }},
                                                        {{--  [{{ $purchase->quantity }}] 
                                                        du {{ optional($purchase->created_at)->format('d/m/yy') }}  --}}
                                                       {{--   <p class="noti-time"><span
                                                                class="notification-time"> ajouté {{ $purchase->created_at->diffForHumans() }}</span>
                                                        </p>  --}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="service-fields mb-3">
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
@endsection

@push('page-js')
@endpush
