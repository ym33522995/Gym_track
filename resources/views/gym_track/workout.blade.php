<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Page</title>
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
        <h2>Workout Page</h2>
        <p>You are now using template: {{ $template->name }}.</p>
        <div>
            <h3>Exercises:</h3>
            <form action="/record/store" method="POST">
                @csrf
                @foreach ($template->templateContents as $content)
                    <div>
                        <strong>{{ $content->exercise->name }}:</strong>
                        <hr>
                        @for ($i = 1; $i <= $content->set; $i++)
                        <div>
                            <label>
                                <input type="checkbox" name="records[{{ $content->exercise->id }}][{{ $i }}][completed]"
                                    value="1">
                            </label>
                            <label>Set {{ $i }} - Weight:</label>
                            <input type="number" name="records[{{ $content->exercise->id }}][{{ $i }}][weight]"
                                value="{{ $content->weight }}" step="0.5" placeholder="Weight">
                            <label>Reps:</label>
                            <input type="number" name="records[{{ $content->exercise->id }}][{{ $i }}][rep]"
                                value="{{ $content->rep }}" placeholder="Reps">
                        </div>
                        @endfor
                    </div>
                    <hr>
                @endforeach


                @if (!empty($newExercises))
                    @foreach ($newExercises as $exerciseId => $exerciseData)
                        @php
                            $temporaryRecord = $temporaryRecords->where('exercise_id', $exerciseId)->first();
                        @endphp
                        <div>
                            <strong>{{ $exerciseData['name'] }}:</strong>
                            @for ($i = 1; $i <= $exerciseData['set']; $i++)
                                <div>
                                    <label>
                                        <input type="checkbox" name="records[{{ $exerciseId }}][{{ $i }}][completed]"
                                            value="1">
                                    </label>
                                    <label>Set {{ $i }} - Weight:</label>
                                    <input type="number" name="records[{{ $exerciseId }}][{{ $i }}][weight]"
                                        value="{{ $exerciseData['weight'] }}" step="0.5" placeholder="Weight">
                                    <label>Reps:</label>
                                    <input type="number" name="records[{{ $exerciseId }}][{{ $i }}][rep }}"
                                        value="{{ $exerciseData['rep'] }}" placeholder="Reps">
                                </div>
                            @endfor
                            <hr>
                        </div>
                    @endforeach
                @endif
                <button type="submit">Finish</button>
            </form>
            <a href="/workout/{{ $template->id }}/addExercise">+ (Add Exercise)</a>

            <!-- <form action="/workout/{{ $template->id }}/addExercise">

            </form> -->

            <a href="/template/quit">Quit</a>
        </div>
    </main>
</body>
</html>
