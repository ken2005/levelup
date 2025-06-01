  @extends('layouts.app')
  @section('page-name')
      Exercise
  @endsection

  @section("head")
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <style>
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    
      main * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: "Montserrat", sans-serif;
      }

      .chart-container {
          max-width: 90%;
          background-color: rgba(10,10,10,0.5);
          border-radius: 1em;
          padding: 2em;
          margin: 20px auto;
      }

      .slider-wrapper {
          overflow: hidden;
          max-width: 1200px;
          margin: 0 70px 20px;
      }

      .card-list .card-item {
          height: auto;
          color: #fff;
          padding: 35px;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          border-radius: 10px;
          backdrop-filter: blur(30px);
          background: rgba(255, 255, 255, 0.2);
          border: 1px solid rgba(255, 255, 255, 0.5);
      }

      .swiper-pagination {
          position: relative;
          bottom: 10px;
          left: 50%;
          transform: translateX(-50%);
          z-index: 10;
      }

      .swiper-pagination-bullet {
          background: #fff;
          height: 13px;
          width: 13px;
          opacity: 0.5;
      }

      .swiper-pagination-bullet-active {
          opacity: 1;
      }

      .exercise-details {
          max-width: 90%;
          margin: 20px auto;
          padding: 20px;
          background-color: rgba(10,10,10,0.5);
          border-radius: 1em;
          color: white;
      }

      .exercise-details h2 {
          margin-bottom: 15px;
      }

      .exercise-details p {
          margin: 10px 0;
      }

      .exercise-details textarea {
          width: 100%;
          height: 10em;
          background-color: rgba(255, 255, 255, 0.1);
          border: 1px solid rgba(255, 255, 255, 0.3);
          color: white;
          border-radius: 8px;
          padding: 12px;
          font-size: 14px;
          resize: none;
          margin: 10px 0;
      }

      .exercise-details textarea:focus {
          outline: none;
          border-color: rgba(255, 255, 255, 0.5);
          box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
      }

      @media (max-width: 768px) {
          .slider-wrapper {
              margin: 0 10px 40px;
          }
          .swiper-slide-button {
              display: none;
          }
      }
  </style>
  @endsection

  @section('content')
  
  <div class="chart-container">
      <canvas id="exerciseChart" class="chart"></canvas>
          <input id="model1" value="line" style="display:none;">
      </div>

      <div class="slider-wrapper">
          <div class="card-list swiper-wrapper">
              @foreach ($series as $serie)
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
  @endsection