@extends('admin.layouts.app')

@push('page-css')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">Ajouter un stock</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Ajouter un stock</li>
        </ul>
    </div>
    <div class="container row justify-content-center pt-5">
        <div class="col-lg-12">
            <a class="btn btn-outline-primary" href="{{ route('purchases.index') }}"> <i
                    class="fas fa-undo-alt"></i>&nbsp;Arrière</a>
        </div>
    </div>
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body custom-edit-service">

                    <!-- Ajouter un médicament -->
                    <form method="post" enctype="multipart/form-data" autocomplete="off"
                        action="{{ route('purchases.store') }}">
                        @csrf
                        <div class="service-fields mb-3">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label>Nom du médicament<span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm @error('product') is-invalid @enderror"
                                            type="text" name="product" placeholder="Nom du médicament">
                                        @error('product')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>TVA (%)<span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm @error('price') is-invalid @enderror"
                                            type="text" name="tva" placeholder="TVA (%)" value="0">
                                        @error('tva')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Catégorie <span class="text-danger">*</span></label>
                                        <select
                                            class="select2 form-control form-control-sm @error('category') is-invalid @enderror"
                                            name="category">
                                            <option disabled selected>Sélectionner une catégorie</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->categorie }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Fournisseur <span class="text-danger">*</span></label>
                                        <select
                                            class="select2 form-control form-control-sm @error('supplier') is-invalid @enderror"
                                            name="supplier">
                                            <option disabled selected>Sélectionner un fournisseur</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prix de revient<span class="text-danger">*</span></label>
                                        <input
                                            class="form-control form-control-sm @error('cost_price') is-invalid @enderror"
                                            type="text" name="cost_price" placeholder="Coût d'achat du médicament">
                                        @error('cost_price')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Quantité<span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                            type="number" name="quantity" placeholder="Quantité achetée" min="1">
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Date d’expiration<span class="text-danger">*</span></label>
                                        <input
                                            class="form-control form-control-sm @error('expiry_date') is-invalid @enderror"
                                            type="date" name="expiry_date">
                                        @error('expiry_date')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Image de médecine</label>
                                        <input type="file" name="image"
                                            class="form-control form-control-sm @error('image') is-invalid @enderror">
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <div>{{ $message }}</div>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit">Envoyer</button>
                        </div>
                    </form>
                    <!-- /Add Medicine -->
                </div>
            </div>
        @endsection

        @push('page-js')
            <!-- Datetimepicker JS -->
            <script src="{{ asset('assets/js/moment.min.js') }}"></script>
            <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
        @endpush
