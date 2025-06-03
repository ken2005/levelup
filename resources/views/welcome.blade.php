@extends('layouts.app')
@section('page-name')
    Home
@endsection
@section("content")
<span id="home">
    <div class="chart-container">
        <canvas id="1" class="chart"></canvas>
        <input id="model1" value="line" style="display:none;">
    </div>

    <div class="mobile-only-button">
        <a class="lien-discret" href="{{route('training',["levelUps" => '-1',"powerUps" => '-1'])}}">
            <span class="button">
                Nouvel Entrainement
            </span>
        </a>
    </div>
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
</span>
@endsection