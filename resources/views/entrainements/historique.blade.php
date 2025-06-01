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
                /*
                display: flex;
                */
                flex-direction: column;
                text-align: center;
                align-content: center;
                justify-content: space-around;
                
              }
             .myModal button {
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
        .blur {
        -webkit-filter: blur(2px);
        -moz-filter: blur(2px);
        -o-filter: blur(2px);
        -ms-filter: blur(2px);
        filter: blur(2px);
        }

        dialog::backdrop {
        background: rgba(100,11,100,.25);
        }
  </style>
@endsection
@section('content')
    <div id="centerpoint" style="position:absolute;top: 50%;left:50%;">

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
                            
                                <div class="card-item swiper-slide" style="min-width:min-content;cursor: pointer;
                                <?php if($entrainement->levelup){
                                  
                                  echo "background-image: url('https://kennan.alwaysdata.net/images/levelup_icon.png');background-position:center;background-size:cover;";
                                }
                                else if ($entrainement->powerup){
                                  echo "background-image: url('https://kennan.alwaysdata.net/images/powerup_icon.png');background-position:center;background-size:cover;";
                                }
                                ?>
                                " onclick="window.location.href='{{ route('modifierEntrainement', ['idEntrainement' => $entrainement->id]) }}'">
                                
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
    <div class="aaa" style="align-items:center; display:flex; flex-direction:column; width:100%">
        
        <a class="lien-discret" href="{{route('creerEntrainement',["idProg" => $idProg, "nouvelExo" => -1, "exos"=> "a"])}}">

            <span class="button" style="width:fit-content;cursor: pointer;" >
                Nouvel Entrainement
            </span>
        </a>
        <a class="lien-discret" >

            <span class="button" style="width:fit-content;cursor: pointer;" onclick="showModal()" >
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

@endsection