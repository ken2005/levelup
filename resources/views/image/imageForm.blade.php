@extends('layouts.app')
@section('content')
<form action="{{route('addImage')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="image">Sélectionnez une image</label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-primary">Importer</button>
</form>
<style>
    main form input[type="number"] {
            -moz-appearance: textfield;
        }
        main form input[type="number"]::-webkit-inner-spin-button, 
        main form input[type="number"]::-webkit-outer-spin-button,
        main form input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0; 
        }

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
    
        main form input,select,
        main form textarea {
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
    
        main form input:focus,select:focus,
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
