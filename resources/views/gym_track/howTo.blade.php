<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
    <style>
        /* ====== Global Styles ====== */
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

        /* ====== Page Titles & Text ====== */
        h2 {
            text-align: left;
            margin-top: 20px;
        }

        .explain-container img{
            max-width: 60%;
            display: block; /* Ensures proper spacing */
            margin: 10px auto 100px; 
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
    <!-- Header Section -->
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

    <!-- Main Content Section -->
    <main>
        <h2>How to page.</h2>
        <p>The pages below shows you how to use this app.</p>

        <div class="explain-container">
            <div class="home-explain">
                <img src="{{ asset('calendar-explain.png') }}" alt="calendar-explain">
                <img src="{{ asset('right-side.png') }}" alt="right-side-explain">
            </div>
            <div class="template-explain">
                <img src="{{ asset('template-explain.png') }}" alt="template-explain">
                <img src="{{ asset('template-explain2.png') }}" alt="workout-explain2">
                <p>There will be an page like this after clicking + button in the template page.</p>
                <img src="{{ asset('createT1.png') }}" alt="create template explain">
                <img src="{{ asset('createT2.png') }}" alt="create template explain">
                <img src="{{ asset('workout.png') }}" alt="workout-explain">
                <img src="{{ asset('edit-template.png') }}" alt="edit-template">
            </div>
            <div class="exercise-explain">
                <img src="{{ asset('exercise.png') }}" alt="exercise-explain">
            </div>
            <div class="report-explain">
                <img src="{{ asset('report.png') }}" alt="report-explain">
            </div>
            <div class="profile-explain">
                <img src="{{ asset('profile-explain.png') }}" alt="profile-explain">
            </div>
        </div>
    </main>
</body>
</html>
