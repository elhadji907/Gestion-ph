@extends('admin.layouts.app')

<x-assets.datatables />


@push('page-css')
@endpush

@push('page-header')
    <div class="col-sm-7 col-auto">
        <h3 class="page-title">{{ $title }}</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Générer une facture de vente</li>
        </ul>
    </div>
    <div class="col-sm-5 col">
        <a href="#generate_facture" data-toggle="modal" class="btn btn-primary float-right mt-2">Générer une facture</a>
    </div>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            @isset($sales)
                <!--  Rapport des ventes -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sales-table" class="datatable table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Médicament</th>
                                        <th>Qté</th>
                                        <th>Prix total (CFA)</th>
                                        <th>Client</th>
                                        <th>Téléphone</th>
                                        <th>Vendeur(se)</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        @if (!empty($sale->product->purchase))
                                            <tr>
                                                <td>
                                                    {{ $sale->code }}
                                                </td>
                                                <td>
                                                    {{ $sale->product->purchase->product }}
                                                    @if (!empty($sale->product->purchase->image))
                                                        <span class="avatar avatar-sm mr-2">
                                                            <img class="avatar-img"
                                                                src="{{ asset('storage/purchases/' . $sale->product->purchase->image) }}"
                                                                alt="image">
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $sale->quantity }}</td>
                                                {{--  <td>{{AppSettings::get('app_currency', 'CFA')}} {{($sale->total_price)}}</td>  --}}
                                                <td>{{ $sale->total_price }}</td>
                                                <td>{{ $sale->nom_client }}</td>
                                                <td>{{ $sale->telephone_client }}</td>
                                                <td>{{ $sale->created_by }}</td>
                                                <td>{{ date_format(date_create($sale->created_at), 'd/m/yy') }}</td>

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- / Rapport des ventes -->
            @endisset


        </div>
    </div>

    <!-- Generate Modal -->
    <div class="modal fade" id="generate_facture" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Générer une facture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('sales.facture') }}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="number" name="code" class="form-control code" placeholder="Ajouter un code" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block submit_report">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Generate Modal -->
@endsection

@push('page-js')
    <script>
        $(document).ready(function() {
            $('#sales-table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'collection',
                    text: 'Télécharger facture',
                    buttons: [{
                            extend: 'pdf',
                            exportOptions: {
                                columns: "thead th:not(.action-btn)"
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: "thead th:not(.action-btn)"
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: "thead th:not(.action-btn)"
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: "thead th:not(.action-btn)"
                            }
                        }
                    ]
                }]
            });
        });
    </script>
@endpush
