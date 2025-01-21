<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
    <style>
        .template-item {
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align all items to the left */
            margin-bottom: 10px; /* Add spacing between rows */
        }

        .template-item span {
            margin-right: 10px;
            margin-left: 10px;
            font-weight: bold; /* Make the template name stand out */
        }

        .template-item form {
            display: inline; /* Prevent the form from breaking the line */
            margin-right: 10px; /* Add spacing between the buttons */
            margin-left: 10px
        }

        .template-item button {
            margin-right: 5px; /* Space between buttons */
        }



        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                <div class="template-item">
                    <a href="/template/{{ $template->id }}">{{ $template->name }}</a>
                    <form action="/template/delete/{{ $template->id }}" id="delete_{{ $template->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $template->id }})">delete</button>
                    </form>
                    <button type="button" onclick="editName({{ $template->id }}, '{{ $template->name }}')">Edit Name</button>
                    <a href="template/edit/{{ $template->id }}">Edit Template</a>
                </div>
            @endforeach
        </div>

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
    </script>

</body>
</html>
