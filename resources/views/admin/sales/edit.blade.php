@extends('admin.layouts.app')


@push('page-css')
    
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Modifier la vente</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de bord</a></li>
		<li class="breadcrumb-item active">Modifier la vente</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
                <!-- Modifier la vente -->
                <form method="POST" action="{{route('sales.update',$sale)}}">
					@csrf
					@method("PUT")
					<div class="row form-row">
						<div class="col-6">
							<div class="form-group">
								<label>Produit <span class="text-danger">*</span></label>
								<select class="select2 form-select form-control edit_product" name="product"> 
									@foreach ($products as $product)
										@if (!empty($product->purchase))
											{{--  @if (!($product->purchase->quantity <= 0))  --}}
												<option {{($product->purchase->id == $sale->product->purchase_id) ? 'selected': ''}} value="{{$product->id}}">{{$product->purchase->product}}</option>
											{{--  @endif  --}}
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label>Quantité</label>
								<input type="number" class="form-control edit_quantity" value="{{$sale->quantity ?? '1'}}" name="quantity" min="1">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Client <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="nom_client" value="{{$sale->nom_client ?? ''}}"
									placeholder="Nom du client">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Téléphone </label>
								<input class="form-control" type="text" name="telephone_client" value="{{$sale->telephone_client ?? ''}}"
									placeholder="Telephone du client">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Enregistrer les modifications</button>
				</form>
                <!--/ Modifier la vente -->
			</div>
		</div>
	</div>			
</div>
@endsection	


@push('page-js')
    
@endpush