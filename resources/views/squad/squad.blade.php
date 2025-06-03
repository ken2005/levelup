@extends('layouts.app')
@section('page-name')
squad
@endsection
@section('content')
<span id="squad">
<div id="squad-container">
    <div class="cardlist">
        <h2>Lien d'invitation</h2>
        <div id="lienInvit">
            <span id="shareLink">{{route('addBro',['idBro' => Auth::user()->id])}}</span>
            <div id="share">
            </div>
        </div>

        <div style="display:none;">
            <textarea id="textbox">{{route('addBro',['idBro' => Auth::user()->id])}}</textarea>
            <span id="clipboard">NA</span>
        </div>
        
        <script>
        function copyText() {
            var Text = document.getElementById("textbox");
            Text.select();
            navigator.clipboard.writeText(Text.value);
            document.getElementById("clipboard").innerHTML = Text.value;
        }
        </script>
    </div>

    <div id="demandes" class="cardlist">
        <h1>Demandes</h1>
        <div>
            @foreach ($demandes as $demande)
                <div class="listItem">
                    <span>{{$demande->name}}</span>
                    <div class="listItemButtons">
                        <a class="lien-discret" href="{{route('acceptBro',['idBro'=>$demande->userId])}}">
                            <button class="accept-button">OK</button>
                        </a>
                        <a class="lien-discret" href="{{route('refuseBro',['idBro'=>$demande->userId])}}">
                            <button class="refuse-button">X</button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="gymbros" class="cardlist">
        <h1>GymBros</h1>
        <div>
            @foreach ($gymbros as $gymbro)
                <div class="listItem">
                    <span>{{$gymbro->name}}</span>
                    <a class="lien-discret" href="{{route('deleteGymbro',['idGymbro'=>$gymbro->id])}}">
                        <button class="refuse-button">X</button>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div id="gymsquads" class="cardlist">
        <h1>GymSquads</h1>
        <div>
            @foreach ($squads as $squad)
                <div class="listItem owned">
                    <span>{{$squad->name}}</span>
                    <div class="listItemButtons">
                        <a class="lien-discret" href="{{route('setSquad',['idSquad'=>$squad->id,'nouveauBro' => -1, 'bros' => "a"])}}">
                            <button class="edit-button">Edit</button>
                        </a>
                        <a class="lien-discret" href="{{route('deleteSquad',['idSquad'=>$squad->id])}}">
                            <button class="refuse-button">X</button>
                        </a>
                    </div>
                </div>
            @endforeach
            @foreach ($squads2 as $squad)
                <div class="listItem">
                    <span>{{$squad->name}}</span>
                    <div class="listItemButtons">
                        <a class="lien-discret" href="{{route('leaveSquad',['idSquad'=>$squad->id])}}">
                            <button class="refuse-button">X</button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="lien-discret create-squad" href="{{route('createSquad')}}">
            <button class="create-button">+ Squad</button>
        </a>
    </div>
</div>
<p class="result" hidden></p>
<script src="{{ asset('js/share.js') }}"></script>
</span>
@endsection