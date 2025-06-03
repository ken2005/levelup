@extends('layouts.app')
@section("page-name")
    Squad
@endsection
@section('content')
<span id="creer-squad">
    <form action="{{route('doCreateSquad')}}" method="post" >
        @csrf
        <h2 style="text-align: center;">Créer une Squad</h2>
        <label for="name" >Nom la Squad :</label>
        <input required type="text" id="name" name="name" value="Squad de {{\Illuminate\Support\Facades\Auth::user()->name}}">
        <button type="submit" >Envoyer</button>
    </form>
</span>

@endsection
