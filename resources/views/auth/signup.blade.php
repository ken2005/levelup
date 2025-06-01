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
        h1{
            color: #fff;
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


            p {
                font-weight: 500;
                color: #fff;
                font-size: 1.4rem;
                margin-top: 0;
                margin-bottom: 60px;
            }


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
            }
        }
    </style>
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
@endsection

<!-- Kennan -->

