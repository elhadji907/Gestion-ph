@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
@endpush

@push('page-header')
    <div class="col-sm-7 col-auto">
        <h3 class="page-title">Catégories</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Catégories</li>
        </ul>
    </div>
    {{--   <div class="col-sm-5 col">
        <a href="#add_categories" data-toggle="modal" class="btn btn-primary float-right mt-2">Ajouter une catégorie</a>
    </div>  --}}
@endpush
@section('content')
    <div class="row">

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-table"></i>
                    Ajouter des catégories</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        {{--        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif  --}}
                        {{--  @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif  --}}
                        <table class="table table-bordered" id="dynamicAddRemove">
                            <tr>
                                <th>Catégories</th>
                                <th width="15%">Action</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="categories[0][categorie]" placeholder="Entrer la catégorie"
                                        class="form-control" /></td>
                                <td><button type="button" name="add" id="add-btn" class="btn btn-success"
                                        title="Ajouter une ligne">Ajouter</button>
                                </td>
                            </tr>
                        </table>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-left mt-2">
                            <button type="submit" class="btn btn-outline-success"><i
                                    class="far fa-save"></i>&nbsp;Enregistrer</button>
                        </div>
                        {{--  <button type="submit" class="btn btn-success" title="Enregistrer"><i
                                class='fa fa-save'></i>&nbsp;Enregistrer</button>  --}}
                    </form>
                </div>
            </div>
        </div>
        {{--     <div class="col-sm-4">
            <div class="modal-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="row form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Ajouter une catégorie <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Ajouter nouvelle catégorie" autocomplete="name">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
                </form>
            </div>
        </div>  --}}
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-table"></i>
                    Liste des catégories</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="category-table"
                            class="datatable table table-striped table-bordered table-hover table-center mb-0">
                            <thead>
                                <tr style="boder:1px solid black;">
                                    <th>Nom</th>
                                    <th style="width:10%;">Date</th>
                                    <th class="text-center action-btn-sm" style="width:7%;"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_categories" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catégorie</label>
                                    <input type="text" name="categorie" class="form-control" placeholder="Catégorie">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /ADD Modal -->

    <!-- Edit Details Modal -->
    <div class="modal fade" id="edit_category" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('categories.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="row form-row">
                            <div class="col-12">
                                <input type="hidden" name="id" id="edit_id">
                                <div class="form-group">
                                    <label>Catégorie</label>
                                    <input type="text" class="form-control edit_name" name="categorie">
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Details Modal -->
@endsection

@push('page-js')
    <script type="text/javascript">
        var i = 0;
        $("#add-btn").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><input type="text" name="categories[' + i +
                '][categorie]" placeholder="Entrer une autre catégorie" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Supprimer</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#category-table').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy"></i> Copy',
                        titleAttr: 'Copy'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        titleAttr: 'Excel'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        titleAttr: 'CSV'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        orientation: 'landscape',
                        pageSize: 'RA4',
                        titleAttr: 'PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print'
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns: [{
                        data: 'categorie',
                        name: 'categorie'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "Tout"]
                ],
                "order": [
                    [1, 'desc']
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
                },
            });
            $('#category-table').on('click', '.editbtn', function() {
                $('#edit_category').modal('show');
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#edit_id').val(id);
                $('.edit_name').val(name);
            });
            //
        });
    </script>
@endpush
