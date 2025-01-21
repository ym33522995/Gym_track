<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>

    <!-- Bootstrap 5 CSS (for the modal) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart.js date-fns adapter (to parse dates for the time axis) -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling for the header section */
        .header-section {
            text-align: left;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 24px; /* Make it bold and large */
            font-weight: bold;
        }

        .page-description {
            font-size: 16px;
            margin-top: 10px;
        }

        /* Maintain layout for the main content */
        .container-main {
            display: flex;
        }

        .left-side {
            width: 50%;
            padding: 20px;
        }

        .right-side {
            width: 50%;
            padding: 20px;
            border-left: 1px solid #ccc;
        }

        .navigation-buttons {
            margin-top: 10px;
        }
    </style>
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
        <div class="header-section">
            <h2 class="page-title">Welcome to Your Home Page</h2>
            <p class="page-description">Below is your body weight chart. You can enter or update today's weight, or choose any date.</p>
        </div>

        <div class="container-main">
            <div class="left-side">
                <div id='calendar'></div>
            </div>

            <div class="right-side">
                <!-- Button to open modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#weightModal">
                    Enter / Update Weight
                </button>
                <canvas id="myWeightChart" width="400" height="300"></canvas>
                
                <!-- Navigation Buttons for chart pagination -->
                <div class="navigation-buttons">
                    <button id="prevBtn" class="btn btn-secondary">&lt; Prev 2 Weeks</button>
                    <button id="nextBtn" class="btn btn-secondary">Next 2 Weeks &gt;</button>
                </div>

                <div class="total-weights"></div>
            </div>
        </div>
    </main>

    <!-- Modal for entering weight & date -->
    <div class="modal fade" id="weightModal" tabindex="-1" aria-labelledby="weightModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="weightModalLabel">Enter / Update Your Weight</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <!-- We'll POST via AJAX, no direct form submission -->
            @csrf  <!-- We’ll grab this token for AJAX header -->
            <div class="mb-3">
                <label for="weightInput" class="form-label">Weight (kg)</label>
                <input type="number" step="0.1" class="form-control" id="weightInput" name="weight" required>
            </div>
            <div class="mb-3">
                <label for="dateInput" class="form-label">Date</label>
                <input type="date" class="form-control" id="dateInput" name="date">
                <div class="form-text">If you leave this blank, it will default to today's date.</div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveWeightBtn">Save</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Bootstrap 5 JS (bundle) for the modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let myChart = null;
        // We'll store global startDate & endDate for pagination
        let currentStartDate = null;
        let currentEndDate = null;

        document.addEventListener('DOMContentLoaded', () => {
            // Initially load the last 4 weeks
            currentEndDate = new Date();
            currentStartDate = new Date();
            currentStartDate.setDate(currentStartDate.getDate() - 28); // 4 weeks

            // Fetch data once page loads
            fetchChartData();

            // Button to save weight
            document.getElementById('saveWeightBtn').addEventListener('click', () => {
                saveWeight();
            });

            // Prev / Next
            document.getElementById('prevBtn').addEventListener('click', () => {
                shiftDateRange(-1); // go 4 weeks earlier
            });
            document.getElementById('nextBtn').addEventListener('click', () => {
                shiftDateRange(1);  // go 4 weeks forward
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            axios.get('/total-weight')
                .then(response => {
                    const totalWeight = response.data;
                    const totalWeightDiv = document.querySelector(".total-weights");
                    totalWeightDiv.innerHTML = `<p>Here is the total weight you have lifted so far: <strong>${totalWeight} kg</strong></p>`;
                })
                .catch(error => {
                    console.error('Error fetching total weight:', error);
                    document.getElementById('totalWeight').textContent = 'Error loading total weight.';
                });
        });

        // AJAX to store the new weight & date
        function saveWeight() {
            const weightValue = document.getElementById('weightInput').value;
            const dateValue   = document.getElementById('dateInput').value;

            const csrfToken   = document.querySelector('input[name="_token"]').value;
            const payload = {
                weight: weightValue,
            };

            if (dateValue) {
                payload.date = dateValue;
            }

            // IMPORTANT: Use the path /home/body-weights
            fetch("/home/body-weights", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('weightModal'));
                    modal.hide();

                    // Clear the fields
                    document.getElementById('weightInput').value = '';
                    document.getElementById('dateInput').value   = '';

                    // Refresh chart data
                    fetchChartData();
                } else {
                    alert("Error saving weight. Please try again.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Something went wrong. Please try again.");
            });
        }

        // Retrieve chart data from server
        function fetchChartData() {
            // Convert Date objects to YYYY-MM-DD
            // currentStartDate.setDate(currentStartDate.getDate() - 28); // 4 weeks
            const startDateStr = currentStartDate.toISOString().split('T')[0];
            const endDateStr   = currentEndDate.toISOString().split('T')[0];

            // Use the path /home/body-weights/date
            // let url = "/home/body-weights/date";
            // url += `?startDate=${startDateStr}&endDate=${endDateStr}`;

            let url = `/home/body-weights/date?startDate=${startDateStr}&endDate=${endDateStr}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    // Build an array of { x: dateString, y: weightNumber }
                    const chartData = data.map(item => ({
                        x: item.date,   
                        y: item.weight  
                    }));

                    // If a chart instance exists, destroy it first
                    if (myChart) {
                        myChart.destroy();
                    }

                    // Create new Chart
                    const ctx = document.getElementById('myWeightChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            datasets: [{
                                label: 'Body Weight (kg)',
                                data: chartData,
                                borderColor: 'blue',
                                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                                fill: true,
                                tension: 0.1,
                                pointRadius: 5,
                                spanGaps: true
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    // Make the x-axis time-based
                                    type: 'time',
                                    time: {
                                        unit: 'day',
                                        displayFormats: {
                                            day: 'MMM d'
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: false // dynamic y-axis
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                })
                .catch(err => {
                    console.error("Error fetching chart data:", err);
                });
        }

        function shiftDateRange(direction) {
            // currentStartDate.setDate(currentStartDate.getDate() + (direction * 14));
            // currentEndDate.setDate(currentEndDate.getDate() + (direction * 14));
            // fetchChartData();

            const newEnd = new Date(currentEndDate.getTime() + (direction * 14 * 24 * 60 * 60 * 1000));
    
            // Then recalc START = newEnd - 28 days
            const newStart = new Date(newEnd.getTime() - (28 * 24 * 60 * 60 * 1000));

            currentStartDate = newStart;
            currentEndDate   = newEnd;

            fetchChartData();
        }
    </script>
</body>
</html>
