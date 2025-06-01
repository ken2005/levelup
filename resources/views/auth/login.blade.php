@extends('layouts.app')
@section('content')

    <style>

        .card-body{
            display: flex;
            justify-content: center;
        }

        .form-group{
            display: flex;
            flex-direction: column;
        }
        main h1{
            color: #ffffff;
            text-align: center;
            margin-bottom: 1em;
        }

        form {
            align-items: center;
            justify-content: center;
            background: white;
            padding: 3em;
            width: 400px;
            height: auto;
            border-radius: 20px;
            border-left: 1px solid white;
            border-top: 1px solid white;
            text-align: center;




            input {
                align-items: center;
                width: auto;
                padding: 1em;
                margin-bottom: 2em;
                border: 1px solid black;
                border-radius: 10px;
                color: black;
                font-family: Montserrat, sans-serif;
                font-weight: 500;


                &[type="button"] {
                    margin-top: 10px;
                    width: 150px;
                    font-size: 1rem;

                    &:hover {
                        cursor: pointer;
                    }

                }
            }
            button {
                width: 70%;
                background-color: #ffffff;
                color: black;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s;
                margin: 5px 5px;
                padding: 5px;
                font-size: 14px;
                border: 1px solid #ccc;
                border-radius: 10px;
                margin-bottom: 1em;
            }

            a{
                color: #008232;
            }
        }

    </style>


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
@endsection

<!-- Kennan -->

