@extends('layouts.app')
@section("page-name")
    Exercice
@endsection
@section('content')
<span id="creer-exo">
    <form action="{{route('doCreerExercice')}}" method="post" >
        @csrf
        <h2 style="text-align: center;">Créer un Exercice</h2>
        <label for="name" >Nom de l'Exercice :</label>
        <input required type="text" id="name" name="name" value="Nouvel Exercice" >
        
        <label for="statut">Statut :</label>
        <select name="statut" id="statut" >
            <option value="prive">Prive</option>
            <option value="public">Public</option>
        </select>
        
        <label for="details" >Détails :</label>
        <textarea id="details" name="details" rows="4" ></textarea>
        
        <label for="methode">Méthode d'évolution :</label>
        <select name="methode" id="methode">
            <option value="poids">Poids</option>
            <option value="durée">Durée</option>
            <option value="reps">Reps</option>
        </select>
        <button type="submit" >Envoyer</button>
    </form>
</span>

@endsection
