  @extends('layouts.app')

  @section('page-name')
  Ajouter
  @endsection

  @section('content')
  <div style="padding: 20px;">
      <div id="exercises-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
      </div>
  </div>

  <style>
      .exercise-card {
          background: rgba(255, 255, 255, 0.9);
          border-radius: 10px;
          padding: 20px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          transition: transform 0.2s;
          max-width: 70vw;
      }

      .exercise-card:hover {
          transform: translateY(-5px);
      }

      .exercise-title {
          font-size: 1.2em;
          font-weight: bold;
          margin-bottom: 10px;
          color: #333;
      }

      .exercise-muscle {
          color: #666;
          margin-bottom: 15px;
      }

      .exercise-link {
          display: inline-block;
          background: #007bff;
          color: white;
          padding: 8px 15px;
          border-radius: 5px;
          text-decoration: none;
          transition: background 0.2s;
          margin-right: 10px;
      }

      .exercise-link:hover {
          background: #0056b3;
      }

      .info-link {
          display: inline-block;
          background: #28a745;
          color: white;
          padding: 8px 15px;
          border-radius: 5px;
          text-decoration: none;
          transition: background 0.2s;
      }

      .info-link:hover {
          background: #218838;
      }
  </style>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          fetch(`https://exercisedb-api.vercel.app/api/v1/muscles/${encodeURIComponent('<?php echo $muscle; ?>')}/exercises`)
              .then(response => response.json())
              .then(data => {
                  const container = document.getElementById('exercises-container');
                  data.data.exercises.forEach(exercise => {
                      const card = document.createElement('div');
                      card.className = 'exercise-card';
                      card.innerHTML = `
                          <div class="exercise-title">${exercise.name}</div>
                          <div class="exercise-muscle">${exercise.targetMuscles.join(', ')}</div>
                          <a href="../creer-api/${encodeURIComponent(exercise.exerciseId)}" class="exercise-link">Ajouter</a>
                      `;
                      container.appendChild(card);
                  });
              })
              .catch(error => console.error('Error:', error));
      });
  </script>
  @endsection