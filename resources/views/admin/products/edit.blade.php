@extends('admin.layouts.app')

@push('page-css')
@endpush

@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">Modifier le produit</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Modifier le produit</li>
        </ul>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body custom-edit-service">


                    <!-- Modifier le produit -->
                    <form method="post" enctype="multipart/form-data" id="update_service"
                        action="{{ route('products.update', $product) }}">
                        @csrf
                        @method('PUT')
                        <div class="service-fields mb-3">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Produit <span class="text-danger">*</span></label>
                                        <select class="select2 form-select form-control" name="product">
                                            @foreach ($purchases as $purchase)
                                                @if (!empty($product->purchase))
                                                    <option {{ $product->purchase->id == $purchase->id ? 'selected' : '' }}
                                                        value="{{ $purchase->id }}">{{ $purchase->product }}</option>
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
                                            value="{{ $product->price }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Rabais : {{ number_format($product->discount, 0, '.', ' ') }}(%)</label>
                                        <input class="form-control" value="0" type="text" name="discount">
                                    </div>
                                </div>

                            </div>
                        </div>
						<input class="form-control" value="{{ $product->discount }}" type="hidden"
						name="discounte">

                        <div class="service-fields mb-3">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Descriptions </label>
                                        <textarea class="form-control service-desc" value="{{ $product->description }}" name="description">{{ $product->description }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" name="form_submit"
                                value="submit">Envoyer</button>
                        </div>
                    </form>
                    <!-- /Modifier le produit -->
                </div>
            </div>
        </div>
    </div>
@endsection


@push('page-js')
@endpush
