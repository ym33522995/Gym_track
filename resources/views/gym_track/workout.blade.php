<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Page</title>
    <style>
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

        .modal {
            display: none;
            position: fixed;
            z-index: 20;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }

        .modal-content textarea {
            width: 100%;
            height: 100px;
        }

        .modal-content button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
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

    <main>
        <h2>Workout Page</h2>
        <p>You are now using template: {{ $template->name }}.</p>
        <div>
            <h3>Exercises:</h3>
            <form action="/record/store" method="POST" onsubmit="return false;">
                @csrf
                @foreach ($template->templateContents as $content)
                    <div data-exercise-id="{{ $content->exercise->id }}">
                        <strong>{{ $content->exercise->name }}</strong>
                        <hr>
                        @for ($i = 1; $i <= $content->set; $i++)
                        <div data-set-number="{{ $i }}">
                            <label>
                                <input type="checkbox" name="records[{{ $content->exercise->id }}][{{ $i }}][completed]" value="1">
                            </label>
                            <label>Set {{ $i }} - Weight:</label>
                            <input type="number" name="records[{{ $content->exercise->id }}][{{ $i }}][weight]"
                                value="{{ $content->weight }}" step="0.5" placeholder="Weight">
                            <label>Reps:</label>
                            <input type="number" name="records[{{ $content->exercise->id }}][{{ $i }}][rep]"
                                value="{{ $content->rep }}" placeholder="Reps">
                            <span class="kebab-menu">
                                <button type="button" class="kebab-menu-button">⋮</button>
                                <ul class="kebab-menu-options">
                                    <li onclick="deleteSet(this)">Delete</li>
                                    <li onclick="duplicateSet(this)">Duplicate</li>
                                    <li onclick="openNotesModal('{{ $content->exercise->id }}', {{ $i }})">Notes</li>
                                </ul>
                            </span>
                        </div>
                        @endfor
                    </div>
                    <hr>
                @endforeach

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
                                    <span class="kebab-menu">
                                        <button type="button" class="kebab-menu-button">⋮</button>
                                        <ul class="kebab-menu-options">
                                            <li onclick="deleteSet(this)">Delete</li>
                                            <li onclick="duplicateSet(this)">Duplicate</li>
                                            <li onclick="openNotesModal('{{ $content->exercise->id }}', {{ $i }})">Notes</li>
                                        </ul>
                                    </span>
                                </div>
                            @endfor
                            <hr id="delete-when-zero">
                        </div>
                    @endforeach
                @endif
                <button type="submit">Finish</button>
            </form>
            <a href="/workout/{{ $template->id }}/addExercise?from=workout">+ (Add Exercise)</a>
            <a href="/template/quit">Quit</a>
        </div>
    </main>

    <div id="notesModal" class="modal">
        <div class="modal-content">
            <h3>Add Notes</h3>
            <textarea id="noteContent" placeholder="Write your notes here..."></textarea>
            <button onclick="saveNotes()">Save</button>
            <button onclick="closeNotesModal()">Cancel</button>
        </div>
    </div>

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

        function openNotesModal(exerciseId, setNumber) {
            currentExerciseId = exerciseId;
            currentSetNumber = setNumber;

            fetch(`/exercise/${exerciseId}/getNotes`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ set_number: setNumber }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('noteContent').value = data.notes || '';
                    } else {
                        document.getElementById('noteContent').value = '';
                    }
                    document.getElementById('notesModal').style.display = 'flex';
                })
                .catch(error => console.error('Error fetching notes:', error));
        }


        function closeNotesModal() {
            document.getElementById('notesModal').style.display = 'none';
            currentExerciseId = null;
            currentSetNumber = null;
        }

        function saveNotes() {
            const noteContent = document.getElementById('noteContent').value;
            if (noteContent.trim() === '') {
                alert('Note cannot be empty');
                return;
            }

            fetch(`/exercise/${currentExerciseId}/saveNotes`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    set_number: currentSetNumber,
                    notes: noteContent,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Notes saved successfully');
                        closeNotesModal();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error saving notes:', error));
        }


    </script>
</body>
</html>

