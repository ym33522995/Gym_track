<x-app-layout :hideHeader="true">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Remove any default margin/padding */
        body, html {
            margin: 0;
            padding: 0;
        }

        /* Make sure header is fixed to the top */
        .custom-header {
            background-color: #52057B;
            position: fixed; /* Keep it at the top */
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: #FFFFFF;
        }

        /* Style navigation links */
        .custom-header nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
        }

        /* Fix dropdown menu positioning */
        /* Ensure dropdown stays positioned correctly */
        .nav-right {
            position: relative;
        }

        /* Fix dropdown visibility */
        #userDropdown {
            display: none; /* Initially hidden */
        }

        /* Ensure dropdown does not push other content */
        #userDropdown.active {
            display: block;
        }

        /* Dropdown positioning */
        .nav-right .dropdown-menu {
            position: absolute;
            right: 0; /* Align to the right */
            top: 100%; /* Position below the button */
            background: white;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            display: none; /* Hide by default */
            z-index: 1000; /* Ensure it appears above other elements */
        }

        /* Show dropdown when active */
        .nav-right .dropdown-menu.active {
            display: block;
        }


        /* Ensure page content starts below the fixed header */
        .main-content {
            padding-top: 70px;
        }
    </style>

    <x-slot name="header">
        <div class="custom-header">
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/template">Template</a></li>
                    <li><a href="/exercise">Exercise</a></li>
                    <li><a href="/report">Report</a></li>
                    <li><a href="/profile">Profile</a></li>
                </ul>
            </nav>
            <div class="nav-right relative">
                <button class="text-white font-semibold" onclick="toggleDropdown()">
                    {{ Auth::user()->name }} ▼
                </button>

                <!-- Correct Dropdown Menu -->
                <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg hidden">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100" 
                        onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </a>
                    </form>
                </div>
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

            // Toggle class to show or hide dropdown
            if (dropdown.classList.contains("hidden")) {
                dropdown.classList.remove("hidden");
                dropdown.classList.add("active");
            } else {
                dropdown.classList.add("hidden");
                dropdown.classList.remove("active");
            }
        }

        // Close dropdown if user clicks outside
        document.addEventListener("click", function (event) {
            var dropdown = document.getElementById("userDropdown");
            var button = document.querySelector(".nav-right button");

            if (dropdown && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
                dropdown.classList.remove("active");
            }
        });
    </script>


</x-app-layout>
