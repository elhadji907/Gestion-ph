@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">{{ $suppliers->name ?? '' }}</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item active">Tableau de bord</li>
        </ul>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card card-table">
               {{--   <div class="card-header">
                    <h4 class="card-title ">Ventes d’aujourd’hui</h4>
                </div>  --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="suppliers-table" class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Catégorie</th>
                                    <th>Date</th>
                                    <th>Qté</th>
                                    <th>Prix</th>
                                    <th>Date expiration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($suppliers->purchases as $purchase)
                                    <tr>
                                        <td>{!! $purchase->product ?? '' !!}</td>
                                        <td>{!! $purchase->category->categorie ?? '' !!}</td>
                                        <td>{!! $purchase->created_at->format('d/m/Y') !!}</td>
                                        <td>{!! $purchase->quantity ?? '' !!}</td>
                                        <td>{!! $purchase->cost_price ?? '' !!}</td>
                                        <td>{!! date_format(date_create($purchase->expiry_date), 'd/m/Y') !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#suppliers-table').DataTable({
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
