@extends('layouts.app')
@section('content')
<img src="../storage/{{$image->image}}" width="100%" alt="">
<a href="{{route('imageForm')}}" class="lien-discret">
    <button type="button" class="btn btn-primary">
    Modifier
    </button>
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
</style>
@endsection