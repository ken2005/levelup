@extends('layouts.app')
@section('page-name')
    Home
@endsection
@section("content")
    
        <div style="max-width:80%; background-color: rgba(10,10,10,0.5); border-radius:1em; padding: 2em; resize:both; overflow:hidden; margin:auto; margin-top: 0em; margin-bottom: 0em;">

            <canvas id="1" class="chart"></canvas>
            <input id="model1" value="line" style="display:none;">
        </div>

        <div style="align-items:center; display:none; flex-direction:column; width:100%; margin-top: 2em;" class="mobile-only-button">
            <a class="lien-discret" href="{{route('training',["levelUps" => '-1',"powerUps" => '-1'])}}">
                <span class="button" style="width:fit-content;cursor: pointer;height: auto;color: #fff;user-select: none;padding: 35px;display: flex;flex-direction: column;align-items: center;justify-content: center;border-radius: 10px;backdrop-filter: blur(30px);background: rgba(255, 255, 255, 0.2);border: 1px solid rgba(255, 255, 255, 0.5); font-family: 'Montserrat', sans-serif;">
                    Nouvel Entrainement
                </span>
            </a>
        </div>

        <style>
            @media screen and (max-width: 768px) {
                .mobile-only-button {
                    display: flex !important;
                }
            }
        </style>
    <script>
            for (let currentChart of  document.getElementsByClassName('chart')) {
                let ctx = currentChart.getContext('2d');

                let data = {
                    labels: [
                        <?php
                        for($i=0; $i<= $maxSeries; $i++) {
                            echo '"'.$i.'",';
                        }
                        ?>
                    ],
                    datasets: [
                        <?php
                            foreach ($exercices as $exercice) {
                                echo '{"label": "'.$exercice->name.'",';
                                echo '"data":[0,';
                                foreach ($exercice->series as $serie) {
                                    echo $serie->dificulte.',';
                                }
                                echo ']},';
                            }
                        ?>]

                }

                let myChart = new Chart(ctx, {
                    type:  document.getElementById('model'+currentChart.id).value,
                    data: data,
                    options: {
                        plugins: {  
                            legend: {
                                labels: {
                                color: "white",  
                                font: {
                                }
                                }
                            }
                        },
                        responsive: true,
                        scale: {
                            y: {
                                beginAtZero: true
                            }
                        },
                    }
                })
            };
        </script>
    </body>
    </html>
@endsection