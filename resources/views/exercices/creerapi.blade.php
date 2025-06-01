    @extends('layouts.app')
    @section("page-name")
        Exercise
    @endsection
    @section('content')
    <form action="{{route('doCreerExercice')}}" method="post" id="exerciceForm">
        @csrf
        <h2 style="text-align: center;">Créer un Exercice</h2>
        <label for="name">Nom de l'Exercice :</label>
        <input required type="text" id="name" name="name" >
        <label for="statut">Statut :</label>
        <select name="statut" id="statut">
            <option value="prive">Prive</option>
            <option value="public">Public</option>
        </select>
        
        <label for="details">Détails :</label>
        <textarea id="details" name="details" rows="4"></textarea>
        
        <label for="methode">Méthode d'évolution :</label>
        <select name="methode" id="methode">
            <option value="poids">Poids</option>
            <option value="durée">Durée</option>
            <option value="reps">Reps</option>
        </select>

        <button type="submit">Envoyer</button>
    </form>

    <div style="padding: 20px;">
        <div id="exercises-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        </div>
    </div>

    <style>
        main form input[type="number"] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
        main form input[type="number"]::-webkit-inner-spin-button, 
        main form input[type="number"]::-webkit-outer-spin-button,
        main form input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0; 
        }

        main form {
            width: 80%;
            max-width: 500px;
            margin: 0 auto;
            background-color: rgba(10, 10, 10, 0.7);
            border-radius: 1em;
            padding: 2em;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }

        main form h2 {
            text-align: center;
            margin-bottom: 1.5em;
            color: #fff;
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-weight: 600;
        }

        main form label {
            display: block;
            margin-top: 1em;
            font-weight: bold;
            font-family: 'Verdana', 'Geneva', sans-serif;
        }

        main form input,select,
        main form textarea {
            width: 100%;
            padding: 0.7em;
            margin-top: 0.5em;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s ease;
            font-family: 'Roboto', 'Arial', sans-serif;
            font-size: 14px;
        }

        main form input:focus,select:focus,
        main form textarea:focus {
            outline: none;
            border-color: #fff;
            box-shadow: 0 0 5px rgba(100, 0, 0, 0.5);
        }

        main form button[type="submit"] {
            display: block;
            width: 100%;
            padding: 0.8em;
            margin-top: 1.5em;
            background-color: #fff;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
            font-family: 'Segoe UI', 'Tahoma', sans-serif;
        }

        main form button[type="submit"]:hover {
            background-color: #f00;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
            background-repeat: no-repeat;
            background-position-x: 98%;
            background-position-y: 50%;
            padding-right: 2em;
        }

        select option {
            background-color: rgba(10, 10, 10, 0.9);
            color: #fff;
            padding: 0.5em;
        }

        select option:hover,
        select option:focus,
        select option:active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .exercise-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            cursor: pointer;
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/dist/exercises.json')
                .then(response => response.json())
                .then(exercises => {
                    const exercise = exercises.find(e => e.id === '<?php echo $exo; ?>');
                    if (exercise) {
                        const nameInput = document.querySelector('input[name="name"]');
                        if (nameInput) nameInput.value = exercise.name;

                        const detailsInput = document.querySelector('textarea[name="details"]');
                        if (detailsInput) {
                            let description = `Nom de l'exercice: ${exercise.name}\n`;
                            description += `Catégorie: ${exercise.category || 'N/A'}\n`;
                            description += `Niveau: ${exercise.level || 'N/A'}\n`;
                            description += `Équipement: ${exercise.equipment || 'N/A'}\n`;
                            description += `Muscles principaux: ${exercise.primaryMuscles ? exercise.primaryMuscles.join(', ') : 'N/A'}\n`;
                            description += `Muscles secondaires: ${exercise.secondaryMuscles ? exercise.secondaryMuscles.join(', ') : 'N/A'}\n\n`;
                            description += `Instructions:\n${exercise.instructions ? exercise.instructions.join('\n') : 'N/A'}`;
                            detailsInput.value = description;
                        }
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des données:', error));
        });
    </script>
    @endsection