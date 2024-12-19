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
        <h2>Template Page</h2>
        <p>Please select your template.</p>
        <div>
            @foreach($templates as $template)
                <a href="/template/{{ $template->id }}">{{ $template->name }}</a>
                <form action="/template/delete/{{ $template->id }}" id="delete_{{ $template->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deletePost({{ $template->id }})">delete</button>
                </form>
            @endforeach

        </div>

        <a href="/template/create">+</a>
        

    </main>

    <!-- <script src="{{ asset('js/script.js') }}"></script> -->

    <script>
        function deletePost(templateId) {
            'use strict';

            if (confirm("Are you sure you want to delete this template?")) {
                document.getElementById(`delete_${templateId}`).submit();
            }
        }
    </script>

</body>
</html>
