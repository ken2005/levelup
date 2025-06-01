@extends('layouts.app')

@section('head')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: clamp(1.5rem, 4vw, 2.5rem);
        }
        .search-container {
            margin-bottom: 30px;
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        .search-container input, .search-container select {
            padding: 12px;
            margin: 0 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
        }
        .search-container input:focus, .search-container select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52,152,219,0.3);
        }
        #results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 10px;
        }
        .exercise-card {
            background: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
        }
        .exercise-card:hover {
            transform: translateY(-5px);
        }
        .exercise-card h2 {
            color: #2c3e50;
            margin-top: 0;
            font-size: clamp(1rem, 3vw, 1.2em);
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .exercise-images {
            margin-top: 10px;
            position: relative;
            padding-bottom: 100%;
        }
        .exercise-images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            position: absolute;
            top: 0;
            left: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .exercise-images img.second-image {
            opacity: 0;
        }
        .exercise-card.visible .exercise-images img.second-image {
            opacity: 1;
        }
        .exercise-info {
            font-size: clamp(0.8em, 2vw, 0.9em);
            color: #666;
            margin-top: 10px;
        }
        strong {
            color: #3498db;
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
            margin-top: 10px;
        }
        .exercise-link:hover {
            background: #0056b3;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .search-container {
                padding: 15px;
            }
            .search-container input, .search-container select {
                margin: 5px 0;
            }
            #results {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 5px;
            }
            .search-container {
                padding: 10px;
            }
            #results {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .exercise-card {
                padding: 10px;
            }
        }
    </style>
@endsection

@section('page-name')
Search
@endsection

@section('content')
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
@endsection