@extends('layouts.app')
@section('page-name')
    Training
@endsection
@section("head")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

@endsection
@section('content')
<span id="entrainement-listing">

    <div id="centerpoint">
      <script>
        </script>
      @foreach ($levelUps as $levelUp)
      @if ($levelUp != "")
    <dialog  class="myModal lvlup" class="modal">
      <!--
      <img src="https://kennan.alwaysdata.net/images/levelup_icon.png">
      -->
      <h1>LevelUp</h1>
      <h2>{{$levelUp}}</h2>
      <p>Vous êtes passé au niveau superieur</p>
    
    </dialog>
    @endif
    @endforeach
    @foreach ($powerUps as $powerUp)
    @if ($powerUp != "")

    <dialog  class="myModal pwrup" class="modal">
      <!--
      <img src="https://kennan.alwaysdata.net/images/powerup_icon.png">
      -->
      <h1>PowerUp</h1>
      <h2>{{$powerUp}}</h2>
      <p>Vous vous êtes surpassé</p>
    
    </dialog>
    @endif
    @endforeach
  </div>
        <script>
                function LevelUp(){
                    for (let index = 0; index< <?php echo count($levelUps)+count($powerUps); ?> ; index++) {
                        document.getElementsByClassName('myModal')[index].showModal();
                    }
                    document.getElementsByTagName('body')[0].classList.add("blur");
                }
                const myDialog = document.getElementById('centerpoint');
                myDialog.addEventListener('click', () => {
                  document.getElementsByClassName('myModal')[document.getElementsByClassName('myModal').length-1].parentElement.removeChild(document.getElementsByClassName('myModal')[document.getElementsByClassName('myModal').length-1]);
                    document.getElementsByTagName('body')[0].classList.remove("blur")
                });
        
                const myDiv = document.getElementById('centerpoint');
                myDiv.addEventListener('click', (event) => event.stopPropagation());
        
                LevelUp();
            </script>
    <div id="program-container">
        <div class="container swiper">
            <div class="slider-wrapper">
                <div class="card-list swiper-wrapper">
                        @foreach ($programmes as $programme)
                                <div class="card-item swiper-slide" onclick="location.href='<?php echo route('historique',["idProg" => $programme->id]); ?>';">
                                  <a class="lien-discret" href="{{route('creerEntrainement',["idProg" => $programme->id, "nouvelExo" => -1, "exos"=> "a"])}}">
                                    <img src="https://kennan.alwaysdata.net/images/historique.png" class="historique-img">
                                  </a>
                                    <h2 class="user-name">{{$programme->name}}</h2>
                                    <h4 class="programme-details">{{$programme->details}}</h4>
                                    <p class="user-profession">
                                    @php
                                      $i = 0;
                                      while ($i < count($tabExos)) {
                                          if ($tabExos[$i]->idProgramme == $programme->id) {
                                              $seriesCount = 1;
                                              while ($i + 1 < count($tabExos) && 
                                                     $tabExos[$i]->name == $tabExos[$i + 1]->name && 
                                                     $tabExos[$i]->nb_reps == $tabExos[$i + 1]->nb_reps &&
                                                     $tabExos[$i]->idProgramme == $programme->id) {
                                                  $seriesCount++;
                                                  $i++;
                                              }
                                              if ($seriesCount > 1) {
                                                  echo $seriesCount . 'x';
                                              }
                                              echo $tabExos[$i]->name . ' x' . $tabExos[$i]->nb_reps . '<br>';
                                          }
                                          $i++;
                                      }
                                    @endphp    
                                    <a href="{{route('modifierProgramme',["idProg" => $programme->id, "nouvelExo" => -1, "exos"=> "a"])}}">
    
                                        <button class="message-button" >Modifier</button>
                                    </a>
                    
                                </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-slide-button swiper-button-prev"></div>
                    <div class="swiper-slide-button swiper-button-next"></div>
                </div>
            </div>
    </div>
    <div class="aaa">
        <a class="lien-discret" href="{{route('creerProgramme')}}">
            <span class="button">
                Nouveau Programme
            </span>
        </a>
        <a class="lien-discret" href="{{route('creerExercice')}}">
            <span class="button">
                Nouvel Exercice
            </span>
        </a>
    </div>    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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