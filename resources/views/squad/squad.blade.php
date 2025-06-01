@extends('layouts.app')
@section('page-name')
squad
@endsection
@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="cardlist" style="height:fit-content; padding:1em;">
        <h2 style="margin-bottom: 15px; font-size: 1.5em;">Lien d'invitation</h2>
        <div id="lienInvit" style="display:flex; flex-direction:row; align-items: center; justify-content: center; gap: 10px; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 10px;">
            <span id="shareLink" style="flex: 1; word-break: break-all; font-size: 1em;">{{route('addBro',['idBro' => Auth::user()->id])}}</span>
            <div id="share" style="cursor:pointer; background-image:url('https://pngimg.com/d/share_PNG36.png'); background-repeat:no-repeat; background-size:100%; width:2em; aspect-ratio: 1/1; background-color:rgba(54, 34, 34,0.0); background-position:center; border-radius: 5px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
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

    <div id="demandes" class="cardlist" style="max-height:none; margin: 1em 0;">
        <h1>Demandes</h1>
        <div style="padding: 0.5em;">
            @foreach ($demandes as $demande)
                <div class="listItem" style="display: flex; align-items: center; transition: transform 0.2s; width: 100%;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <span style="font-size: 1em; min-width: 0; flex: 1;">{{$demande->name}}</span>
                    <div class="listItemButtons">
                        <a class="lien-discret" href="{{route('acceptBro',['idBro'=>$demande->userId])}}">
                            <button style="background-color: #4CAF50; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">OK</button>
                        </a>
                        <a class="lien-discret" href="{{route('refuseBro',['idBro'=>$demande->userId])}}">
                            <button style="background-color: #f44336; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">X</button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="gymbros" class="cardlist" style="max-height:none; margin: 1em 0;">
        <h1>GymBros</h1>
        <div style="padding: 0.5em;">
            @foreach ($gymbros as $gymbro)
                <div class="listItem" style="display: flex; align-items: center; transition: transform 0.2s; width: 90%;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <span style="font-size: 1em; min-width: 0; flex: 1;">{{$gymbro->name}}</span>
                    <a class="lien-discret" href="{{route('deleteGymbro',['idGymbro'=>$gymbro->id])}}">
                        <button style="background-color: #f44336; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">X</button>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div id="gymsquads" class="cardlist" style="margin: 1em 0;">
        <h1>GymSquads</h1>
        <div style="padding: 0.5em;">
            @foreach ($squads as $squad)
                <div class="listItem owned" style="display: flex; align-items: center; transition: transform 0.2s; width: 90%;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <span style="font-size: 1em; min-width: 0; flex: 1;">{{$squad->name}}</span>
                    <div class="listItemButtons">
                        <a class="lien-discret" href="{{route('setSquad',['idSquad'=>$squad->id,'nouveauBro' => -1, 'bros' => "a"])}}">
                            <button style="background-color: #2196F3; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Edit</button>
                        </a>
                        <a class="lien-discret" href="{{route('deleteSquad',['idSquad'=>$squad->id])}}">
                            <button style="background-color: #f44336; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">X</button>
                        </a>
                    </div>
                </div>
            @endforeach
            @foreach ($squads2 as $squad)
                <div class="listItem" style="display: flex; align-items: center; transition: transform 0.2s; width: 90%;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <span style="font-size: 1em; min-width: 0; flex: 1;">{{$squad->name}}</span>
                    <div class="listItemButtons">
                        <a class="lien-discret" href="{{route('leaveSquad',['idSquad'=>$squad->id])}}">
                            <button style="background-color: #f44336; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">X</button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="lien-discret" href="{{route('createSquad')}}" style="display: block; padding: 0.8em;">
            <button style="background-color: #4CAF50; border: none; border-radius: 8px; color: white; transition: all 0.3s; font-size: 1em;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">+ Squad</button>
        </a>
    </div>
</div>
<p class="result" hidden></p>

<style>
    @media screen and (max-width: 768px) {
        .listItem {
            flex-direction: row;
            gap: 10px;
            text-align: left;
            padding: 0.8em;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            width: 100%;
        }

        .listItemButtons {
            width: auto;
            justify-content: flex-end;
            flex-shrink: 0;
        }

        button {
            padding: 0.4em 0.8em;
            font-size: 0.8em;
            white-space: nowrap;
        }

        h1 {
            font-size: 1.2em !important;
            margin: 0.5em 0 !important;
        }

        h2 {
            font-size: 1.2em !important;
        }

        .cardlist {
            padding: 0.5em;
            margin: 0.5em 0 !important;
        }

        .scrollable {
            max-height: 150px;
        }
    }

    .listItemButtons{
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        width: auto;
    }

    
    .cardlist{
        display: flex;
        flex-direction: column;
        background-color: rgba(10,10,10,0.7);
        border-radius: 15px;
        align-content: center;
        color: white;
        margin: 1em 0;
        max-height: 400px;
        overflow: auto;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .scrollable{
        overflow: auto;
        max-height: 250px;
    }
    
    .cardlist h1 {
        text-align: center;
        font-size: 1.5em;
        margin: 0.5em 0;
    }
    
    .listItem{
        background-color: rgba(30,30,30,0.6);
        width: 100%;
        margin: 1% auto;
        border-radius: 12px;
        padding: 0.8em;
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
        display:flex; flex-direction:row; align-items: center; justify-content: center; gap: 10px; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 10px;
    }
    
    .owned{
        background-color: rgba(80,80,80,0.6);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .listItem:hover {
        border-color: rgba(255,255,255,0.3);
    }

    button{
        padding: 0.6em 1em;
        margin: 0;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.9em;
        font-weight: 600;
        transition: all 0.3s ease;
        font-family: 'Segoe UI', 'Tahoma', sans-serif;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    .scrollable::-webkit-scrollbar {
        width: 6px;
    }

    .scrollable::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
        border-radius: 4px;
    }

    .scrollable::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 4px;
    }

    .scrollable::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.4);
    }
</style>
<script src="{{ asset('js/share.js') }}"></script>
@endsection