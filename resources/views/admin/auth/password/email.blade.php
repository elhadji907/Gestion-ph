@extends('admin.layouts.plain')

@section('content')
<h1>Mot de passe oublié ?</h1>
<p class="account-subtitle">Entrez votre adresse e-mail pour obtenir un lien de réinitialisation du mot de passe </p>
<!-- Form -->
<form action="{{route('password.request')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="Email">
	</div>
	<div class="form-group mb-0">
		<button class="btn btn-primary btn-block" type="submit">Envoyer</button>
	</div>
</form>
<!-- /Form -->

<div class="text-center dont-have">Mémoriser votre mot de passe ? <a href="{{route('login')}}">Connectez-vous</a></div>
@endsection