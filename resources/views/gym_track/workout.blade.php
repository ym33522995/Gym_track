<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Page</title>
    <style>
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

        .kebab-menu {
            position: relative;
            display: inline-block;
        }

        .kebab-menu-button {
            cursor: pointer;
            border: none;
            background: none;
            font-size: 18px;
        }

        .kebab-menu-options {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 10;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .kebab-menu-options li {
            padding: 8px 12px;
            cursor: pointer;
        }

        .kebab-menu-options li:hover {
            background-color: #f2f2f2;
        }

        .kebab-menu.open .kebab-menu-options {
            display: block;
        }

        .notes-section {
            display: none;
            margin-top: 10px;
        }

        .modal-content textarea {
            width: 100%;
            height: 100px;
        }

        .modal-content button {
            margin-top: 10px;
        }

        .timer-container {
            position: absolute;
            top: 70px;
            right: 20px;
            font-size: 20px;
            font-weight: bold;
            color: white;
            background-color: #892CDC;
            padding: 10px 20px;
            border-radius: 10px;
        }

        /* Exercise Box */
        .unit-exercise {
            display: flex; 
            align-items: center;
            justify-content: space-between; 
            background-color: #FFFFFF;
            color: #000000;
            border: 2px solid #52057B;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            text-align: left;
            transition: all 0.3s ease-in-out;
        }

        .exercise-details {
            display: flex;
            align-items: center;
            flex-grow: 1; /* Make input fields take available space */
            gap: 10px; /* Space between labels and inputs */
        }

        /* Strike-through when checkbox is checked */
        .unit-exercise.completed {
            background-color: #BC6FF1;
            color: #000000;
        }

        .unit-exercise.completed .notes {
            text-decoration: none !important; 
            display: block !important;
            font-style: italic;
            color: #52057B;
        }

        .unit-exercise.completed .exercise-details {
            text-decoration: line-through;
        }


        /* Checkbox styling */
        .custom-checkbox {
            opacity: 0; /* Keep it invisible but still interactive */
            position: absolute; /* Position it over the styled checkbox */
            width: var(--checkbox-height);
            height: var(--checkbox-height);
            cursor: pointer;
        }

        .check-box {
            display: inline-block;
            height: 25px; /* Adjust the size */
            width: 25px;
            border: 2px solid rgb(0, 0, 0, 0.5);
            border-radius: 50%;
            position: relative;
            cursor: pointer;
        }


        .custom-checkbox:checked + .check-box {
            border-color: var(--checked-color);
            background-color: #52057B;
        }

        .custom-checkbox:checked + .check-box::before {
            content: "✔";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 18px;
            font-weight: bold;
        }



        /* Buttons */
        .btn-custom {
            background-color: #52057B;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #BC6FF1;
            color: #000000;
        }
    
        .timer-box {
            position: absolute;
            top: 65px;
            right: 20px;
            z-index: 1000;
            color: black;
            padding: 5px 10px;   
            border: 2px solid gray; 
            border-radius: 8px;  
            display: inline-block; 
            
        }

        .timer-red {
            color: red;
            font-weight: bold;
            border: red;
        }

        .quit-container {
            position: absolute;
            top: 150px;
            right: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #52057B;  /* Button color */
            color: #FFFFFF;  /* Text color */
            font-weight: bold;
            text-decoration: none;  /* Remove underline */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .quit-container:hover {
            background-color: #BC6FF1;  /* Hover effect */
            color: #FFFFFF;
        }

        .button-container {
            position: relative; /* Keep it in the normal document flow */
            margin-top: 30px; /* Adds spacing */
            display: flex;
            justify-content: center; /* Centers buttons horizontally */
            align-items: center; /* Centers vertically */
            width: 100%; /* Ensure it spans full width */
            max-width: none; /* Remove width restriction */
            padding: 15px 0;
            gap: 30px;
        }

        .finish-btn, .add-btn {
            width: 200px; /* Fixed width */
            height: 45px; /* Fixed height */
            font-size: 16px;
            padding: 10px 12px;
            border-radius: 6px;
            text-align: center;
            background-color: #52057B;
            color: #FFFFFF;
            font-weight: bold;
            border: none;
        }

        .finish-btn:hover, .add-btn:hover {
            background-color: #BC6FF1;
            transform: scale(1.1);
        }

        /* Mobile-friendly: Make buttons full-width on smaller screens */
        @media (max-width: 600px) {
            .button-container {
                flex-direction: column;
                width: 90%;
            }

            .finish-btn, .add-btn {
                width: 100%;
            }
        }

        /* Notes section - Modal Style */
        .notes-section {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            background: #FFFFFF;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            display: none; /* Initially hidden */
            z-index: 1000;
        }


        /* Textarea Styling */
        .notes-section textarea {
            width: 100%;
            height: 80px;
            border: 1px solid #52057B;
            border-radius: 5px;
            padding: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        /* OK Button */
        .notes-section button {
            width: 100%;
            background: #52057B;
            color: white;
            border: none;
            padding: 8px;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            box-sizing: border-box;
        }

        .notes-section button:hover {
            background: #BC6FF1;
            color: black;
        }

        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
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

    <main class="container mt-4">
        <h2>Workout Page</h2>
        <p>You are now using template: {{ $template->name }}.</p>
        <div class="timer-box">
            <h3 >Workout Timer: <span id="timerDisplay" class="timer-red">00:00</span></h3>
        </div>

        <div>
            <h3>Exercises:</h3>
            @php
                $state = $state ?? [];
            @endphp
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/record/store" method="POST" id="workoutForm">
                @csrf
                @foreach ($template->templateContents as $content)
                    @php 
                        $exerciseId = $content->exercise->id; 
                        $exerciseRecords = $state[$exerciseId] ?? [];
                    @endphp
                    <div data-exercise-id="{{ $content->exercise->id }}">
                        <strong>{{ $content->exercise->name }}</strong>
                        <hr>
                        @for ($i = 1; $i <= $content->set; $i++)
                        @php
                            $record = $exerciseRecords[$i] ?? [];
                            $checked = !empty($record['completed']);
                            $weightValue = $record['weight'] ?? $content->weight;
                            $repValue = $record['rep'] ?? $content->rep;
                            $notesValue = $record['notes'] ?? '';
                        @endphp
                        <div data-set-number="{{ $i }}" class="unit-exercise {{ $checked ? 'completed' : '' }}">
                            <div class="exercise-details">
                                <label>
                                    <input class="custom-checkbox" type="checkbox" name="records[{{ $content->exercise->id }}][{{ $i }}][completed]" value="1" onclick="toggleExerciseCompletion(this)" {{ $checked ? 'checked' : '' }}>
                                    <span class="check-box"></span>
                                </label>
                                <label>Set {{ $i }} - Weight:</label>
                                <input type="number" name="records[{{ $content->exercise->id }}][{{ $i }}][weight]"
                                    value="{{ $weightValue }}" step="0.5" placeholder="Weight">
                                <label>Reps:</label>
                                <input type="number" name="records[{{ $content->exercise->id }}][{{ $i }}][rep]"
                                    value="{{ $repValue }}" placeholder="Reps">
                            </div>
                            <div class="notes" style="{{ $notesValue ? '' : 'display:none;' }}">
                                @if($notesValue)
                                    Notes: {{ $notesValue }}
                                @endif
                            </div>
                            <span class="kebab-menu">
                                <button type="button" class="kebab-menu-button">⋮</button>
                                <ul class="kebab-menu-options">
                                    <li onclick="deleteSet(this)">Delete</li>
                                    <li onclick="duplicateSet(this)">Duplicate</li>
                                    <li onclick="toggleNotesSection(this)">Notes</li>
                                </ul>
                            </span>
                            <div class="notes-section" style="display: none; margin-top: 10px;">
                                <label>Notes:</label>
                                <textarea name="records[{{ $content->exercise->id }}][{{ $i }}][notes]" placeholder="Enter your notes here..." rows="3">{{ $notesValue }}</textarea>
                                <button type="button" onclick="hideNotesSection(this)">OK</button>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <hr>
                @endforeach

                @if (!empty($newExercises))
                    @foreach ($newExercises as $exerciseId => $exerciseData)
                        <div data-exercise-id="{{ $content->exercise_id }}">
                            <strong id="delete-when-zero">{{ $exerciseData['name'] }}:</strong>
                            <hr>
                           
                            @for ($i = 1; $i <= $exerciseData['set']; $i++)
                                
                                <div data-set-number="{{ $i }}" class="unit-exercise">
                                    <div class="exercise-details">
                                        <label>
                                            <input class="custom-checkbox" type="checkbox" name="records[{{ $content->exercise->id }}][{{ $i }}][completed]" value="1" onclick="toggleExerciseCompletion(this)">
                                            <span class="check-box"></span>
                                        </label>
                                        <label>Set {{ $i }} - Weight:</label>
                                        <input type="number" name="records[{{ $exerciseId }}][{{ $i }}][weight]"  step="0.5" value="{{ $exerciseData['weight'] }}" placeholder="Weight">
                                        <label>Reps:</label>
                                        <input type="number" name="records[{{ $exerciseId }}][{{ $i }}][rep] }}" value="{{ $exerciseData['rep'] }}"  placeholder="Reps">
                                    </div>
                                    <div class="notes" style="display: none; font-style: italic; color: #52057B; margin-top: 5px;"></div> 
                                    <span class="kebab-menu">
                                        <button type="button" class="kebab-menu-button">⋮</button>
                                        <ul class="kebab-menu-options">
                                            <li onclick="deleteNewExerciseSet(this)">Delete</li>
                                            <li onclick="duplicateNewExerciseSet(this)">Duplicate</li>
                                            <li onclick="toggleNotesSection(this)">Notes</li>
                                        </ul>
                                    </span>
                                    <div class="notes-section" style="display: none; margin-top: 10px;">
                                        <label>Notes:</label>
                                        <textarea name="records[{{ $content->exercise->id }}][{{ $i }}][notes]" placeholder="Enter your notes here..." rows="3"></textarea>
                                        <button type="button" onclick="hideNotesSection(this)">OK</button>
                                    </div>
                                </div>
                            @endfor
                            <hr id="delete-when-zero">
                        </div>
                    @endforeach
                @endif
                <div class="button-container">
                    <button type="submit" form="addExerciseForm" class="add-btn">+ (Add Exercise)</button>
                    <button type="submit" class="finish-btn">Finish</button>
                </div>
            </form>
            <form action="/template/{{ $template->id }}/saveCurrentRecord" method="POST" onsubmit="captureFormState()" id="addExerciseForm">
                @csrf
                <input type="hidden" name="record_state" id="recordState"/>
            </form>
            <a href="/template/quit" class="quit-container">Quit Exercise</a>
        </div>
    </main>


    <script>
        document.addEventListener('click', function (e) {
            const menus = document.querySelectorAll('.kebab-menu');
            menus.forEach(menu => {
                if (!menu.contains(e.target)) {
                    menu.classList.remove('open');
                }
            });

            if (e.target.classList.contains('kebab-menu-button')) {
                e.preventDefault();
                e.target.closest('.kebab-menu').classList.toggle('open');
            }
        });

        let currentExerciseId = null;
        let currentSetNumber = null;

        function deleteSet(button) {
            if (confirm('Are you sure you want to delete this set?')) {
                const setDiv = button.closest('div');
                const exerciseId = setDiv.closest('[data-exercise-id]').getAttribute('data-exercise-id');
                const weight = setDiv.querySelector('input[name*="weight"]').value;
                const rep = setDiv.querySelector('input[name*="rep"]').value;
                const templateId = "{{ $template->id }}";

                fetch(`/template/${templateId}/deleteExercise`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ exercise_id: exerciseId, weight: weight, rep: rep }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log('Fetch request completed:', data);
                        if (data.success) {
                            setDiv.remove();
                            // alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        }

        function duplicateSet(button) {
            const setDiv = button.closest('div');
            const exerciseId = setDiv.closest('[data-exercise-id]').getAttribute('data-exercise-id');
            const weight = setDiv.querySelector('input[name*="weight"]').value;
            const rep = setDiv.querySelector('input[name*="rep"]').value;
            const templateId = "{{ $template->id }}";

            fetch(`/template/${templateId}/duplicateExercise`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ exercise_id: exerciseId, weight: weight, rep: rep }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const clone = setDiv.cloneNode(true);
                        setDiv.parentNode.insertBefore(clone, setDiv.nextSibling);
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function toggleNotesSection(button) {
            const notesSection = button.closest('div').querySelector('.notes-section');
            if (notesSection) {
                notesSection.style.display = notesSection.style.display === 'none' ? 'block' : 'none';
            }
        }

        function hideNotesSection(button) {
            const notesSection = button.closest('.notes-section');
            if (notesSection) {
                notesSection.style.display = 'none';
            }
        }


        function deleteNewExerciseSet(button) {
            const setDiv = button.closest('.unit-exercise'); // Get the closest set container

            if (setDiv) {
                setDiv.remove(); // Remove it from the DOM
            }
        }


        function duplicateNewExerciseSet(button) {
            const setDiv = button.closest('.unit-exercise'); // Get the closest set container

            if (setDiv) {
                const clone = setDiv.cloneNode(true); // Clone the entire set
                setDiv.parentNode.insertBefore(clone, setDiv.nextSibling); // Insert after the original
            }
        }



        function toggleExerciseCompletion(checkbox) {
            const unitExercise = checkbox.closest('.unit-exercise');
            const notes = unitExercise.querySelector('.notes');
            if (checkbox.checked) {
                unitExercise.classList.add('completed'); // Add strikethrough effect
                notes.style.textDecoration = "none";
            } else {
                unitExercise.classList.remove('completed'); // Remove strikethrough
            }
        }

        function hideNotesSection(button) {
            const notesSection = button.closest('.notes-section'); 
            const textarea = notesSection.querySelector("textarea"); 
            const notesDisplay = button.closest('.unit-exercise').querySelector('.notes'); 

            if (textarea.value.trim() !== "") {
                notesDisplay.textContent = "Notes: " + textarea.value.trim(); 
                notesDisplay.style.display = "block"; 
            } else {
                notesDisplay.style.display = "none"; 
            }

            notesSection.style.display = "none"; // Hide the notes section after saving
        }

        function captureFormState() {
            let stateData = {};

            const recordGroups = document.querySelectorAll('[data-exercise-id]');
            recordGroups.forEach(group => {
                const exerciseId = group.getAttribute('data-exercise-id');
                const setDivs = group.querySelectorAll('.unit-exercise');
                
                stateData[exerciseId] = {};

                setDivs.forEach(div => {
                    const setNumber = div.getAttribute('data-set-number');
                    const completed = div.querySelector('input[type="checkbox"]')?.checked ? 1 : 0;
                    const weight = div.querySelector('input[name*="[weight]"]')?.value || '';
                    const rep = div.querySelector('input[name*="[rep]"]')?.value || '';
                    const notes = div.querySelector('textarea')?.value || '';

                    stateData[exerciseId][setNumber] = {
                        completed,
                        weight,
                        rep,
                        notes
                    };
                });
            });

            // 2. Put JSON into the hidden field
            document.getElementById('recordState').value = JSON.stringify(stateData);
        }       


        document.addEventListener("DOMContentLoaded", function () {
            let timerDisplay = document.getElementById("timerDisplay");
            let startTime = sessionStorage.getItem("workoutTimer") || 0;
            let timerInterval;

            function formatTime(seconds) {
                let minutes = Math.floor(seconds / 60);
                let remainingSeconds = seconds % 60;
                return (
                    String(minutes).padStart(2, "0") + ":" +
                    String(remainingSeconds).padStart(2, "0")
                );
            }

            function startTimer() {
                let elapsedTime = parseInt(startTime, 10);
                timerInterval = setInterval(() => {
                    elapsedTime++;
                    timerDisplay.textContent = formatTime(elapsedTime);
                    sessionStorage.setItem("workoutTimer", elapsedTime);
                }, 1000);
            }

            startTimer();

            document.querySelector(".add-btn").addEventListener("click", function () {
                sessionStorage.setItem("workoutTimer", sessionStorage.getItem("workoutTimer"));
            });

            function resetTimer() {
                clearInterval(timerInterval);
                sessionStorage.removeItem("workoutTimer");
                timerDisplay.textContent = "00:00";
            }

            document.querySelector(".quit-container").addEventListener("click", resetTimer);
            document.querySelector(".finish-btn").addEventListener("click", resetTimer);


            function confirmFinishWorkout(event) {
                event.preventDefault();  // Stop immediate submission

                let confirmFinish = confirm("Are you sure you want to finish your workout?");
                if (confirmFinish) {
                    // Instead of redirecting with JS, submit the form normally
                    document.getElementById("workoutForm").submit();
                }
            }

            // Attach to the Finish button
            document.addEventListener("DOMContentLoaded", function () {
                const form = document.getElementById("workoutForm");

                form.addEventListener("submit", function (event) {
                    // 1️⃣ Perform front-end validation: Ensure at least one checkbox is checked
                    const checkboxes = document.querySelectorAll('input[type="checkbox"][name*="completed"]');
                    const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

                    if (!isChecked) {
                        alert("At least one exercise must be marked as completed!");
                        event.preventDefault(); // Stop form submission
                        return;
                    }

                    // 2️⃣ Ask for confirmation if validation passes
                    let confirmFinish = confirm("Are you sure you want to finish your workout?");
                    if (!confirmFinish) {
                        event.preventDefault(); // Stop form submission if user cancels
                    }
                });
            });

        });




        
    </script>
</body>
</html>

