@extends('layouts.app')
@section('page-name')
    Training
@endsection
@section("head")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endsection
@section('content')
<span id="historique">

    <div id="centerpoint">
      <dialog class="myModal">
        Veux tu vraiment supprimer ce programme?<br>
        Tu n'auras plus accès à l'historique de ses séances.
        <a class="lien-discret" href="{{route('supprimerProgramme',["idProg" => $idProg])}}">
          <button>oui</button>
        </a>
        <button>non</button>
      </dialog>
    </div>
    <script>
                function showModal(){
                    document.getElementsByClassName('myModal')[0].showModal();
                    document.getElementsByTagName('body')[0].classList.add("blur");
                }
                const myDialog = document.getElementById('centerpoint');
                myDialog.addEventListener('click', () => {
                  document.getElementsByClassName('myModal')[0].close()
                    document.getElementsByTagName('body')[0].classList.remove("blur")
                });
        
                const myDiv = document.getElementById('centerpoint');
                myDiv.addEventListener('click', (event) => event.stopPropagation());
        
                //LevelUp();
            </script>
    <div id="program-container">
        <div class="container swiper">
            <div class="slider-wrapper">
                <div class="card-list swiper-wrapper">
                        @foreach ($entrainements as $entrainement)
                            
                                <div class="card-item swiper-slide" style="<?php if($entrainement->levelup){
                                  echo "background-image: url('https://kennan.alwaysdata.net/images/levelup_icon.png');background-position:center;background-size:cover;";
                                }
                                else if ($entrainement->powerup){
                                  echo "background-image: url('https://kennan.alwaysdata.net/images/powerup_icon.png');background-position:center;background-size:cover;";
                                }
                                ?>" onclick="window.location.href='{{ route('modifierEntrainement', ['idEntrainement' => $entrainement->id]) }}'">
                                
                                    <!--
                                    <img src="images/img-1.jpg" alt="User Image" class="user-image">
                                    -->
                                    <h2 class="user-name">{{$entrainement->created_at}}</h2>
                                    <h4>{{$entrainement->details}}</h4>
                                    @if ($entrainement->programme->id_squad != null && $entrainement->series->count() > 0)
                                    
                                    <h5>par {{$entrainement->series[0]->userName}}</h5>
                                    @endif
                                    <p class="user-profession" style="text-align:center;">
                                      
                                      @for ($i = 0; $i < count($entrainement->series); $i++)
                                      @php
                                        $seriesCount = 1;
                                        if ($i < count($entrainement->series) - 1) {
                                            while ($i + 1 < count($entrainement->series) && 
                                                   $entrainement->series[$i]->exercice->id == $entrainement->series[$i + 1]->exercice->id && 
                                                   $entrainement->series[$i]->nb_reps == $entrainement->series[$i + 1]->nb_reps && 
                                                   $entrainement->series[$i]->dificulte == $entrainement->series[$i + 1]->dificulte) {
                                                $seriesCount++;
                                                $i++;
                                            }
                                        }
                                      @endphp
                                      @if($seriesCount > 1)
                                        {{$seriesCount}}x
                                      @endif
                                      <span style="white-space: wrap;">{{ $entrainement->series[$i]->exercice->name }} x{{$entrainement->series[$i]->nb_reps}}</span> <span style="white-space: no-wrap;">{{$entrainement->series[$i]->dificulte}}
                                      @if($entrainement->series[$i]->exercice->methode == "durée")
                                        secondes
                                      @else
                                        kg
                                      @endif
                                      </span>
                                      <br>
                                      
                                      @endfor                                    </p>
                                <!--
                                    <button class="message-button">Nouvel Entrainement</button>
                                    <br>
                                    <a href="{{route('modifierProgramme',["idProg" => $entrainement->id, "nouvelExo" => -1, "exos"=> "a"])}}">
    
                                        <button class="message-button" >Modifier</button>
                                    </a>
                                -->
                    
                                </div>
                            @endforeach                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-slide-button swiper-button-prev"></div>
                    <div class="swiper-slide-button swiper-button-next"></div>
                </div>
            </div>
    </div>
    <div class="aaa">
        <a class="lien-discret" href="{{route('creerEntrainement',["idProg" => $idProg, "nouvelExo" => -1, "exos"=> "a"])}}">
            <span class="button">
                Nouvel Entrainement
            </span>
        </a>
        <a class="lien-discret">
            <span class="button" onclick="showModal()">
                Supprimer le programme
            </span>
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.slider-wrapper', {
        loop: true,
        grabCursor: true,
        spaceBetween: 30,
    
        // Pagination bullets
        pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true
        },
    
        // Navigation arrows
        navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        },
    
        // Responsive breakpoints
        breakpoints: {
        0: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        }
        }
    });
    </script>
</span>

@endsection