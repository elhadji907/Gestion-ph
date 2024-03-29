@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/chart.js/Chart.min.css') }}">
@endpush

@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">Bienvenue {{ auth()->user()->name ?? '' }}!</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item active">Tableau de bord</li>
        </ul>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ AppSettings::get('app_currency', 'F CFA ') }}
                                {{ number_format($today_sales, 2, '.', ' ') }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Ventes au comptant d’aujourd’hui </h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6 col-12">
            <a href="{{ route('categories.index') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-success">
                                <i class="fe fe-credit-card"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $total_categories }}</h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">

                            <h6 class="text-muted">Catégories</h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success w-50"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-sm-6 col-12">
            <a href="{{ route('expired') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-danger border-danger">
                                <i class="fe fe-folder"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $total_expired_products }}</h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">

                            <h6 class="text-muted">Périmés</h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger w-50"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-sm-6 col-12">
            <a href="{{ route('outstock') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-warning border-warning">
                                <i class="fe fe-close"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $stock_out_purchases }}</h3>
                            </div>
                        </div>
                        <div class="dash-widget-warning">

                            <h6 class="text-muted">Rupture stock</h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning w-50"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{--  @can('view-users')  --}}
        <div class="col-xl-2 col-sm-6 col-12">
            @can('view-users')
                <a href="{{ route('users.index') }}" target="_blank">
                @endcan
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-info border-info">
                                <i class="fe fe-users"></i>
                            </span>
                            <div class="dash-count">
                                @can('view-users')
                                    <h3>{{ \DB::table('users')->count() }}</h3>
                                @endcan
                            </div>
                        </div>
                        <div class="dash-widget-info">

                            <h6 class="text-muted">Utilisateurs système</h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-info w-50"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @can('view-users')
                </a>
            @endcan
        </div>
        {{--  @endcan  --}}
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card card-table p-3">
                <div class="card-header">
                    <h4 class="card-title ">Ventes d’aujourd’hui</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sales-table" class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th style="width:5%;">Produit</th>
                                    <th>Qté</th>
                                    <th>Prix total (CFA)</th>
                                    <th>Client</th>
                                    <th>Heure</th>
                                    <th><i class="fa fa-print" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{!! $sale->code ?? '' !!}</td>
                                        <td>{!! $sale->product->purchase->product ?? '' !!}</td>
                                        <td>{!! $sale->quantity ?? '' !!}</td>
                                        <td>{{ number_format($sale->total_price, 2, '.', ' ') }}</td>
                                        <td>{!! $sale->nom_client ?? '' !!}</td>
                                        {{--  <td>{!! optional($sale->created_at)->translatedFormat('d F Y à H\h i') ?? '' !!}</td>  --}}
                                        <td>{!! $sale->created_at->diffForHumans() !!}</td>
                                        <td><a href="{{ url('admin/sales/facture', ['$id' => $sale->id]) }}" class="showbtn"
                                                target="_blank" title="Imprimer facture"><button
                                                    class="btn btn-sm bg-success-light"><i class="fa fa-print"
                                                        aria-hidden="true"></i></button></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-6">

            <!-- Pie Chart -->
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title text-center">Ressources</h4>
                </div>
                <div class="card-body">
                    <div style="">
                        {!! $pieChart->render() !!}
                    </div>
                </div>
            </div>
            <!-- /Pie Chart -->

        </div>


    </div>
@endsection

@push('page-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sales-table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy"></i> ',
                        titleAttr: 'Copier'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> ',
                        titleAttr: 'Excel'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i> ',
                        titleAttr: 'CSV'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> ',
                        orientation: 'landscape',
                        pageSize: 'RA4',
                        titleAttr: 'PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> ',
                        titleAttr: 'Imprimer'
                    }
                ],
                "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "Tout"]
                ],
                "order": [
                    [0, 'DESC']
                ],
                language: {
                    "sProcessing": "Traitement en cours...",
                    "sSearch": "Rechercher&nbsp;:",
                    "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                    "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                        "sFirst": "Premier",
                        "sPrevious": "Pr&eacute;c&eacute;dent",
                        "sNext": "Suivant",
                        "sLast": "Dernier"
                    },
                    "oAria": {
                        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    },
                    "select": {
                        "rows": {
                            _: "%d lignes séléctionnées",
                            0: "Aucune ligne séléctionnée",
                            1: "1 ligne séléctionnée"
                        }
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endpush
