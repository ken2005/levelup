@extends('layouts.app')
@section("page-name")
    Program
@endsection
@section('content')
<span id="creer-programme">
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
</span>
@endsection
