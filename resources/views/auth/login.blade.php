@extends('layouts.app')
@section('content')

<span id="login-form">

<h1>Se connecter</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('auth.login') }}" method="post", class="vstack gap-3">

        @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                {{ $message }}
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de Passe</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                {{ $message }}
                @enderror
            </div>

            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Se souvenir de moi</label>
            <button class="btn btn-primary">Se connecter</button>

            <p>Vous n'avez pas de compte ? <a href="{{route("auth.signup")}}">Inscrivez-vous !</a></p>
        </form>
    </div>
</div>
</span>
@endsection

<!-- Kennan -->

