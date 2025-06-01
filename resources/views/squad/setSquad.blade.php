@extends('layouts.app')
@section("page-name")
    Squad
@endsection
@section('content')
<form action="{{route('doSetSquad',['idSquad' => $squad->id])}}" method="post" >
        @csrf
        <h2 style="text-align: center;">Modifier la Squad</h2>
        <label for="name" >Nom la Squad :</label>
        <input required type="text" id="name" name="name" value="{{$squad->name}}">
        
        <div id="gymbros" name="gymbros" style="width: 100%; min-height:10em; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
            <!-- Contenu de la div ici -->
            <?php $indices = [];?>
            
            @foreach (explode(" ENREGISTREMENT ",$bros) as $bro)
                @if ($bro!="" )
                    <div style="display:flex; justify-content:space-between; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    <?php
                        $a = explode(" CHAMP ",$bro); 
                        if ( count($a)==3 ) {
                    ?>
                            <div style=" width:100%; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                            <?php echo $a[1]; ?>
                            <input name="gymbro[]" value="<?php echo $a[2]; ?>" style="display:none;">
                            </div>
                            <?php array_push($indices,$a[0]);
                            }
                            ?>
                    </div>
                    
                @endif

            @endforeach
            <?php
                if (count($indices)==0){
                    $indices = ["a"];
                }
                else{
                    //dd($indices);

                }
            ?>
            
            <div onclick="choisirExo()" style=" padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #000; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                Ajouter un gymbro
            </div>
        </div>

        
        @if($bros == "")
            <!--{{$bros = "-1"}}-->
        @endif
        
        <dialog id="exos" >
            <div id="myDiv">
                @foreach ($gymbros as $gymbro)
                    <a class="lien-discret" href="<?php echo route('setSquad',['idSquad'=> $squad->id, 'nouveauBro' => $gymbro->id,'bros' => implode(",", $indices )]) ;?>">
                        <span style="display:block; padding: 0.7em; margin-top: 0.5em; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                            
                            {{$gymbro->name}}
                        </span>
                    </a>
                @endforeach
                <!--
                <div  style=" padding: 0.7em; margin-top: 0.5em; border: 1px solid #a5a; border-radius: 4px; box-sizing: border-box; background-color: rgba(255, 255, 255, 0.1); color: #fff; transition: all 0.3s ease; font-family: 'Roboto', 'Arial', sans-serif; font-size: 14px;">
                    Créer un gymbro
                </div>
            -->
            </div>
        </dialog>

        <!--
        <label for="nb_series" >Nombre de séries :</label>
        <input required type="number" id="nb_series" nb_series="nb_series" value="4" >
-->
        <button type="submit" >Envoyer</button>
    </form>

    <style>
        main form input[type="number"] {
            -moz-appearance: textfield;
        }
        main form input[type="number"]::-webkit-inner-spin-button, 
        main form input[type="number"]::-webkit-outer-spin-button,
        main form input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0; 
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
    
        main form input,select,
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
    
        main form input:focus,select:focus,
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

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
            background-repeat: no-repeat;
            background-position-x: 98%;
            background-position-y: 50%;
            padding-right: 2em;
        }

        select option {
            background-color: rgba(10, 10, 10, 0.9);
            color: #fff;
            padding: 0.5em;
        }

        select option:hover,
        select option:focus,
        select option:active {
            background-color: rgba(255, 255, 255, 0.1);
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
