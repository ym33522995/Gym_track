<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/template">Template</a></li>
                <li><a href="/exercise">Exercise</a></li>
                <li><a href="/report">Report</a></li>
                <li><a href="/profile">Profile</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main>
        <h2>Exercise Page</h2>
        <label for="searchExercise">Search Exercise:</label>
        <input type="text" id="searchExercise" placeholder="Enter exercise name" oninput="searchExercises()">
        <br><br>

        <h3>Filter by Category</h3>
        <button onclick="filterByCategory('Chest')">Chest</button>
        <button onclick="filterByCategory('Back')">Back</button>
        <button onclick="filterByCategory('Leg')">Leg</button>
        <button onclick="filterByCategory('Shoulder')">Shoulder</button>
        <button onclick="filterByCategory('Biceps')">Biceps</button>
        <button onclick="filterByCategory('Triceps')">Triceps</button>
        <button onclick="filterByCategory('Abs')">Abs</button>
        <button onclick="filterByCategory('Forearm')">Forearm</button>
        <button onclick="filterByCategory('Full body')">Full body</button>

        <p>These are the exercises:</p>
        <div id="exerciseList">
            @foreach($exercises as $exercise)
                <div class="exercise-item" data-category="{{ $exercise->category->name }}">{{ $exercise->name }}</div>
            @endforeach
        </div>

        <div id="noExerciseMessage" style="display: none; color: red;">No exercise.</div>
    </main>

    <script>
        function searchExercises() {
            const searchInput = document.getElementById('searchExercise').value.toLowerCase();
            const exercises = document.querySelectorAll('.exercise-item');
            let hasMatch = false;

            exercises.forEach(exercise => {
                const exerciseName = exercise.textContent.toLowerCase();
                if (exerciseName.includes(searchInput)) {
                    exercise.style.display = 'block';
                    hasMatch = true;
                } else {
                    exercise.style.display = 'none';
                }
            });

            document.getElementById('noExerciseMessage').style.display = hasMatch ? 'none' : 'block';
        }


        function filterByCategory(selectedCategory) {
            const exercises = document.querySelectorAll('.exercise-item');
            let exists = false;

            exercises.forEach(exercise => {
                const itemCategory = exercise.getAttribute('data-category');
                if (selectedCategory === 'All' || itemCategory === selectedCategory) {
                    exercise.style.display = 'block';
                    exists = true;
                } else {
                    exercise.style.display = 'none';
                }
            });

            document.getElementById('noExerciseMessage').style.display = exists ? 'none' : 'block';
        }
    </script>
</body>
</html>
