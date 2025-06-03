@extends('layouts.app')
@section("page-name")
    Squad
@endsection
@section('content')
<span id="modifier-squad">
    <form action="{{route('doSetSquad',['idSquad' => $squad->id])}}" method="post" >
        @csrf
        <h2>Modifier la Squad</h2>
        <label for="name" >Nom la Squad :</label>
        <input required type="text" id="name" name="name" value="{{$squad->name}}">
        
        <div id="gymbros" name="gymbros">
            <!-- Contenu de la div ici -->
            <?php $indices = [];?>
            
            @foreach (explode(" ENREGISTREMENT ",$bros) as $bro)
                @if ($bro!="" )
                    <div>
                    <?php
                        $a = explode(" CHAMP ",$bro); 
                        if ( count($a)==3 ) {
                    ?>
                            <div>
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
            
            <div onclick="choisirExo()">
                Ajouter un gymbro
            </div>
        </div>
        <dialog id="exos" >
            <div id="myDiv">
                @foreach ($gymbros as $gymbro)
                    <a class="lien-discret" href="<?php echo route('setSquad',['idSquad'=> $squad->id, 'nouveauBro' => $gymbro->id,'bros' => implode(",", $indices )]) ;?>">
                        <span>
                            {{$gymbro->name}}
                        </span>
                    </a>
                @endforeach
            </div>
        </dialog>
        <button type="submit" >Envoyer</button>
    </form>
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
</span>
@endsection