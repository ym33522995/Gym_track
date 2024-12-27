<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exercises</title>
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
        <h2>Select Exercises to Add</h2>
        <h2>You are now using template {{ $template->name }}</h2>
        <form action="/workout/{{ $template->id }}/saveExercise" method="POST">
            @csrf
            @foreach($exercises as $exercise)
                <div>
                    <label>
                        <input type="checkbox" name="exercises[{{ $exercise->id }}][selected]" value="1">
                        {{ $exercise->name }}
                    </label>
                    <input type="number" name="exercises[{{ $exercise->id }}][weight]" placeholder="Weight" step="0.5">
                    <input type="number" name="exercises[{{ $exercise->id }}][rep]" placeholder="Reps">
                    <input type="number" name="exercises[{{ $exercise->id }}][set]" placeholder="Sets">
                </div>
            @endforeach
            <button type="submit">Add exercise(s) to the menu</button>
        </form>
    </main>
</body>
</html>
