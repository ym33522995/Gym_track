<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Template Page</title>
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

        /* Styling for unit-exercise */
        .unit-exercise {
            border: 2px solid #52057B; /* Border added as per request */
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        /* Updated button styles inside unit-exercise */
        .unit-exercise button {
            background-color: #892CDC; /* Button color as requested */
            color: white;
            border: none;
            padding: 12px 18px; /* Adjusted button size */
            font-size: 16px; /* Large enough font */
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px;
        }

        .unit-exercise button:hover {
            background-color: #52057B; /* Slightly darker shade on hover */
        }

        /* Optional: Add spacing for better layout */
        .unit-exercise label {
            display: inline-block;
            margin-right: 10px;
        }

        /* ===== Added new div styling for better sectioning ===== */
        .section-container {
            padding: 20px;
            border: 1px solid #ddd;
            margin-top: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        /* ===== End of new div styling ===== */

        /* Button container to align buttons centrally */
        .button-container {
            display: flex;
            justify-content: center; /* Centers the buttons horizontally */
            gap: 20px; /* Adds spacing between the buttons */
            margin-top: 20px;
        }

        /* Styling for Add Exercise Button */
        .add-exercise-btn {
            display: inline-block;
            background-color: #892CDC;
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-align: center;
            min-width: 180px; /* Ensures a consistent size */
        }

        .add-exercise-btn:hover {
            background-color: #52057B;
        }

        /* Styling for Done Editing Button */
        .done-editing-btn {
            display: inline-block;
            background-color: #52057B;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-align: center;
            min-width: 180px;
        }

        .done-editing-btn:hover {
            background-color: #892CDC;
        }



    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <img src="{{ asset('app_logoT.png') }}" alt="App Logo" class="app-logo">
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
        <h2>Edit Template Page</h2>
        <p>You are now editting template: {{ $template->name }}.</p>
        <p>For the added exercise, you have to click "Done Editting" button to save your changes.</p>
        <div>
            <form action="/template/update/{{ $template->id }}" method="POST">
                @csrf
                @method('PATCH')
                @foreach ($template->templateContents as $content)
                    <div data-exercise-id="{{ $content->exercise_id }}">
                        <strong id="delete-when-zero">{{ $content->exercise->name }}</strong>
                        @for ($i = 1; $i <= $content->set; $i++)
                            <div class="unit-exercise">
                                <label>Set {{ $i }} - Weight:</label>
                                <input type="number" name="exercises[{{ $content->exercise_id }}][sets][{{ $i }}][weight]" value="{{ $content->weight }}">
                                <label>Reps:</label>
                                <input type="number" name="exercises[{{ $content->exercise_id }}][sets][{{ $i }}][rep]" value="{{ $content->rep }}">
                                <button type="button" onclick="deleteSet(this)">Delete</button>
                                <button type="button" onclick="duplicateSet(this)">Duplicate</button>
                            </div>
                        @endfor
                        <hr id="delete-when-zero">
                    </div>
                @endforeach
                <hr>

                @if (!empty($newExercises))
                    @foreach ($newExercises as $exerciseId => $exerciseData)
                        <div data-exercise-id="{{ $content->exercise_id }}">
                            <strong id="delete-when-zero">{{ $exerciseData['name'] }}:</strong>
                            @for ($i = 1; $i <= $exerciseData['set']; $i++)
                                <div>
                                    <label>Set {{ $i }} - Weight:</label>
                                    <input type="number" name="records[{{ $exerciseId }}][{{ $i }}][weight]" value="{{ $exerciseData['weight'] }}" step="0.5" placeholder="Weight">
                                    <label>Reps:</label>
                                    <input type="number" name="records[{{ $exerciseId }}][{{ $i }}][rep] }}" value="{{ $exerciseData['rep'] }}" placeholder="Reps">
                                    <button type="button" onclick="deleteSet(this)">Delete</button>
                                    <button type="button" onclick="duplicateSet(this)">Duplicate</button>
                                </div>
                            @endfor
                            <hr id="delete-when-zero">
                        </div>
                    @endforeach
                @endif
                <div class="button-container">
                    <a href="/workout/{{ $template->id }}/addExercise?from=editTemplate" class="add-exercise-btn">+ (Add Exercise)</a>
                    <button type="submit" class="done-editing-btn">Done Editing</button>
                </div>
            </form>
        </div>

        <script>
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
                                alert(data.message);
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
        </script>
    </main>
</body>
</html>
