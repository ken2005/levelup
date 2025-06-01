@extends('layouts.app')
@section("page-name")
    Program
@endsection
@section('content')

<form id="mainForm" action="{{route('doModifierEntrainement',["idEntrainement" => $entrainement->id])}}" method="post" >
        @csrf
        <h2 style="text-align: center;">Modifier un entrainement</h2>
        <label for="details" >Détails :</label>
        <textarea id="details" name="details" rows="4">{{$entrainement->details}}</textarea>
                <label for="repos">Temps de repos (secondes) :</label>
                    <div style="display: flex; align-items: center; gap: 1.5em; background: rgba(255, 255, 255, 0.05); padding: 1.2em; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 1em 0;">
                        <input type="number" id="repos" name="repos" min="0" max="300" value="60" 
                        style="width: 6em; padding: 0.8em; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 6px; background-color: rgba(255, 255, 255, 0.08); color: #fff; font-family: 'Roboto', sans-serif; font-size: 14px; transition: all 0.3s ease; outline: none;">
                        <button type="button" id="startButton" style="padding: 0.8em 1.5em; border-radius: 6px; border: none; background: linear-gradient(145deg, #4CAF50, #45a049); color: white; cursor: pointer; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            Play
                        </button>
                        <div id="chrono" style="display: none; background: rgba(0,0,0,0.3); border-radius: 8px; padding: 0.5em 1em; text-align: center; font-size: 1.5em; color: #fff; font-family: 'Roboto', sans-serif; letter-spacing: 2px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);">
                            <span id="minutes">00</span>:<span id="seconds">00</span>
                        </div>
                    </div>
                <script>
                    let timer;
                    let timeLeft;
        
                    function startTimer(duration) {
                        clearInterval(timer);
                        timeLeft = duration;
                        document.getElementById('repos').style.display = 'none';
                        document.getElementById('chrono').style.display = 'block';
                        document.getElementById('startButton').textContent = 'Stop';
                        document.getElementById('startButton').style.background = 'linear-gradient(145deg, #ff4444, #cc0000)';
                        
                        timer = setInterval(function() {
                            let minutes = parseInt(timeLeft / 60, 10);
                            let seconds = parseInt(timeLeft % 60, 10);
        
                            minutes = minutes < 10 ? "0" + minutes : minutes;
                            seconds = seconds < 10 ? "0" + seconds : seconds;
        
                            document.getElementById('minutes').textContent = minutes;
                            document.getElementById('seconds').textContent = seconds;
        
                            if (--timeLeft < 0) {
                                stopTimer();
                                if (window.navigator && window.navigator.vibrate) {
                                    navigator.vibrate([1000, 500, 1000, 500, 1000]);
                                }
                            }
                        }, 1000);
                    }

                    function stopTimer() {
                        clearInterval(timer);
                        document.getElementById('chrono').style.display = 'none';
                        document.getElementById('repos').style.display = 'block';
                        document.getElementById('startButton').textContent = 'Play';
                        document.getElementById('startButton').style.background = 'linear-gradient(145deg, #4CAF50, #45a049)';
                    }
        
                    document.getElementById('startButton').addEventListener('click', function(e) {
                        e.preventDefault();
                        if(this.textContent === 'Play') {
                            startTimer(document.getElementById('repos').value);
                        } else {
                            stopTimer();
                        }
                    });
                </script>
                        
        <label for="series" >Séries :</label>
        <div id="exercices" name="exercices" style="width: 100%; min-height:10em; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
            @foreach ($exos as $exo)
                <div style="display:flex; justify-content:space-between; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    <div style="width:90%; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                        {{$exo->name}}
                        <input name="exercice[]" value="{{$exo->id}}" style="display:none;">
                    </div>
                    <input name="nb_reps[]" type="number" maxlength="2" value="{{$exo->nb_reps}}"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        style="overflow:hidden;width:3em; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    <div id="chrono-{{$exo->id}}" style="display: none;">
                        <span id="minutes-{{$exo->id}}">00</span>:<span id="seconds-{{$exo->id}}">00</span>
                    </div>
                    <input id="dificulte-{{$exo->id}}" name="dificulte[]" type="number" maxlength="3" value="{{$exo->dificulte}}" placeholder="{{ $exo->methode}}"
                        style="overflow:hidden;width:5em; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    <div class="timer-container" style="display: flex; align-items: center;">
                        @if($exo->methode == "durée")
                        <button type="button" id="startButton-{{$exo->id}}" onclick="toggleTimer('{{$exo->id}}')" style="margin-left: 5px; padding: 5px 10px; border-radius: 100%; border: none; background: linear-gradient(145deg, #4CAF50, #45a049); color: white; cursor: pointer;">▶</button>
                        @endif
                    </div>
                    <button type="submit" formaction="{{ route('supprimerExoEntrainement', ['idEntrainement' => $entrainement->id, 'idSerie' => $exo->idSerie]) }}" style="margin-left: 5px; padding: 5px 10px; border-radius: 4px; border: none; background-color: rgba(0,0,0,0); color: white; text-decoration: none; cursor: pointer;width: 1em;">X</button>
                    <script>
                        let timer{{$exo->id}};
                        let timeLeft{{$exo->id}} = 0;
                        
                        function toggleTimer(id) {
                            const button = document.getElementById('startButton-' + id);
                            const chrono = document.getElementById('chrono-' + id);
                            const input = document.getElementById('dificulte-' + id);
                            
                            if(button.textContent === '▶') {
                                timeLeft{{$exo->id}} = 0;
                                button.textContent = '■';
                                button.style.background = 'linear-gradient(145deg, #ff4444, #cc0000)';
                                chrono.style.display = 'block';
                                input.style.display = 'none';
                                
                                document.getElementById('minutes-' + id).textContent = "00";
                                document.getElementById('seconds-' + id).textContent = "00";
                                
                                timer{{$exo->id}} = setInterval(function() {
                                    timeLeft{{$exo->id}}++;
                                    let minutes = parseInt(timeLeft{{$exo->id}} / 60, 10);
                                    let seconds = parseInt(timeLeft{{$exo->id}} % 60, 10);
                                    
                                    minutes = minutes < 10 ? "0" + minutes : minutes;
                                    seconds = seconds < 10 ? "0" + seconds : seconds;
                                    
                                    document.getElementById('minutes-' + id).textContent = minutes;
                                    document.getElementById('seconds-' + id).textContent = seconds;
                                }, 1000);
                            } else {
                                clearInterval(timer{{$exo->id}});
                                button.textContent = '▶';
                                button.style.background = 'linear-gradient(145deg, #4CAF50, #45a049)';
                                chrono.style.display = 'none';
                                input.style.display = 'block';
                                input.value = timeLeft{{$exo->id}};
                            }
                        }
                    </script>
                    <style>
                        #chrono-{{$exo->id}} {
                            overflow: hidden;
                            width: 5em;
                            padding: 0.7em 0;
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
                    </style>
                </div>
            @endforeach            
            <div onclick="choisirExo()" style="padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #000; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                Ajouter un exercice
            </div>
        </div>

        <dialog id="exos">
            <div id="myDiv">
                @foreach ($exercices as $exercice)
                    <button type="submit" formaction="{{route('ajouterExoEntrainement', ['idEntrainement' => $entrainement->id, 'idExo' => $exercice->id])}}" style="width: 100%; background: none; border: none; padding: 0; margin: 0; text-align: left; cursor: pointer;">
                        <span style="display:block; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;font-weight:lighter;">
                            {{$exercice->name}}
                        </span>
                    </button>
                @endforeach
                <div style="padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #000; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    Créer un exercice
                </div>
            </div>
        </dialog>
        <button type="submit" style="margin-top: 1em; padding: 0.8em 1.5em; border-radius: 6px; border: none; background: white; color: black; cursor: pointer; font-weight: 500; width: 100%;">Envoyer</button>
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
    
        main form input[type="text"],
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
                background-color: rgba(255, 255, 255, 0.1);
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
