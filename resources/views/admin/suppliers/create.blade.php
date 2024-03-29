@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Ajouter un fournisseur</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de bord</a></li>
		<li class="breadcrumb-item active">Ajouter un fournisseur</li>
	</ul>
</div>
<div class="container row justify-content-center pt-5">
	<div class="col-lg-12">
		<a class="btn btn-outline-primary" href="{{ route('suppliers.index') }}"> <i
				class="fas fa-undo-alt"></i>&nbsp;Arrière</a>
	</div>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
				
		
			<!-- Ajouter un fournisseur -->
			<form method="post" enctype="multipart/form-data" action="{{route('suppliers.store')}}">
				@csrf
				
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Fournisseur <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="name" placeholder="Nom du fournisseur">
							</div>
						</div>
						<div class="col-lg-6">
							<label>E-mail</label>
							<input class="form-control" type="text" name="email" id="email" placeholder="E-mail du fournisseur">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Téléphone <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="phone" placeholder="Contact du fournisseur">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Compagnie</label>
							<input class="form-control" type="text" name="company" placeholder="Compagnie">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Addresse <span class="text-danger">*</span></label>
								<input type="text" name="address" class="form-control" placeholder="Adresse">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Produit </label>
							<input type="text" name="product" class="form-control" placeholder="Produit fournis">
						</div>
					</div>
				</div>			
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-12">
							<label>Commentaire</label>
							<textarea name="comment" class="form-control" cols="30" rows="10" placeholder="Commentaires..."></textarea>
						</div>
					</div>
				</div>
				
				<div class="submit-section">
					<button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Envoyer</button>
				</div>
			</form>
			<!-- /Add Medicine -->


			</div>
		</div>
	</div>			
</div>
@endsection	

@push('page-js')
	<!-- Datetimepicker JS -->
	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>	
@endpush

