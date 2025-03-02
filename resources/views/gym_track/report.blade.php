<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report Page</title>
    <style>
        /* GLOBAL STYLES */
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

        /* MAIN LAYOUT */
        main {
            padding: 20px;
        }

        /* INTRO SECTION (TOP) */
        .header-section {
            margin-bottom: 20px;
        }
        .header-section .page-title {
            margin: 0;
        }

        /* SPLIT SECTION (2 columns) */
        .split-section {
            display: flex;      /* Make columns side-by-side */
            gap: 20px;          /* Space between columns */
        }

        /* LEFT COLUMN */
        .left-side {
            flex: 1;            /* Take up equal width */
            border-right: 3px solid #ddd;
            padding-right: 20px;
        }
        .date-display {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .navigation {
            display: flex;
            gap: 10px;
            margin: 10px 0;
        }
        .navigation button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .navigation button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .exercise-list {
            margin-top: 20px;
        }
        .exercise-item {
            border: 3px solid #52057B;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .exercise-item p {
            margin: 5px 0;
        }

        /* RIGHT COLUMN */
        .right-side {
            flex: 1;            
            padding-left: 20px;
        }

        .exercise-records {
            max-height: 400px; /* Adjust height as needed */
            overflow-y: auto; /* Enables vertical scrolling */
            border: 2px solid #ddd; /* Optional: Add a border for clarity */
            padding: 10px;
            background-color: #f9f9f9; /* Optional: Background color */
            border-radius: 5px; /* Optional: Rounded corners */
        }

        .option-text {
            color: #52057B; /* Deep purple from your theme */
            font-weight: bold;
            font-size: 16px;
        }


        @media (max-width: 980px) {
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
        <div class="header-section">
        <h2 class="page-title">Report Page</h2>
        <p class="page-description">Below is the report and graph of your exercises.</p>

        <div class="split-section">
            <section class="left-side">
                <h2>Exercises Done</h2>
                <div id="dateDisplay" class="date-display"></div>
                <div class="navigation">
                    <button id="prevDay" onclick="loadExercises('prev')">&lt;</button>
                    <button id="nextDay" onclick="loadExercises('next')">&gt;</button>
                </div>
                <div class="exercise-list" id="exerciseList"></div>
            </section>

            <section class="right-side">
                <h2>Records by Exercise</h2>
                <div>
                    <label for="exerciseDropdown" class="option-text">Select Exercise:</label>
                    <select id="exerciseDropdown" onchange="loadRecordsByExercise()">
                        <option value="">-- Select Exercise --</option>
                    </select>
                    <br>
                    <div class="exercise-info" id="exerciseInfo"></div>
                </div>
                <div class="exercise-records" id="exerciseRecords"></div>
            </section>
        </div>
    </main>

    <script>
        let currentDate = new Date();

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        async function loadExercises(direction = null) {
            if (direction === 'prev') {
                currentDate.setDate(currentDate.getDate() - 1);
            } else if (direction === 'next') {
                currentDate.setDate(currentDate.getDate() + 1);
            }

            const formattedDate = formatDate(currentDate);

            try {
                const response = await fetch(`/report/get-exercises?date=${formattedDate}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                // console.log(data);

                if (data.success) {
                    const dateDisplay = document.getElementById('dateDisplay');
                    if (dateDisplay) {
                        dateDisplay.textContent = `Date: ${data.date}`;
                    }

                    // Render exercises
                    const exerciseList = document.getElementById('exerciseList');
                    if (exerciseList) {
                        exerciseList.innerHTML = data.exercises.map(exercise => `
                            <div class="exercise-item">
                                <p><strong>Exercise:</strong> ${exercise.exercise_name}</p>
                                <p><strong>Weight:</strong> ${exercise.weight}</p>
                                <p><strong>Reps:</strong> ${exercise.rep}</p>
                                ${exercise.notes ? `<p><strong>Notes:</strong> ${exercise.notes}</p>` : ''}
                            </div>
                        `).join('');
                    }

                    // Disable the next button if it's today's date
                    const today = new Date();
                    document.getElementById('nextDay').disabled = formatDate(today) === formattedDate;
                }
            } catch (error) {
                console.error('Error fetching exercises:', error);
            }
        }


        // Load today's exercises on page load
        document.addEventListener('DOMContentLoaded', () => loadExercises());

        document.addEventListener('DOMContentLoaded', () => {
            fetch('/exercise/all')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const dropdown = document.getElementById('exerciseDropdown');

                        // Sort exercises alphabetically by name
                        data.exercises.sort((a, b) => a.exercise_name.localeCompare(b.exercise_name));

                        // Append sorted options to the dropdown
                        data.exercises.forEach(ex => {
                            const option = document.createElement('option');
                            option.value = ex.id;
                            option.textContent = `${ex.exercise_name} (${ex.category_name})`;
                            dropdown.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching exercises:", error);
                });
        });


        


        async function loadRecordsByExercise() {
            const exerciseId = document.getElementById('exerciseDropdown').value;

            if (!exerciseId) {
                document.getElementById('exerciseRecords').innerHTML = '<p>Please select an exercise.</p>';
                return;
            }

            try {
                const response = await fetch(`/report/get-records-by-exercise?exercise_id=${exerciseId}`);
                const data = await response.json();

                if (data.success) {
                    const recordsContainer = document.getElementById('exerciseRecords');
                    recordsContainer.innerHTML = data.records.map(record => `
                        <div class="exercise-item">
                            <p><strong>Date:</strong> ${record.date}</p>
                            <p><strong>Exercise:</strong> ${record.exercise_name}</p>
                            <p><strong>Weight:</strong> ${record.weight}</p>
                            <p><strong>Reps:</strong> ${record.rep}</p>
                            ${record.notes ? `<p><strong>Notes:</strong> ${record.notes}</p>` : ''}
                        </div>
                    `).join('');
                } else {
                    document.getElementById('exerciseRecords').innerHTML = `<p>${data.message}</p>`;
                }
            } catch (error) {
                console.error('Error fetching records by exercise:', error);
            }
        }


    </script>
</body>
</html>
