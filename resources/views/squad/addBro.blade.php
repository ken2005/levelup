@extends('layouts.app')
@section('content')
<span id="add-bro">

    <h1>
        Voulez vous ajouter {{$bro->name}} ?
    </h1>
    <a class="lien-discret" href="{{route('doAddBro',['idBro'=>$bro->id])}}" method="POST">
    
        <button >Ajouter</button>
    </a>
</span>
@endsection