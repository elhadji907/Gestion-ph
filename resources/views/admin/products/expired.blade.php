@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
	
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Périmé</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('products.index')}}">Produits</a></li>
		<li class="breadcrumb-item active">Périmé</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
	
		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="expired-product" class="datatable table table-striped table-bordered table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Nom du produit</th>
								<th>Catégorie</th>
								<th>Prix (CFA)</th>
								<th>Quantité</th>
								<th>Rabais</th>
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
		<!-- /Expired Products -->
		
	</div>
</div>

@endsection

@push('page-js')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#expired-product').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('expired')}}",
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
</script> 
@endpush