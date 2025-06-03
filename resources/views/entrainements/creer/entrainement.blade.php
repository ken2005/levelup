@extends('layouts.app')
@section("page-name")
    Program
@endsection
@section('content')

<span id="creer-entrainement">
    <form id="mainForm" action="{{route('doModifierEntrainement',["idEntrainement" => $entrainement->id])}}" method="post">
        @csrf
        <h2>Composition de l'entrainement</h2>
        <label for="details">Détails :</label>
        <textarea id="details" name="details" rows="4">{{$entrainement->details}}</textarea>
                <label for="repos">Temps de repos (secondes) :</label>
                    <div class="repos-container">
                        <input type="number" id="repos" name="repos" min="0" max="300" value="60">
                        <button type="button" id="startButton">Play</button>
                        <div id="chrono">
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
                        
        <label for="series">Séries :</label>
        <div id="exercices" name="exercices" class="exercices-container">
            @foreach ($exos as $exo)
                <div class="exercice-item">
                    <div class="exercice-name">
                        {{$exo->name}}
                        <input name="exercice[]" value="{{$exo->id}}" class="hidden-input">
                    </div>
                    <input name="nb_reps[]" type="number" maxlength="2" value="{{$exo->nb_reps}}" class="reps-input"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    <div id="chrono-{{$exo->id}}" class="chrono-container">
                        <span id="minutes-{{$exo->id}}">00</span>:<span id="seconds-{{$exo->id}}">00</span>
                    </div>
                    <input id="dificulte-{{$exo->id}}" name="dificulte[]" type="number" maxlength="3" value="{{$exo->dificulte}}" placeholder="{{ $exo->methode}}" class="difficulty-input">
                    <div class="timer-container">
                        @if($exo->methode == "durée")
                        <button type="button" id="startButton-{{$exo->id}}" onclick="toggleTimer('{{$exo->id}}')" class="timer-button">▶</button>
                        <style>
                            #chrono-{{$exo->id}} {
                                display: none;
                            }
                            #dificulte-{{$exo->id}} {
                                display: block;
                            }
                        </style>
                        @endif
                    </div>
                    <button type="submit" formaction="{{ route('supprimerExoEntrainement', ['idEntrainement' => $entrainement->id, 'idSerie' => $exo->idSerie]) }}" class="delete-button">X</button>
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
                </div>
            @endforeach            
            <div class="add-exercice" onclick="choisirExo()">
                Ajouter un exercice
            </div>
        </div>

        <dialog id="exos">
            <div id="myDiv">
                @foreach ($exercices as $exercice)
                    <button type="submit" formaction="{{route('ajouterExoEntrainement', ['idEntrainement' => $entrainement->id, 'idExo' => $exercice->id])}}" class="exercice-button">
                        <span class="exercice-name">{{$exercice->name}}</span>
                    </button>
                @endforeach
                <div class="create-exercice">
                    Créer un exercice
                </div>
            </div>
        </dialog>
        <button type="submit" class="submit-button">Envoyer</button>
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
