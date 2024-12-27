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
                    <input type="number" class="additional_sets" data-exercise-id="{{ $exercise->id }}" placeholder="0">
                    <div id="additional_set_fields_{{ $exercise->id }}"></div> 
                    <!-- 
                    The div is a placeholder for the inputs to appear when additional sets are entered.
                    -->
                </div>
            @endforeach

            <input type="submit" value="Done Selecting">
            <a href="/workout/addExercise" class="addExButton">+</a>

            
        </form> 
    </main>

    
    <!-- <script src="{{ asset('resources/js/template.js') }}"></script> -->

    <script>
        $(document).on('input', '.additional_sets', function () {
            // .on() is a method used to attach one or multiple event handlers to selected elements.
            // It can be called on static selections or dynamically on elements added after the initial document load.
            // 'input' is the event being listened for.
            // .additional_sets is the target elements on which the event listener will act. 
            // . in front of additional_sets is a CSS selector that specifies that the javascript should target element with the class attribute.
            const exerciseId = $(this).data('exercise-id');
            const numberOfSets = $(this).val();
            const additionalFieldsContainer = $(`#additional_set_fields_${exerciseId}`);
            additionalFieldsContainer.empty();

            if (numberOfSets > 0) {
                for (let i = 1; i <= numberOfSets; i++) {
                    additionalFieldsContainer.append(`
                        <div>
                            <label>Set ${i} - Weight:</label>
                            <input type="number" name="exercises[${exerciseId}][additional_sets][${i}][weight]" placeholder="Weight" step="0.5">
                            <label>Reps:</label>
                            <input type="number" name="exercises[${exerciseId}][additional_sets][${i}][rep]" placeholder="Reps">
                            <label>Sets:</label>
                            <input type="number" name="exercises[${exerciseId}][additional_sets][${i}][set]" placeholder="Sets">
                        </div>
                    `);
                }
            }
        
        
        });



    </script>
</body>
</html>
