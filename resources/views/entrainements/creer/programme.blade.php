@extends('layouts.app')
@section("page-name")
    Program
@endsection
@section('content')
<form action="{{route('doCreerProgramme')}}" method="post" >
        @csrf
        <h2 style="text-align: center;">Créer un programme</h2>
        <label for="name" >Nom du Programme :</label>
        <input required type="text" id="name" name="name" value="Nouveau Programme" >
        
        <label for="statut">Statut :</label>
        <select name="statut" id="statut" >
            <option selected value="null">Prive</option>
            <option value="0">Public</option>
            @foreach ($squads as $squad)
                <option value="{{$squad->id}}">{{$squad->name}}</option>
            
            @endforeach
        </select>

        <label for="details" >Détails :</label>
        <textarea id="details" name="details" rows="4" ></textarea>
        

        <button type="submit" >Envoyer</button>
    </form>
    
    <style>
        main form {
            width: 80%;
            max-width: 500px;
            margin: 0 auto;
            background-color: rgba(10, 10, 10, 0.7);
            border-radius: 1em;
            padding: 2em;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }
    
        main form h2 {
            text-align: center;
            margin-bottom: 1.5em;
            color: #fff;
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-weight: 600;
        }
    
        main form label {
            display: block;
            margin-top: 1em;
            font-weight: bold;
            font-family: 'Verdana', 'Geneva', sans-serif;
        }
    
        main form input[type="text"],
        main form textarea, main select {
            width: 100%;
            padding: 0.7em;
            margin-top: 0.5em;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s ease;
            font-family: 'Roboto', 'Arial', sans-serif;
            font-size: 14px;
        }
    
        main form input[type="text"]:focus,
        main form textarea:focus {
            outline: none;
            border-color: #fff;
            box-shadow: 0 0 5px rgba(100, 0, 0, 0.5);
        }
    
        main form button[type="submit"] {
            display: block;
            width: 100%;
            padding: 0.8em;
            margin-top: 1.5em;
            background-color: #fff;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
            font-family: 'Segoe UI', 'Tahoma', sans-serif;
        }
    
        main form button[type="submit"]:hover {
            background-color: #f00;
        }
    </style>
@endsection
