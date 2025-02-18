<x-app-layout :hideHeader="true">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Remove any default margin/padding */
        /* Remove unwanted gray background and spacing */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #FFFFFF; /* Ensure full white background */
        }

        /* Remove Tailwind's default padding from the main layout */
        [x-app-layout] > div {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }


        /* Make sure header is fixed to the top */
        .custom-header {
            background-color: #52057B;
            position: fixed;
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
            font-family: Arial, sans-serif;  /* Match header font */
            font-size: 16px; /* Adjust to match */
        }


        /* Style navigation links */
        .custom-header nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            font-weight: bold;
            font-family: Arial, sans-serif;  /* Match header font */
            font-size: 16px;  /* Adjust to match */
            color: #FFFFFF; /* Ensure text color matches */
        }

        .custom-header nav ul li a:hover {
            text-decoration: underline;
        }

        .app-logo {
            height: 80%; /* Scale dynamically based on the header height */
            max-height: 50px; /* Prevent it from becoming too large */
            width: auto; /* Maintain aspect ratio */
            margin-right: 10px;
        }

        /* Fix dropdown menu positioning */
        /* Ensure dropdown stays positioned correctly */
        .nav-right {
            position: relative;
        }

        /* Show dropdown when active */
        .nav-right .dropdown-menu.active {
            display: block;
        }


        /* Ensure page content starts below the fixed header */
        .main-content {
            padding-top: 70px;
        }


        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #ccc;
            padding: 5px 10px;  /* Smaller padding */
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
            width: 120px; /* Reduce width */
            text-align: center; /* Center the text */
        }

        .dropdown-menu a {
            display: block;
            padding: 5px; /* Reduce padding */
            color: black;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #f2f2f2;
        }

    </style>

    <x-slot name="header">
        <div class="custom-header">
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
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </x-slot>

    <div class="main-content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("userDropdown");

            // Check if dropdown is currently hidden, then show/hide accordingly
            if (dropdown.classList.contains("hidden")) {
                dropdown.classList.remove("hidden");
            } else {
                dropdown.classList.add("hidden");
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            var dropdown = document.getElementById("userDropdown");
            var button = document.querySelector(".nav-right button");

            if (dropdown && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });

    </script>


</x-app-layout>
