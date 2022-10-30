@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
	
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Stock épuisé</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('products.index')}}">Produits</a></li>
		<li class="breadcrumb-item active">Stock épuisé</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
	
		<!-- Stock de produit épuisé -->
		<div class="card card-table">
			<div class="card-body">
				<div class="table-responsive">
					<table id="outstock-product" class="atatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Nom du produit</th>
								<th>Catégorie</th>
								<th>Prix (CFA)</th>
								<th>Quantité</th>
								{{--  <th>Rabais</th>  --}}
								<th>Expirer</th>
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Stock de produit épuisé-->
		
	</div>
</div>


@endsection


@push('page-js')
{{--  <script>
    $(document).ready(function() {
        var table = $('#outstock-product').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('outstock')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'category', name: 'category'},
                {data: 'price', name: 'price'},
                {data: 'quantity', name: 'quantity'},
                {data: 'discount', name: 'discount'},
				{data: 'expiry_date', name: 'expiry_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
</script>   --}}
<script>
    $(document).ready(function() {
        var table = $('#outstock-product').DataTable({
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
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "Tout"]
			],
            processing: true,
            serverSide: true,
            ajax: "{{route('outstock')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'category', name: 'category'},
                {data: 'price', name: 'price'},
                {data: 'quantity', name: 'quantity'},
                {{--  {data: 'discount', name: 'discount'},  --}}
				{data: 'expiry_date', name: 'expiry_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
			language: {
			  "sProcessing":     "Traitement en cours...",
			  "sSearch":         "Rechercher&nbsp;:",
			  "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
			  "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
			  "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
			  "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
			  "sInfoPostFix":    "",
			  "sLoadingRecords": "Chargement en cours...",
			  "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
			  "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
			  "oPaginate": {
				  "sFirst":      "Premier",
				  "sPrevious":   "Pr&eacute;c&eacute;dent",
				  "sNext":       "Suivant",
				  "sLast":       "Dernier"
			  },
			  "oAria": {
				  "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
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
        
    });
</script> 
@endpush