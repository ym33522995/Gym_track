<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exercises</title>
    <style>
        /* Matched styling with createTemplate.blade */
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

        /* Search and Filter Styling */
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
        }

        .filter-buttons button:hover {
            background-color: #BC6FF1;
            color: #000000;
        }

        .reset-button {
            background-color: black !important;
            color: white !important;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }


        /* Exercise Container Layout */
        .exercise-container {
            display: grid;
            grid-template-columns: repeat(3, auto);
            /* grid-template-columns: repeat(4, 1fr); */
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        /* Responsive Grid */
        @media (max-width: 1024px) {
            .exercise-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .exercise-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .exercise-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        /* ====== Exercise Box ====== */
        .exercise-box {
            background-color: #FFFFFF;
            color: #000000;
            border-radius: 10px;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: left;
            justify-content: space-between;
            margin: 15px;
            gap: 20px;
            position: relative;
            padding-top: 30px; /* Space for checkbox & name */
        }

        /* Hover Effect */
        .exercise-box:hover {
            transform: scale(1.05);
            background-color: #892CDC;
            color: #FFFFFF;
        }

        .highlight {
            font-weight: bold;
        }

        /* Hide extra exercises */
        .exercise-box:nth-child(n+13) {
            display: none;
        }

        /* ====== Exercise Name & Checkbox ====== */
        .exercise-box label {
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Move Checkbox to Left Top */
        .exercise-box input[type="checkbox"] {
            transform: scale(1.3);
            margin-right: 10px;
        }

        /* ====== Input Fields (Weight, Reps, Sets) ====== */
        .exercise-box .exercise-inputs {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-grow: 1;
        }

        .exercise-box input[type="number"] {
            width: 70px;
            padding: 6px;
            border: 2px solid #892CDC;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }

        .exercise-box input[type="text"]:focus,
        .exercise-box input[type="number"]:focus {
            outline: none;
            border-color: #52057B;
        }

        .button-container {
            display: flex;
            justify-content: center; /* Horizontally center */
            align-items: center; /* Vertically center if needed */
            width: 100%; /* Ensure full width */
        }

        .add-btn {
            width: 90%;  /* Stretch from end to end */
            height: auto;  /* Auto height for flexibility */
            background-color: #52057B;  /* Background color */
            color: white;  /* Font color */
            font-weight: bold;  /* Make the text bold */
            border: none;  /* Remove border */
            text-align: center;  /* Center text */
            font-size: 16px;  /* Adjust font size */
            cursor: pointer;  /* Pointer cursor */
            border-radius: 5px; /* Optional: rounded edges */
            padding: 15px;
            margin-bottom: 20px;
            margin-top: 20px;
        }


        .add-btn:hover {
            background-color: #BC6FF1;  /* Hover effect */
            color: white;  /* Maintain white font color */
        }


    </style>
</head>
<body>
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
    <main>
        <h2>Select Exercises to Add</h2>
        <h3>You are now using template {{ $template->name }}</h3>

        <div class="search-filter-container">
            <label for="searchExercise">Search Exercise:</label>
            <input type="text" id="searchExercise" placeholder="Enter exercise name" oninput="searchExercises()">
            <br>
            <h3>Filter by Category</h3>
            <div class="filter-buttons">
                <button onclick="filterByCategory('Chest')">Chest</button>
                <button onclick="filterByCategory('Back')">Back</button>
                <button onclick="filterByCategory('Leg')">Leg</button>
                <button onclick="filterByCategory('Shoulder')">Shoulder</button>
                <button onclick="filterByCategory('Biceps')">Biceps</button>
                <button onclick="filterByCategory('Triceps')">Triceps</button>
                <button onclick="filterByCategory('Abs')">Abs</button>
                <button onclick="filterByCategory('Forearm')">Forearm</button>
                <button onclick="filterByCategory('Full body')">Full body</button>
                <button class="reset-button" onclick="resetFilters()">Reset Filters</button>
            </div>
        </div>

        <form action="/workout/{{ $template->id }}/saveExercise" method="POST">
            @csrf
            <input type="hidden" name="from" value="{{ $from }}">
            <div id="exerciseContainer" class="exercise-container">
                @foreach($exercises as $exercise)
                    <div class="exercise-box">
                        <label>
                            <input class="exercise-item" data-category="{{ $exercise->category->name }}" type="checkbox" name="exercises[{{ $exercise->id }}][selected]" value="1">
                            <span class="checkbox-custom"></span>
                            {{ $exercise->name }}
                        </label>
                        <div class="exercise-inputs">
                            <input type="number" name="exercises[{{ $exercise->id }}][weight]" placeholder="Weight" step="0.5">
                            <input type="number" name="exercises[{{ $exercise->id }}][rep]" placeholder="Reps">
                            <input type="number" name="exercises[{{ $exercise->id }}][set]" placeholder="Sets">
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="noExerciseMessage" style="display: none; color: red;">No exercise.</div>
            <div class="button-container">
                <button type="submit" class="add-btn">Add exercise(s) to the menu</button>
            </div>
        </form>
    </main>

    <script>
        let originalOrder = [];

        window.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('exerciseContainer');
            originalOrder = Array.from(container.children);
        });

        function searchExercises() {
            const searchInput = document
                .getElementById('searchExercise')
                .value
                .toLowerCase();

            console.log(searchInput);

            const container = document.getElementById('exerciseContainer');
            const exerciseBlocks = container.querySelectorAll('.exercise-box');

            let hasMatch = false;

            exerciseBlocks.forEach(block => {
                const label = block.querySelector('label');
                const exerciseName = label.textContent.toLowerCase();

                if (exerciseName.includes(searchInput)) {
                    block.style.display = 'flex';
                    hasMatch = true;
                } else {
                    block.style.display = 'none';
                }
            });

            document.getElementById('noExerciseMessage').style.display = hasMatch ? 'none' : 'block';
        }

        // function reorderByCategory(selectedCategory) {
        //     const container = document.getElementById('exerciseContainer');
        //     const blocks = Array.from(container.querySelectorAll('.exercise-box'));

        //     blocks.forEach(block => {
        //         block.classList.remove('highlight');
        //     });

        //     blocks.sort((a, b) => {
        //         const categoryA = a.querySelector('.exercise-item').dataset.category;
        //         const categoryB = b.querySelector('.exercise-item').dataset.category;
                
        //         if (categoryA === selectedCategory && categoryB !== selectedCategory) {
        //             return -1;
        //         } 
        //         else if (categoryA !== selectedCategory && categoryB === selectedCategory) {
        //             return 1;  
        //         }
        //         return 0;
        //     });

        //     let foundAny = false;
        //     blocks.forEach(block => {
        //         const category = block.querySelector('.exercise-item').dataset.category;
        //         if (category === selectedCategory) {
        //             block.classList.add('highlight');
        //             foundAny = true;
        //         }
        //     });

        //     document.getElementById('noExerciseMessage').style.display = foundAny ? 'none' : 'block';

        //     blocks.forEach(block => container.appendChild(block));
        // }

        function filterByCategory(selectedCategory) {
            const container = document.getElementById('exerciseContainer');
            const blocks = Array.from(container.querySelectorAll('.exercise-box'));

            let foundAny = false;
            blocks.forEach(block => {
                const checkbox = block.querySelector('.exercise-item');
                const category = checkbox.dataset.category;
                if (category === selectedCategory) {
                    block.style.display = 'flex';
                    foundAny = true;
                } else {
                    block.style.display = 'none';
                }
            });

            document.getElementById('noExerciseMessage').style.display = foundAny ? 'none' : 'block';
        }

        function resetFilters() {
            const container = document.getElementById('exerciseContainer');

            originalOrder.forEach(block => block.classList.remove('highlight'));

            
            originalOrder.forEach(block => {
                block.style.display = 'flex';
            });

            
            originalOrder.forEach(block => container.appendChild(block));
            
            document.getElementById('noExerciseMessage').style.display = 'none';
            
            document.getElementById('searchExercise').value = '';
        }

        document.addEventListener("DOMContentLoaded", function () {
            const exerciseBoxes = document.querySelectorAll(".exercise-box");

            exerciseBoxes.forEach(box => {
                box.addEventListener("click", function (event) {
                    // Find the checkbox inside the clicked box
                    const checkbox = this.querySelector("input[type='checkbox']");
                    const label = this.querySelector("label");

                    // Ignore clicks on inputs and button
                    if (!event.target.matches("input, button")) {
                        checkbox.checked = !checkbox.checked; // Toggle checkbox
                    }

                    if (event.target === label || event.target === label.firstChild) {
                        checkbox.checked = !checkbox.checked;
                    }
                });
            });
        });

    </script>
</body>
</html>
