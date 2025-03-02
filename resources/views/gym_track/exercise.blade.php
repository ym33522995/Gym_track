<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
    <style>
        /* ====== Global Styles ====== */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #FFFFFF;
            color: #000000;
        }

        header {
            background-color: #52057B;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 20px;
            color: #FFFFFF;
        }

        /* Style navigation links */
        header nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            font-weight: bold;
        }

        header nav ul li a {
            text-decoration: none;
            color: #FFFFFF;
        }

        header nav ul li a:hover {
            text-decoration: underline;
        }

        .app-logo {
            height: 80%; /* Scale dynamically based on the header height */
            max-height: 50px; /* Prevent it from becoming too large */
            width: auto; /* Maintain aspect ratio */
            margin-right: 10px;
        }

        /* ====== Page Titles & Text ====== */
        h2 {
            text-align: left;
            margin-top: 20px;
        }

        p {
            text-align: left;
            font-size: 18px;
            color: #000000;
        }

        .search-filter-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-filter-container input {
            padding: 8px;
            width: 250px;
            font-size: 14px;
            border: 2px solid #892CDC;
            border-radius: 5px;
        }

        /* Filter Buttons */
        .filter-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .filter-buttons button {
            background-color: #52057B;
            color: #FFFFFF;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s ease;
            align-items: center;
        }

        .filter-buttons button:hover {
            background-color: #892CDC;
            color: #000000;
            transform: scale(1.05);
        }

        .reset-button {
            background-color: black !important;
        }

        .reset-button:hover {
            color: #FFFFFF !important;
        }

        /* Exercise Grid */
        .exercise-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-content: center;
            max-width: 1000px;
            margin: auto;
        }

        /* Individual Exercise Box */
        .exercise-box {
            background-color: #FFFFFF;
            color: #000000;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            border: 2px solid #52057B;
        }

        .exercise-box:hover {
            transform: scale(1.05);
            background-color: #892CDC;
            color: #FFFFFF;
        }

        /* No Exercise Message */
        #noExerciseMessage {
            text-align: center;
            color: red;
            font-size: 16px;
            display: none;
            margin-top: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                background-color: #52057B;
                width: 100vw;        /* Fill entire browser width */
                max-width: 100%;     /* Prevent accidental overflow */
                height: 60px;
                box-sizing: border-box;  /* Let padding be part of total width */
                display: flex;
                align-items: center;
                justify-content: flex-start;
                padding: 0 5px;
                color: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 16px;
            }


            header nav ul {
                display: flex;
                flex-wrap: nowrap;   
                gap: 9px;
            }

            header nav ul li a {
                font-size: 12px;
            }

            .search-filter-container {
                width: 90%;
            }
            .exercise-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-buttons {
                justify-content: center; 
                text-align: center;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                padding: 10px;
            }
        }

        @media (max-width: 500px) {
            .exercise-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <a href="/">
            <img src="{{ asset('app_logoT.png') }}" alt="App Logo" class="app-logo">
        </a>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/template">Template</a></li>
                <li><a href="/exercise">Exercise</a></li>
                <li><a href="/report">Report</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/how-to">How To</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main>
        <h2>Exercise Page</h2>
        <div class="search-filter-container">
            <label for="searchExercise">Search Exercise:</label>
            <input type="text" id="searchExercise" placeholder="Enter exercise name" oninput="searchExercises()">
            <br><br>

            <h3>Filter by Category</h3>
            <div class="filter-buttons">
                <button type="button" onclick="filterByCategory('Chest')">Chest</button>
                <button type="button" onclick="filterByCategory('Back')">Back</button>
                <button type="button" onclick="filterByCategory('Leg')">Leg</button>
                <button type="button" onclick="filterByCategory('Shoulder')">Shoulder</button>
                <button type="button" onclick="filterByCategory('Biceps')">Biceps</button>
                <button type="button" onclick="filterByCategory('Triceps')">Triceps</button>
                <button type="button" onclick="filterByCategory('Abs')">Abs</button>
                <button type="button" onclick="filterByCategory('Forearm')">Forearm</button>
                <button type="button" onclick="filterByCategory('Full body')">Full body</button>
                <button type="button" class="reset-button" onclick="resetFilters()">Reset Filters</button>
            </div>
        </div>

        <p>These are the exercises:</p>
        <p>Click on the card to see how to do the exercise.</p>
        <div id="exerciseList" class="exercise-container">
            @foreach($exercises as $exercise)
                <div class="exercise-box" onclick="redirectToYoutube('{{ $exercise->name }}')">
                    <div class="exercise-item" data-category="{{ $exercise->category->name }}">{{ $exercise->name }}</div>
                </div>
            @endforeach
        </div>

        <div id="noExerciseMessage" style="display: none; color: red;">No exercise.</div>
    </main>

    <script>
        function searchExercises() {
            const searchInput = document.getElementById('searchExercise').value.toLowerCase();
            const exerciseBoxes = document.querySelectorAll('.exercise-box'); // Select the whole box
            let hasMatch = false;

            exerciseBoxes.forEach(box => {
                const exerciseItem = box.querySelector('.exercise-item'); // Get the name inside the box
                const exerciseName = exerciseItem.textContent.toLowerCase();

                if (exerciseName.includes(searchInput)) {
                    box.style.display = 'block'; // Show the entire box
                    hasMatch = true;
                } else {
                    box.style.display = 'none'; // Hide the box completely
                }
            });

            document.getElementById('noExerciseMessage').style.display = hasMatch ? 'none' : 'block';
        }

        function filterByCategory(selectedCategory) {
            const exerciseBoxes = document.querySelectorAll('.exercise-box'); // Select the whole box
            let exists = false;

            exerciseBoxes.forEach(box => {
                const exerciseItem = box.querySelector('.exercise-item'); // Get the name inside the box
                const itemCategory = exerciseItem.getAttribute('data-category');

                if (selectedCategory === 'All' || itemCategory === selectedCategory) {
                    box.style.display = 'block'; // Show the entire box
                    exists = true;
                } else {
                    box.style.display = 'none'; // Hide the box completely
                }
            });

            document.getElementById('noExerciseMessage').style.display = exists ? 'none' : 'block';
        }

        function resetFilters() {
            const exerciseBoxes = document.querySelectorAll('.exercise-box');
            exerciseBoxes.forEach(box => {
                box.style.display = 'block'; // Show all boxes again
            });

            document.getElementById('noExerciseMessage').style.display = 'none';
            document.getElementById('searchExercise').value = ''; // Clear search input
        }

        function redirectToYoutube(exerciseName) {
            const formattedName = encodeURIComponent(exerciseName);
            const youtubeUrl = `https://www.youtube.com/results?search_query=${formattedName}+exercise`;

            window.open(youtubeUrl, '_blank');
        }

    </script>
</body>
</html>
