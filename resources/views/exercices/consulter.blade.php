  @extends('layouts.app')
  @section('page-name')
      Exercise
  @endsection

  @section("head")
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <style>
      
  </style>
  @endsection

  @section('content')
  <span id="exercice-consulter">

  <div class="chart-container">
      <canvas id="exerciseChart" class="chart"></canvas>
    </div>

      <div class="slider-wrapper">
          <div class="card-list swiper-wrapper">
              @foreach ($series->reverse() as $serie)
                  <div class="card-item swiper-slide">
                      <h2>{{$serie->created_at}}</h2>
                      <p>
                          {{$serie->date}} <br>
                          {{$serie->nb_reps}} reps<br>
                          {{$serie->dificulte}} 
                          @if($exercice->methode == "durée")
                          secondes
                          @else
                          kg
                          @endif
                      </p>
                    </div>
              @endforeach
            </div>
            <div class="swiper-slide-button swiper-button-prev"></div>
            <div class="swiper-slide-button swiper-button-next"></div>
        </div>
        <div class="swiper-pagination"></div>
        
        <div class="exercise-details">
            <h2>{{$exercice->name}}</h2>
            <textarea readonly class="form-control" rows="3">{{$exercice->details}}</textarea>
            <p><strong>Méthode:</strong> {{$exercice->methode}}</p>
        </div>
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <script>
          // Initialize Swiper
          const swiper = new Swiper('.slider-wrapper', {
              loop: true,
              grabCursor: true,
              spaceBetween: 30,
              pagination: {
                  el: '.swiper-pagination',
                  clickable: true,
                  dynamicBullets: true
              },
              navigation: {
                  nextEl: '.swiper-button-next',
                  prevEl: '.swiper-button-prev',
              },
              breakpoints: {
                  0: { slidesPerView: 1 },
                  768: { slidesPerView: 2 },
                  1024: { slidesPerView: 3 }
              }
          });

          // Initialize Chart
          let ctx = document.getElementById('exerciseChart').getContext('2d');
          let data = {
              labels: [
                  <?php
                  foreach($series as $index => $serie) {
                      echo '"'.($index + 1).'",';
                  }
                  ?>
              ],
              datasets: [{
                  label: '<?php echo $exercice->name; ?>',
                  data: [
                      <?php
                      foreach($series as $serie) {
                          echo $serie->dificulte.',';
                      }
                      ?>
                  ],
                  borderColor: 'rgba(255, 255, 255, 0.8)',
                  borderWidth: 2,
                  fill: false
              }]
          };
          let myChart = new Chart(ctx, {
              type: 'line',
              data: data,
              options: {
                  plugins: {
                      legend: {
                          labels: {
                              color: "white",
                              font: { size: 14 }
                          }
                      }
                  },
                  responsive: true,
                  scales: {
                      y: {
                          beginAtZero: true,
                          ticks: { color: "white" }
                      },
                      x: {
                          ticks: { color: "white" }
                      }
                  }
              }
          });
      </script>
  </span>
  @endsection