  @extends('layouts.app')
  @section('page-name')
    Exercise
@endsection

  @section('content')
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
      <div class="cardlist" style=" margin: 1em 0;">
          <h1>{{ __('Exercices') }}</h1>
          <div style="padding: 0.5em;max-height: 80%; overflow-y: auto;scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE 10+ */

  &::-webkit-scrollbar {
    background: transparent; /* Chrome/Safari/Webkit */
    width: 0px;
  }">
              @foreach($exercices as $exercice)
              <a href="{{ route('consulterExercice', ['id' => $exercice->id]) }}" style="text-decoration: none; color: inherit;">
                  <div class="listItem" style="display: flex; align-items: center; transition: transform 0.2s; width: 90%;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                      <div style="flex: 1; width: 60%; overflow: hidden;">
                          <span style="font-size: 1.1em; font-weight: bold; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;max-width: 53vw;">{{ $exercice->name }}</span>
                          <div style="font-size: 0.9em; color: #ccc; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $exercice->methode }}</div>
                          <div style="font-size: 0.9em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;max-width: 53vw;">{{ $exercice->details }}</div>
                      </div>
                      <div class="listItemButtons" style="width: 2em;">
                          <a class="lien-discret" href="{{ route('modifierExercice', $exercice->id) }}">
                              <button style="background-color: #2196F3; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Edit</button>
                          </a>
                          <form action="{{ route('supprimerExercice', $exercice->id) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" style="background-color: #f44336; border: none; border-radius: 8px; color: white; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">X</button>
                          </form>
                      </div>
                  </div>
                </a>
              @endforeach
          </div>
          <div style="display: flex; justify-content: center; margin-top: 1em; flex-wrap: wrap;">
            <a class="lien-discret" href="{{ route('creerExercice') }}" style="display: block; padding: 0.8em;">
                <button style="background-color: #4CAF50; border: none; border-radius: 8px; color: white; transition: all 0.3s; font-size: 1em;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">+ Exercice</button>
            </a>
                <a class="lien-discret" href="{{ route('searchexo') }}" style="display: block; padding: 0.8em;">
                            <button style="background-color: #FF9800; border: none; border-radius: 8px; color: white; transition: all 0.3s; font-size: 1em;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Rechercher Exercice</button>
                </a>
        </div>
          
      </div>
  </div>

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

          .cardlist {
              padding: 0.5em;
              margin: 0.5em 0 !important;
          }
      }

      .listItemButtons{
          display: flex;
          justify-content: flex-end;
          align-items: center;
          gap: 10px;
          width: auto;
          flex-shrink: 0;
      }
    
      .cardlist{
          display: flex;
          flex-direction: column;
          background-color: rgba(10,10,10,0.7);
          border-radius: 15px;
          align-content: center;
          color: white;
          margin: 1em 0;
          overflow: auto;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
          display:flex; flex-direction:row; align-items: center;
          gap: 10px; background: rgba(255,255,255,0.1);
          padding: 10px;
          border-radius: 10px;
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

      .cardlist {
        max-height: 80vh;
        overflow-y: auto;
    }
  </style>
  @endsection