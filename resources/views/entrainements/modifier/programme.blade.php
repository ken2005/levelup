@extends('layouts.app')
@section("page-name")
    Program
@endsection
@section('content')

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
        <div id="exercices" name="exercices" style="width: 100%; min-height:10em; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;display: flex; flex-direction: column;gap: 10px;">
            @foreach ($exos_contenus as $exo)
                <div>

                    <div class="serie" style="display:flex; justify-content:space-between; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                        <div style="width:80%; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                            {{DB::table('exercice')->where('id', $exo->id_exercice)->first()->name}}
                            <input name="exercice[]" value="{{$exo->id_exercice}}" style="display:none;">
                        </div>
                        <input name="nb_reps[]" type="number" maxlength="2" value="{{ $exo->nb_reps }}" placeholder="reps"
                         oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        style="overflow:hidden;width:4em; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                        <a href="{{route('deleteExoFromProg', ['idProg' => $programme->id, 'idExo' => $exo->id_exercice, 'ordre' => DB::table('contenir')->where('id_programme', $programme->id)->where('id_exercice', $exo->id_exercice)->first()->ordre])}}" style="text-decoration:none; color:red; margin-left:10px; font-size:20px;">×</a>
                    </div>
                    <div>
                        <label for="Séries">nombre de séries</label>

                        <input name="nb_series[]" type="number" maxlength="2" value="{{ $exo->nb_series ?? 1 }}" placeholder="séries"
                         oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        style="overflow:hidden;width:4em; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    </div>
                </div>
                <hr style="border: 1px solid #ddd; margin: 0.5em 0;">
            @endforeach
            
            <div onclick="choisirExo()" style=" padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #000; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                Ajouter un exercice
            </div>
        </div>
        
        <dialog id="exos" >
            <div id="myDiv">
                @foreach ($exercices as $exercice)
                    <a class="lien-discret" href="{{route('addExoToProg', ['idProg' => $programme->id, 'idExo' => $exercice->id])}}">
                        <span style="display:block; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                            {{$exercice->name}}
                        </span>
                    </a>
                @endforeach
                <div  style=" padding: 0.7em; margin-top: 0.5em; border: 1px solid #a5a; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    Créer un exercice
                </div>
            </div>
        </dialog>
        
        <button type="submit" >Envoyer</button>
</form>

    
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        appearance: textfield;
        }
        dialog::backdrop {
        background: rgba(100,11,100,.25);
        }
        .blur {
        -webkit-filter: blur(2px);
        -moz-filter: blur(2px);
        -o-filter: blur(2px);
        -ms-filter: blur(2px);
        filter: blur(2px);
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
    
        main form input[type="text"],select,
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

        #exos{
            position: fixed;
                width: 80%;
                margin:auto;
                height: fit-content;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
                background-color: rgba(50,5,50,.5);
                color: #fff;
                transition: all 0.3s ease;
                font-family: 'Roboto', 'Arial', sans-serif;
                font-size: 14px;
        }
    </style>

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