@extends('layouts.app')
@section('content')
    <style>

        
    </style>
<span id="signup-form">

    <h1>Créer un compte</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('auth.signup') }}" method="post", class="vstack gap-3">

            @csrf

                <div class="form-group">
                    <label for="name">Nom</label>
                    <input required type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    @error('nom')
                    {{ $message }}
                    @enderror
                </div>

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

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le Mot de Passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                    {{ $message }}
                    @enderror
                </div>

                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se souvenir de moi</label>

                <button class="btn btn-primary">Créer un compte</button>


            </form>
        </div>
    </div>
</span>
@endsection

<!-- Kennan -->

