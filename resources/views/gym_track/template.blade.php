<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Template Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->


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

        h2 {
            text-align: left;
            margin-top: 20px;
        }

        .template-wrapper {
            position: relative;
            width: 100%;
        }

        /* Main container with horizontal scroll */
        .template-container {
            display: flex;
            gap: 20px; /* Space between cards */
            overflow-x: auto; /* Enable horizontal scrolling */
            padding: 20px;
            scroll-behavior: smooth; /* Smooth scrolling */
            white-space: nowrap;
            position: relative;
        }

        .template-item {
            min-width: 250px; 
            height: 300px;
            background-color: #FFFFFF; 
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .template-item:hover {
            transform: scale(1.10);
            background-color: #BC6FF1;
        }


        .template-item a.exercise-title {
            font-size: 30px;
            font-weight: bold;
            color: #000000;
            text-decoration: none;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }
 
        .template-item button:hover {
            background-color: #892CDC; 
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .scroll-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.7);
            color: #000000;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 24px;
            cursor: pointer;
            display: none;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .scroll-button-left {
            left: 10px;
        }

        .scroll-button-right {
            right: 10px;
        }

        .scroll-button:hover {
            background-color: #BC6FF1;
        }

        .create-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #FFFFFF;
            border: none;
            text-align: center;
            font-weight: bold;
            font-size: 30px;
            cursor: pointer;
            text-decoration: none;
            background-color: #52057B;
            border-radius: 50%; /* Make it circular */
            width: 50px; /* Width of the button */
            height: 50px; /* Height of the button */
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .create-button:hover {
            background-color: #BC6FF1;
        }

        /* Hide scrollbar but allow scroll */
        .template-container::-webkit-scrollbar {
            display: none;
        }

        .template-container {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;    /* Firefox */
        }

        .template-logo {
            max-width: 90%; /* Adjust the width based on your layout */
            max-height: 200px; /* Prevent the logo from being too tall */
            margin: 0 auto 10px auto; /* Center it and add spacing below */
            display: block; /* Ensure the image is centered */
            object-fit: contain; /* Maintain the aspect ratio */
        }

        .action-button {
            background-color: #52057B;
            color: #FFFFFF;
            border: none;
            border-radius: 5px;
            padding: 10px 16px; /* Adjusts the internal spacing around the button's content */
            font-size: 14px; /* Font size */
            letter-spacing: 0px; /* Adjust the spacing between letters */
            white-space: nowrap;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: inline-block; /* Ensure the same look for <a> and <button> */
            box-sizing: border-box; /* Include padding and border in size */
            
        }

        .action-button:hover {
            background-color: #892CDC;
            color: #000000;
        }

        /* Group styling for consistent spacing */
        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }


        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place and center on the screen */
            z-index: 1000; /* Higher than other elements */
            left: 50%; /* Center horizontally */
            top: 50%; /* Center vertically */
            transform: translate(-50%, -50%); /* Offset to center */
            width: 100%; /* Full width for background overlay */
            height: 100%; /* Full height for background overlay */
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent black overlay */
        }

        .modal-content {
            background-color: #52057B; /* Modal background color */
            color: #FFFFFF; /* Text color */
            margin: 10% auto; /* Centered on the screen */
            padding: 20px;
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7); /* Shadow for a floating effect */
            width: 50%; /* Adjust width for better visibility */
        }

        .close {
            color: #BC6FF1; /* Close button color */
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #FFFFFF; /* Hover and focus color for close button */
            text-decoration: none;
        }

        .modal h2 {
            color: #FFFFFF; /* Header text color */
            margin-bottom: 15px;
            font-size: 24px;
            text-align: center;
        }

        .modal form label {
            color: #FFFFFF; /* Label color */
            font-weight: bold;
        }

        .modal form input[type="text"] {
            background-color: #892CDC; /* Input background */
            color: #FFFFFF; /* Input text color */
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        .modal form input[type="text"]:focus {
            outline: none;
            border: 2px solid #BC6FF1; /* Focus border color */
        }

        .modal form button {
            background-color: #892CDC; /* Button background */
            color: #FFFFFF; /* Button text color */
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }

        .modal form button:hover {
            background-color: #BC6FF1; /* Hover background color */
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
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main>
        <h2>Template Page</h2>
        <p>Please select your template.</p>
        <div class="template-wrapper">
            <button id="scrollLeft" class="scroll-button scroll-button-left">&lt;</button>
            <div class="template-container" id="template-container">
                @foreach($templates as $template)
                    <div class="template-item">
                        <a href="/template/{{ $template->id }}" class="exercise-title">{{ $template->name }}</a>
                        <img src="{{ asset('workout_image.png') }}" alt="Template Logo" class="template-logo">
                        <div class="button-group">
                            <a href="template/edit/{{ $template->id }}" class="action-button">Edit Template</a>
                            <button type="button" class="action-button" onclick="editName({{ $template->id }}, '{{ $template->name }}')">Edit Name</button>
                            <form action="/template/delete/{{ $template->id }}" id="delete_{{ $template->id }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-button" onclick="deletePost({{ $template->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        <button id="scrollRight" class="scroll-button scroll-button-right">&gt;</button>
        </div>
    </main>


        <div id="editNameModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Edit Template Name</h2>
                <form id="editNameForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="template_id" id="template_id">
                    <label for="newName">New Name:</label>
                    <input type="text" id="newName" name="new_name" required>
                    <br><br>
                    <button type="button" onclick="submitEditName()">OK</button>
                    <button type="button" onclick="closeModal()">Cancel</button>
                </form>
            </div>
        </div>

        <a href="/template/create" class="create-button">+</a>
        

    <!-- <script src="{{ asset('js/script.js') }}"></script> -->

    <script>
        function deletePost(templateId) {
            'use strict';

            if (confirm("Are you sure you want to delete this template?")) {
                document.getElementById(`delete_${templateId}`).submit();
            }
        }

        function editName(templateId, currentName) {
            document.getElementById('template_id').value = templateId;
            document.getElementById('newName').value = currentName;
            document.getElementById('editNameModal').style.display = 'block';
        }

        function editTemplate() {
            document.getElementById('template_id').value = templateId;
        }

        function closeModal() {
            document.getElementById('editNameModal').style.display = 'none';
        }

        function submitEditName() {
            const form = document.getElementById('editNameForm');
            const templateId = document.getElementById('template_id').value;

            form.action = `/template/editName/${templateId}`;
            form.submit();
        }

        const container = document.getElementById('template-container');
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');

        function updateScrollButtons() {
            scrollLeftBtn.style.display = container.scrollLeft > 0 ? 'flex' : 'none';
            scrollRightBtn.style.display = container.scrollLeft < (container.scrollWidth - container.clientWidth) ? 'flex' : 'none';
        }

        scrollLeftBtn.addEventListener('click', () => {
            container.scrollBy({ left: -300, behavior: 'smooth' });
            setTimeout(updateScrollButtons, 500);
        });

        scrollRightBtn.addEventListener('click', () => {
            container.scrollBy({ left: 300, behavior: 'smooth' });
            setTimeout(updateScrollButtons, 500);
        });

        container.addEventListener('scroll', updateScrollButtons);

        // Initial check on page load
        document.addEventListener('DOMContentLoaded', updateScrollButtons);


        document.addEventListener("DOMContentLoaded", function () {
            const templateItems = document.querySelectorAll(".template-item");

            templateItems.forEach(item => {
                item.addEventListener("click", function (event) {
                    // Prevent redirection when clicking on buttons or form elements
                    if (!event.target.matches("button, .action-button, form, i")) {
                        const templateLink = this.querySelector(".exercise-title").href;
                        window.location.href = templateLink;
                    }
                });
            });
        });

    </script>

</body>
</html>
