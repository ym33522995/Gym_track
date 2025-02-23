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
            margin-top: 50px;
        }

        p {
            text-align: left;
            font-size: 18px;
            color: #000000;
        }

        /* ====== Form Styling ====== */
        form {
            display: flex;
            flex-direction: column;
            align-items: left;
            padding: 20px;
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

        #template_name {
            width: 300px;
            padding: 8px;
            font-size: 16px;
            border: 2px solid #892CDC;
            border-radius: 5px;
            text-align: left;
        }

        #template_name:focus {
            outline: none;
            border-color: #52057B;
        }

        /* ====== Exercise Container Layout ====== */
        .exercise-container {
            display: grid;
            grid-template-columns: repeat(3, auto);
            /* grid-template-columns: repeat(4, 1fr); */
            gap: 20px;
            justify-content: left;
            margin-top: 20px;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        /* Responsive Grid Adjustments */
        @media (max-width: 1024px) {
            .exercise-container {
                grid-template-columns: repeat(3, 1fr);
                grid-template-rows: repeat(4, auto);
            }
        }

        @media (max-width: 768px) {
            .exercise-container {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(6, auto);
            }
        }

        @media (max-width: 500px) {
            .exercise-container {
                grid-template-columns: repeat(1, 1fr);
                grid-template-rows: repeat(12, auto);
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

        /* ====== Different Weight (Duplicate) Button ====== */
        .exercise-box .duplicate-btn {
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

        /* Button Hover Effect */
        .exercise-box .duplicate-btn:hover {
            background-color: #BC6FF1;
            color: #000000;
        }

        /* ====== Submit Button ====== */
        input[type="submit"] {
            background-color: #52057B;
            color: #FFFFFF;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #BC6FF1;
            color: #000000;
        }

        /* ====== Error Alert Box ====== */
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: left;
            position: relative;
        }

        /* Error Alert - Red Theme */
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Error List */
        .alert-danger ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        /* Individual Error Message */
        .alert-danger li {
            padding: 5px 0;
        }

        /* Close Button for Alert */
        .alert .close-btn {
            position: absolute;
            top: 8px;
            right: 12px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            color: #721c24;
            background: none;
            border: none;
        }

        /* Close Button Hover Effect */
        .alert .close-btn:hover {
            color: #491217;
        }

        #noExerciseMessage {
            display: none;
        }

        button.reset-button {
            background-color: #000000;
            color: white;
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
        <h2>Create template Page</h2>
        <p>Please choose your exercise to create a template.</p>
        <form id="templateForm" action="/template/store" method="POST">
            @csrf
            <label for="template_name">Template Name:</label>
            <input type="text" id="template_name" name="template_name"><br><br>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="search-filter-container">
                <label for="searchExercise">Search Exercise:</label>
                <input type="text" id="searchExercise" placeholder="Enter exercise name" oninput="searchExercises()">
                <br>

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

            <h3>Select Exercise:</h3>
            <div class="exercise-container" id="exerciseContainer">
                @foreach($exercises as $exercise)
                    <div class="exercise-box" data-exercise-id="{{ $exercise->id }}" data-category="{{ $exercise->category->name }}">
                        <label>
                            <input type="checkbox" class="exercise-item" name="exercises[{{ $exercise->id }}][0][selected]" value="1">
                            {{ $exercise->name }}
                        </label>

                        <div class="exercise-inputs">
                            <input type="number" name="exercises[{{ $exercise->id }}][0][weight]" placeholder="Weight" step=0.5>
                            <input type="number" name="exercises[{{ $exercise->id }}][0][rep]" placeholder="Reps">
                            <input type="number" name="exercises[{{ $exercise->id }}][0][set]" placeholder="Sets">
                        </div>
                        <button type="button" class="duplicate-btn" onclick="duplicateSet(this)">Different weight</button>
                    </div>
                @endforeach
            </div>

            <div id="noExerciseMessage">No exercises found.</div>

            <input type="submit" value="Done Selecting"> 
        </form> 
    </main>



    <script>
        function duplicateSet(button) {
            const setDiv = button.closest('div'); 
            const exerciseId = setDiv.getAttribute('data-exercise-id'); 
            const parentDiv = setDiv.parentNode;

            const clone = setDiv.cloneNode(true);

            const currentIndex = parentDiv.querySelectorAll(`[data-exercise-id="${exerciseId}"]`).length;

            const inputs = clone.querySelectorAll('input');
            inputs.forEach(input => {
                const nameMatch = input.name.match(/exercises\[(\d+)\]\[(\d+)\]\[(\w+)\]/); 
                if (nameMatch) {
                    const fieldExerciseId = nameMatch[1]; 
                    const fieldName = nameMatch[3]; 

                    input.name = `exercises[${fieldExerciseId}][${currentIndex}][${fieldName}]`;
                }
            });

            setDiv.parentNode.insertBefore(clone, setDiv.nextSibling);
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

        function filterByCategory(selectedCategory) {
            const container = document.getElementById('exerciseContainer');
            const blocks = Array.from(container.querySelectorAll('.exercise-box'));

            let foundAny = false;
            blocks.forEach(block => {
                const category = block.dataset.category;
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
                block.style.display = '';
            });

            
            originalOrder.forEach(block => container.appendChild(block));

            
            document.getElementById('noExerciseMessage').style.display = 'none';

            
            document.getElementById('searchExercise').value = '';
        }
    </script>

</body>
</html>
