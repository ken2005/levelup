@extends('layouts.app')
@section('page-name')
    Training
@endsection
@section("head")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <style>
    /* Importing Google Font - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    
    main * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Montserrat", sans-serif;
    }
    
    main #program-container {
      display: flex;
      align-items: center;
      justify-content: center;
      /*min-height: 100vh;*/
      background: url("images/bg.jpg")  no-repeat center;
    }
    
    main .slider-wrapper {
      overflow: hidden;
      max-width: 1200px;
      margin: 0 70px 55px;
    }
    
    main .card-list .card-item, main .button {
      height: auto;
      color: #fff;
      user-select: none;
      padding: 35px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      backdrop-filter: blur(30px);
      background: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    main .card-list .card-item .user-image {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 40px;
      border: 3px solid #fff;
      padding: 4px;
    }
    
    main .card-list .card-item .user-profession {
      font-size: 1.15rem;
      color: #e3e3e3;
      font-weight: 500;
      margin: 14px 0 40px;
    }
    
    main .card-list .card-item .message-button {
      font-size: 1.25rem;
      padding: 10px 35px;
      color: #030728;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      background: #fff;
      border: 1px solid transparent;
      transition: 0.2s ease;
    }
    
    main .card-list .card-item .message-button:hover {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid #fff;
      color: #fff;
    }
    
    main .slider-wrapper .swiper-pagination-bullet {
      background: #fff;
      height: 13px;
      width: 13px;
      opacity: 0.5;
    }
    
    main .slider-wrapper .swiper-pagination-bullet-active {
      opacity: 1;
    }
    
    main .slider-wrapper .swiper-slide-button {
      color: #fff;
      margin-top: -55px;
      transition: 0.2s ease;
    }
    
    main .slider-wrapper .swiper-slide-button:hover {
      color: #4658ff;
    }

    
    

        
    
    @media (max-width: 768px) {
        main .slider-wrapper {
        margin: 0 10px 40px;
      }
    
      main .slider-wrapper .swiper-slide-button {
        display: none;
      }
    }

    .myModal{
            position: fixed;
                width: 80%;
                margin:auto;
                height: 80%;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
                background-color: rgba(255, 255, 255, 0.1);
                color: #fff;
                transition: all 0.3s ease;
                font-family: 'Roboto', 'Arial', sans-serif;
                font-size: 14px;
                display: flex;
                flex-direction: column;
                text-align: center;
                align-content: center;
                justify-content: space-around;
                
              }
              
        .lvlup{
                
            background-image: url('https://kennan.alwaysdata.net/images/levelup_icon.png');
            background-position: center;
        }

        .pwrup{
                
                background-image: url('https://kennan.alwaysdata.net/images/powerup_icon.png');
                background-position: center;
            }

        #centerpoint {
            top: 50%;
            left: 50%;
            position: absolute;
        }

        .blur {
        -webkit-filter: blur(2px);
        -moz-filter: blur(2px);
        -o-filter: blur(2px);
        -ms-filter: blur(2px);
        filter: blur(2px);
        }

        dialog::backdrop {
        background: rgba(100,11,100,1.25);
        }
  </style>
@endsection
@section('content')
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
                                <div class="card-item swiper-slide" style="min-width:min-content;cursor: pointer; position: relative;" onclick="location.href='<?php echo route('historique',["idProg" => $programme->id]); ?>';">
                                  <a class="lien-discret" href="{{route('creerEntrainement',["idProg" => $programme->id, "nouvelExo" => -1, "exos"=> "a"])}}">
                                    <img src="https://kennan.alwaysdata.net/images/historique.png" style="width:3em;position:absolute;top:10px;right:10px;">
                                  </a>
                                    <!--
                                    <img src="images/img-1.jpg" alt="User Image" class="user-image">
                                    -->
                                    <h2 class="user-name">{{$programme->name}}</h2>
                                    <h4 style="text-align: center;">{{$programme->details}}</h4>
                                    <p class="user-profession" style="text-align:center;">
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
                                    @endphp                                    </p>
                                <!--
                                    <button class="message-button">Nouvel Entrainement</button>
                                    <br>
                                -->
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
    <div class="aaa" style="align-items:center; display:flex; flex-direction:column; width:100%">
        <a class="lien-discret" href="{{route('creerProgramme')}}">

            <span class="button" style="width:fit-content;cursor: pointer;" >
                Nouveau Programme
            </span>
        </a>
        <a class="lien-discret" href="{{route('creerExercice')}}">

            <span class="button" style="width:fit-content;cursor: pointer;" >
                Nouvel Exercice
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

@endsection