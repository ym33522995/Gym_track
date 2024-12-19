<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
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
        <h2>Create template Page</h2>
        <p>Please choose your exercise to create a template.</p>
        <form id="templateForm" action="/template/store" method="POST">
            @csrf
            <label for="template_name">Template Name:</label>
            <input type="text" id="template_name" name="template_name"><br><br>

            <h3>Select Exercise</h3>
            @foreach($exercises as $exercise)
                <div>
                    <label>
                        <input type="checkbox" name="exercises[{{ $exercise->id }}][selected]" value="1">
                        {{ $exercise->name }}
                    </label>
                    <input type="number" name="exercises[{{ $exercise->id }}][weight]" placeholder="Weight" step=0.5>
                    <input type="number" name="exercises[{{ $exercise->id }}][rep]" placeholder="Reps">
                    <input type="number" name="exercises[{{ $exercise->id }}][set]" placeholder="Sets">
                    <label for="additional_sets">Number of sets with different weight:</label>
                    <input type="number" class="additional_sets" data-exercise-id="{{ exercise->id }}" placeholder="0">
                    <div id="additional_set_fields_{{ $exercise->id }}"></div> 
                    <!-- 
                    The div is a placeholder for the inputs to appear when additional sets are entered.
                    -->
                </div>
            @endforeach

            <input type="submit" value="Done Selecting">
            
        </form>
    </main>

    
    <!-- <script src="{{ asset('resources/js/template.js') }}"></script> -->

    <script>
        $(document).on('input', '.additional_sets', function () {
            // .on() is a 
        })



    </script>
</body>
</html>
