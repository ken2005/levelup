@extends('layouts.app')
@section('content')
<h1>

    Voulez vous ajouter {{$bro->name}} ?
</h1>
<a class="lien-discret" href="{{route('doAddBro',['idBro'=>$bro->id])}}" method="POST">

    <button >Ajouter</button>
</a>
<style>
    button{
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
    h1{
        color: #fff;
    }
</style>
@endsection