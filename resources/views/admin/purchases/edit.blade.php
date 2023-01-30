@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Modifier l’achat</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de bord</a></li>
		<li class="breadcrumb-item active">Modifier l’achat</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
			
			<!-- Modifier le fournisseur -->
			<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('purchases.update',$purchase)}}">
				@csrf
				@method("PUT")
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-9">
							<div class="form-group">
								<label>Nom du médicament<span class="text-danger">*</span></label>
								<input class="form-control form-control-sm @error('product') is-invalid @enderror" type="text" value="{{$purchase->product}}" name="product" >
								@error('product')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								{{--  item==tva  --}}
								<label>TVA (%)<span class="text-danger">*</span></label>
								<input class="form-control form-control-sm @error('price') is-invalid @enderror"
									type="text" name="tva" placeholder="TVA (%)" value="{{$purchase->item}}">
								@error('tva')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Catégorie <span class="text-danger">*</span></label>
								<select class="select2 form-select form-control form-control-sm @error('category') is-invalid @enderror" name="category"> 
									@foreach ($categories as $category)
										<option {{($purchase->category->id == $category->id) ? 'selected': ''}} value="{{$category->id}}">{{$category->categorie}}</option>
									@endforeach
								</select>
								@error('category')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Fournisseur <span class="text-danger">*</span></label>
								<select class="select2 form-select form-control form-control-sm @error('supplier') is-invalid @enderror" name="supplier"> 
									@foreach ($suppliers as $supplier)
										<option @if($purchase->supplier->id == $supplier->id) selected @endif value="{{$supplier->id}}">{{$supplier->name}}</option>
									@endforeach
								</select>
								@error('supplier')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
				
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Prix de revient<span class="text-danger">*</span></label>
								<input class="form-control form-control-sm @error('cost_price') is-invalid @enderror" value="{{$purchase->cost_price}}" type="text" name="cost_price">
								@error('cost_price')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Quantité<span class="text-danger">*</span></label>
								<input class="form-control form-control-sm @error('quantity') is-invalid @enderror" value="{{$purchase->quantity}}" type="number" name="quantity" min="1">
								@error('quantity')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Date d’expiration<span class="text-danger">*</span></label>
								<input class="form-control form-control-sm @error('expiry_date') is-invalid @enderror" value="{{$purchase->expiry_date}}" type="date" name="expiry_date">
								@error('expiry_date')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Image de médecine</label>
								<input type="file" name="image" value="{{$purchase->image}}" class="form-control form-control-sm @error('image') is-invalid @enderror">
								@error('image')
									<span class="invalid-feedback" role="alert">
										<div>{{ $message }}</div>
									</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="submit-section">
					<button class="btn btn-primary submit-btn" type="submit" >Envoyer</button>
				</div>
			</form>
			<!-- /Edit Supplier -->

			</div>
		</div>
	</div>			
</div>
@endsection	



@push('page-js')
	<!-- Select2 JS -->
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endpush




