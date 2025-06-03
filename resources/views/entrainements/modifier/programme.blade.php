@extends('layouts.app')
@section("page-name")
    Program
@endsection
@section('content')

<span id="modifier-programme">
    <form action="{{route('doModifierProgramme',["idProg" => $programme->id])}}" method="post" >
        @csrf
        <h2 style="text-align: center;">Modifier {{$programme->name}}</h2>
        <label for="name" >Nom du Programme :</label>
        <input required type="text" id="name" name="name" value="{{$programme->name}}" >
        
        <label for="statut">Statut :</label>
        <select name="statut" id="statut" >
            <option <?php if($programme->id_squad == "prive"){echo "selected";} ?> value="">Prive</option>
            <option <?php if($programme->id_squad == "public"){echo "selected";} ?> value="0">Public</option>
            @foreach ($squads as $squad)
                <option <?php if($programme->id_squad == $squad->id){echo "selected";} ?> value="{{$squad->id}}">{{$squad->name}}</option>
            @endforeach
        </select>
        
        <label for="details" >Détails :</label>
        <textarea id="details" name="details" rows="4" >{{$programme->details}}</textarea>
        
        <label for="series" >Séries :</label>
        <div id="exercices" name="exercices">
            @foreach ($exos_contenus as $exo)
                <div>
                    <div class="serie">
                        <div class="exercice-name">
                            {{DB::table('exercice')->where('id', $exo->id_exercice)->first()->name}}
                            <input name="exercice[]" value="{{$exo->id_exercice}}" style="display:none;">
                        </div>
                        <input name="nb_reps[]" type="number" maxlength="2" value="{{ $exo->nb_reps }}" placeholder="reps"
                         oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                        <a href="{{route('deleteExoFromProg', ['idProg' => $programme->id, 'idExo' => $exo->id_exercice, 'ordre' => DB::table('contenir')->where('id_programme', $programme->id)->where('id_exercice', $exo->id_exercice)->first()->ordre])}}" class="delete-btn">×</a>
                    </div>
                    <div>
                        <label for="Séries">nombre de séries</label>
                        <input name="nb_series[]" type="number" maxlength="2" value="{{ $exo->nb_series ?? 1 }}" placeholder="séries"
                         oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    </div>
                </div>
                <hr>
            @endforeach
            
            <div onclick="choisirExo()" class="add-exercice">
                Ajouter un exercice
            </div>
        </div>
        
        <dialog id="exos">
            <div id="myDiv">
                @foreach ($exercices as $exercice)
                    <a class="lien-discret" href="{{route('addExoToProg', ['idProg' => $programme->id, 'idExo' => $exercice->id])}}">
                        <span class="exercice-item">
                            {{$exercice->name}}
                        </span>
                    </a>
                @endforeach
                <div class="create-exercice">
                    Créer un exercice
                </div>
            </div>
        </dialog>
        
        <button type="submit">Envoyer</button>
    </form>
</span>
<script>
    function choisirExo(){
        document.getElementById('exos').showModal();
        document.getElementsByTagName('body')[0].classList.add("blur")
    }
    const myDialog = document.getElementById('exos');
    myDialog.addEventListener('click', () => {
        myDialog.close();
        document.getElementsByTagName('body')[0].classList.remove("blur")
    });

    const myDiv = document.getElementById('myDiv');
    myDiv.addEventListener('click', (event) => event.stopPropagation());
</script>
@endsection