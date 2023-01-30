@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
@endpush

@push('page-header')
    <div class="col-sm-7 col-auto">
        <h3 class="page-title">Fournisseur</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Fournisseur</li>
        </ul>
    </div>
    <div class="col-sm-5 col">
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary float-right mt-2">Ajouter un nouveau</a>
    </div>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <!-- Suppliers -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="supplier-table" class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Fournisseur</th>
                                        <th>Qté</th>
                                        <th>Montant</th>
                                        <th>Téléphone</th>
                                        <th>Addresse</th>
                                        <th>Email</th>
                                        <th width="8%" class="action-btn"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($suppliers as $supplier)
							<tr>
								<td>										
									{{$supplier->product}}
								</td>
								<td>{{$supplier->name}}</td>
								<td>{{$supplier->phone}}</td>
								<td>{{$supplier->email}}</td>
								<td>{{$supplier->address}}</td>
								<td>{{$supplier->company}}</td>
								<td>
									<div class="actions">
										<a class="btn btn-sm bg-success-light" href="{{route('edit-supplier',$supplier)}}">
											<i class="fe fe-pencil"></i> Edit
										</a>
										<a data-id="{{$supplier->id}}" href="javascript:void(0);" class="btn btn-sm bg-danger-light deletebtn" data-toggle="modal">
											<i class="fe fe-trash"></i> Delete
										</a>
									</div>
								</td>
							</tr>
							@endforeach							 --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Suppliers-->

            </div>
        </div>
    </div>
@endsection

@push('page-js')
    <script>
        $(document).ready(function() {
            var table = $('#supplier-table').DataTable({
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
                ajax: "{{ route('suppliers.index') }}",

                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Tout"]
                ],
                "order": [
                    [2, 'DESC']
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
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'count',
                        name: 'count'
                    },
                    {
                        data: 'somme',
                        name: 'somme'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>
@endpush
