<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Template Page</title>
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
                            <div>
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
                <a href="/workout/{{ $template->id }}/addExercise?from=editTemplate">+ (Add Exercise)</a>
                <button type="submit">Done Editing</button>
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
