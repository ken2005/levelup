  @extends('layouts.app')
  @section('page-name')
    Exercise
@endsection

  @section('content')
  <span id="exercices">

      <div class="container">
          <div class="cardlist">
              <h1>{{ __('Exercices') }}</h1>
              <div class="scrollable-content">
                  @foreach($exercices as $exercice)
                  <a href="{{ route('consulterExercice', ['id' => $exercice->id]) }}" class="exercise-link">
                      <div class="listItem" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                          <div class="exercise-content">
                              <span class="exercise-name">{{ $exercice->name }}</span>
                              <div class="exercise-method">{{ $exercice->methode }}</div>
                              <div class="exercise-details">{{ $exercice->details }}</div>
                          </div>
                          <div class="listItemButtons">
                              <a class="lien-discret" href="{{ route('modifierExercice', $exercice->id) }}">
                                  <button class="edit-button" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Edit</button>
                              </a>
                              <form action="{{ route('supprimerExercice', $exercice->id) }}" method="POST" class="inline-form">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="delete-button" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">X</button>
                              </form>
                          </div>
                      </div>
                    </a>
                  @endforeach
              </div>
              <div class="button-container">
                <a class="lien-discret" href="{{ route('creerExercice') }}">
                    <button class="add-button" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">+ Exercice</button>
                </a>
                <a class="lien-discret" href="{{ route('searchexo') }}">
                    <button class="search-button" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Rechercher Exercice</button>
                </a>
            </div>
          </div>
      </div>
  </span>

  @endsection