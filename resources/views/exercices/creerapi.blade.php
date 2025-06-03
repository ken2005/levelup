    @extends('layouts.app')
    @section("page-name")
        Exercise
    @endsection
    @section('content')
    <span id="creer-api">

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
        <div id="exercises-container">
        </div>
    </div>

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
    </span>
    @endsection