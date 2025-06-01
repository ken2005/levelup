  @extends('layouts.app')

  @section('page-name')
  Muscles
  @endsection

  @section('content')
  <div style="display: flex; flex-direction: column; align-items: center; gap: 20px; padding: 20px;">
      @php
          $muscles = [
              ['name' => 'pectorals', 'french' => 'Pectoraux'],
              ['name' => 'abs', 'french' => 'Abdominaux'],
              ['name' => 'biceps', 'french' => 'Biceps'],
              ['name' => 'triceps', 'french' => 'Triceps'],
              ['name' => 'delts', 'french' => 'Épaules'],
              ['name' => 'quads', 'french' => 'Quadriceps'],
              ['name' => 'lats', 'french' => 'Dorsaux'],
              ['name' => 'glutes', 'french' => 'Fessiers'],
              ['name' => 'hamstrings', 'french' => 'Ischio-jambiers'],
              ['name' => 'calves', 'french' => 'Mollets'],
              ['name' => 'traps', 'french' => 'Trapèzes'],
              ['name' => 'upper back', 'french' => 'Haut du dos'],
              ['name' => 'forearms', 'french' => 'Avant-bras'],
              ['name' => 'abductors', 'french' => 'Abducteurs'],
              ['name' => 'adductors', 'french' => 'Adducteurs'],
              ['name' => 'serratus anterior', 'french' => 'Grand dentelé'],
              ['name' => 'levator scapulae', 'french' => 'Élévateur de la scapula'],
              ['name' => 'spine', 'french' => 'Colonne vertébrale'],
              ['name' => 'cardiovascular system', 'french' => 'Système cardiovasculaire']
          ];
      @endphp
    
      @foreach($muscles as $muscle)
          <a href="{{ route('exercices.list', ['muscle' => $muscle['name']]) }}" class="muscle-button">{{ $muscle['french'] }}</a>
      @endforeach
  </div>

  <style>
  .muscle-button {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 15px 30px;
      border-radius: 10px;
      text-decoration: none;
      color: black;
      font-size: 1.2em;
      font-weight: bold;
      width: 80%;
      max-width: 300px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s, background-color 0.2s;
  }

  .muscle-button:hover {
      transform: translateY(-2px);
      background-color: rgba(255, 255, 255, 1);
  }

  .muscle-button:active {
      transform: translateY(0);
  }
  </style>
  @endsection