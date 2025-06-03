@extends('layouts.app')

@section('page-name')
Search
@endsection

@section('content')
<span id="search-exo">

    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search exercises...">
        <select id="filterCategory">
            <option value="">All Categories</option>
            <option value="strength">Strength</option>
            <option value="cardio">Cardio</option>
            <option value="stretching">Stretching</option>
        </select>
        <select id="filterMuscle">
            <option value="">All Muscles</option>
        </select>
    </div>
    <div id="results"></div>

    <script>
        let exercises = [];
        let availableMuscles = new Set();

        async function fetchExercises() {
            try {
                const response = await fetch('https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/dist/exercises.json');
                exercises = await response.json();
                
                // Collect all unique muscles from the API
                exercises.forEach(exercise => {
                    if (exercise.primaryMuscles) {
                        exercise.primaryMuscles.forEach(muscle => {
                            availableMuscles.add(muscle);
                        });
                    }
                });

                // Populate muscle filter with available muscles
                const muscleFilter = document.getElementById('filterMuscle');
                Array.from(availableMuscles).sort().forEach(muscle => {
                    const option = document.createElement('option');
                    option.value = muscle.toLowerCase();
                    option.textContent = muscle;
                    muscleFilter.appendChild(option);
                });

                displayExercises(exercises);
            } catch (error) {
                console.error('Error fetching exercises:', error);
            }
        }

        function displayExercises(exercisesToShow) {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '';

            exercisesToShow.forEach(exercise => {
                const exerciseCard = document.createElement('div');
                exerciseCard.className = 'exercise-card';

                const images = exercise.images && exercise.images.length >= 2 
                    ? `
                        <img src="https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/exercises/${exercise.images[0]}" alt="${exercise.name}" class="first-image">
                        <img src="https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/exercises/${exercise.images[1]}" alt="${exercise.name}" class="second-image">
                    `
                    : exercise.images && exercise.images.length === 1
                    ? `<img src="https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/exercises/${exercise.images[0]}" alt="${exercise.name}">`
                    : '';

                exerciseCard.innerHTML = `
                    <h2>${exercise.name}</h2>
                    <div class="exercise-images">
                        ${images}
                    </div>
                    <div class="exercise-info">
                        <p><strong>Category:</strong> ${exercise.category || 'N/A'}</p>
                        <p><strong>Level:</strong> ${exercise.level || 'N/A'}</p>
                        <p><strong>Equipment:</strong> ${exercise.equipment || 'N/A'}</p>
                        <p><strong>Muscles:</strong> ${exercise.primaryMuscles ? exercise.primaryMuscles.join(', ') : 'N/A'}</p>
                    </div>
                    <a href="exercices/creer-api/${encodeURIComponent(exercise.id)}" class="exercise-link">Ajouter</a>
                `;

                exerciseCard.addEventListener('mouseenter', () => {
                    startAnimation(exerciseCard);
                });

                exerciseCard.addEventListener('mouseleave', () => {
                    stopAnimation(exerciseCard);
                });

                resultsDiv.appendChild(exerciseCard);
            });

            if (window.matchMedia("(max-width: 768px)").matches) {
                setupIntersectionObserver();
            }
        }

        function setupIntersectionObserver() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (!entry.target.dataset.animationInterval) {
                            startAnimation(entry.target);
                        }
                    } else {
                        stopAnimation(entry.target);
                    }
                });
            }, {
                threshold: 0.5,
                root: null,
                rootMargin: '0px'
            });

            document.querySelectorAll('.exercise-card').forEach(card => {
                observer.observe(card);
            });
        }

        function startAnimation(card) {
            if (card.dataset.animationInterval) return;
            
            let isFirstImage = true;
            const toggleImages = () => {
                if (isFirstImage) {
                    card.classList.add('visible');
                } else {
                    card.classList.remove('visible');
                }
                isFirstImage = !isFirstImage;
            };

            const intervalId = setInterval(toggleImages, 500);
            card.dataset.animationInterval = intervalId;
            card.classList.add('visible');
        }

        function stopAnimation(card) {
            if (card.dataset.animationInterval) {
                clearInterval(parseInt(card.dataset.animationInterval));
                delete card.dataset.animationInterval;
                card.classList.remove('visible');
            }
        }

        function filterExercises() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('filterCategory').value.toLowerCase();
            const muscleFilter = document.getElementById('filterMuscle').value.toLowerCase();

            const filteredExercises = exercises.filter(exercise => {
                const matchesSearch = 
                    (exercise.name && exercise.name.toLowerCase().includes(searchTerm)) ||
                    (exercise.primaryMuscles && exercise.primaryMuscles.some(muscle => muscle.toLowerCase().includes(searchTerm))) ||
                    (exercise.equipment && exercise.equipment.toLowerCase().includes(searchTerm)) ||
                    (exercise.category && exercise.category.toLowerCase().includes(searchTerm));
                
                const matchesCategory = !categoryFilter || (exercise.category && exercise.category.toLowerCase() === categoryFilter);
                
                const matchesMuscle = !muscleFilter || (exercise.primaryMuscles && exercise.primaryMuscles.some(muscle => 
                    muscle.toLowerCase().includes(muscleFilter)));

                return matchesSearch && matchesCategory && matchesMuscle;
            });

            displayExercises(filteredExercises);
        }

        document.getElementById('searchInput').addEventListener('input', filterExercises);
        document.getElementById('filterCategory').addEventListener('change', filterExercises);
        document.getElementById('filterMuscle').addEventListener('change', filterExercises);

        fetchExercises();
    </script>
</span>
@endsection