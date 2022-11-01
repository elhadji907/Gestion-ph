@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-header')
    <div class="col-sm-7 col-auto">
        <h3 class="page-title">Autorisations</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Autorisations</li>
        </ul>
    </div>
    <div class="col-sm-5 col">
        <a href="#add_permission" data-toggle="modal" class="btn btn-primary float-right mt-2">Ajouter une autorisation</a>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="perm-table"
                            class="datatable table table-striped table-bordered table-hover table-center mb-0">
                            <thead>
                                <tr style="boder:1px solid black;">
                                    <th>Nom</th>
                                    <th>Date de création</th>
                                    <th class="text-center action-btn">Actions</th>
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
    <div class="modal fade" id="add_permission" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une autorisation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('permissions.store') }}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Autorisation</label>
                                    <input type="text" name="permission" class="form-control">
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
    <div class="modal fade" id="edit_permission" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l’autorisation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('permissions.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="row form-row">
                            <div class="col-12">
                                <input type="hidden" name="id" id="edit_id">
                                <div class="form-group">
                                    <label>Autorisation</label>
                                    <input type="text" class="form-control perm_name" name="permission">
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
    <script>
        $(document).ready(function() {
            var table = $('#perm-table').DataTable({
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
                ajax: "{{ route('permissions.index') }}",
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Tout"]
                ],
                "order": [
                    [0, 'desc']
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
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    // {data: 'role', name: 'role'},
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
                ]
            });
            $('#perm-table').on('click', '.editbtn', function() {
                $('#edit_permission').modal('show');
                var id = $(this).data('id');
                var permission = $(this).data('name');
                $('#edit_id').val(id);
                $('.perm_name').val(permission);
            });
            //
        });
    </script>
@endpush
