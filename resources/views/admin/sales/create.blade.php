@extends('admin.layouts.app')


@push('page-css')
@endpush

@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">Créer une vente</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Créer une vente</li>
        </ul>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
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
                                                        <span> [{{ $perime }}] </span>
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
                                    <input type="number" value="1" class="form-control" name="quantity">
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
    </div>
@endsection


@push('page-js')
@endpush
