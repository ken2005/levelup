
@extends('layouts.app')
@section("page-name")
    Exercice
@endsection
@section('content')
<span id="exercice-modifier">

    <form action="{{route('mettreAJourExercice', ['id' => $exercice->id])}}" method="post">
            @csrf
            <h2 style="text-align: center;">Modifier {{$exercice->name}}</h2>
            <label for="name">Nom de l'Exercice :</label>
            <input required type="text" id="name" name="name" value="{{$exercice->name}}">
            
            <label for="statut">Statut :</label>
            <select name="statut" id="statut">
                <option <?php if($exercice->statut == "prive"){echo "selected";} ?> value="prive">Prive</option>
                <option <?php if($exercice->statut == "public"){echo "selected";} ?> value="public">Public</option>
            </select>
            
            <label for="details">Détails :</label>
            <textarea id="details" name="details" rows="4">{{$exercice->details}}</textarea>
            
            <label for="methode">Méthode d'évolution :</label>
            <select name="methode" id="methode">
                <option <?php if($exercice->methode == "poids"){echo "selected";} ?> value="poids">Poids</option>
                <option <?php if($exercice->methode == "durée"){echo "selected";} ?> value="durée">Durée</option>
                <option <?php if($exercice->methode == "reps"){echo "selected";} ?> value="reps">Reps</option>
            </select>
    
            <button type="submit">Envoyer</button>
    </form>
</span>

@endsection
