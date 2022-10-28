@extends('admin.layouts.plain')

@section('content')
<h1>Connectez-vous</h1>
<p class="account-subtitle">Accès à notre tableau de bord</p>
@if (session('login_error'))
<x-alerts.danger :error="session('login_error')" />
@endif
<!-- Form -->
<form action="{{route('login')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="Email">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="Mot de passe">
	</div>
	<div class="form-group">
		<button class="btn btn-primary btn-block" type="submit">Connectez-vous</button>
	</div>
</form>
<!-- /Form -->

<div class="text-center forgotpass"><a href="{{route('password.request')}}">Mot de passe oublié ?</a></div>
<div class="text-center dont-have">Vous n’avez pas de compte ? <a href="{{route('register')}}">Enregistrer</a></div>
@endsection