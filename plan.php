<?php
session_start();
// Include the database connection file
include 'db_connection.php';
// Check if the user is logged in
$isLoggedIn = false; // Set a default value
if (isset($_SESSION['username'])) {
    $isLoggedIn = true;


}
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>Well-being App | Plan</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
<link href="assets/vendor/aos/aos.css" rel="stylesheet">
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="assets/css/style.css" rel="stylesheet">
<style>
        #datePicker, #customerDropdown {
            margin-bottom: 20px;
        }

        #selectedValues {
            font-size: 18px;
            padding: 10px;
            border: 1px solid #ccc;
            display: inline-block;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* This ensures that the container takes at least the full height of the viewport. */
        }

        #footer {
            margin-top: auto; /* Pushes the footer to the bottom of the container. */
        }
</style>

<!-- =======================================================
* Template Name: Anyar
* Updated: Sep 18 2023 with Bootstrap v5.3.2
* Template URL: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
======================================================== -->
</head>

<body style="background-color: #1B72BD; min-height: 100vh;">

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

    <h1 class="logo"><a href="index.php">Well-being App</a></h1>
    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href=index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

    <nav id="navbar" class="navbar">
            <ul>
            <li><a class="nav-link scrollto" href="index.php">Home</a></li>
            <li><a class="nav-link scrollto " href="index.php #services">Services</a></li>
            <li><a class="nav-link active" href="plan.php">Plan</a></li>
            <li><a href="medication.php">Medication</a></li>
            <li><a href="biometrics.php">Biometrics</a></li>
            <li><a href="appointments.php">Appointments</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="plan.php?logout=true" class="nav-link">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="nav-link">Login</a></li>
                <li><a href="signup.php" class="nav-link">Signup</a></li>
            <?php endif; ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
            <!-- <li><a href="login.php">Log In</a></li>
            <li><a href="signup.php">Sign Up</a></li> -->
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<main id="main" style="padding-top: 100px; padding-bottom: 20px;"> <!-- Adjust the padding value as needed -->
    <?php if (!isset($_SESSION['username']) ): ?>
            <div class="section-title">
                <h2>You need to login to access this page </h2>
            </div>

    <?php elseif (isset($_SESSION['username']) ): ?>

    <?php if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee'): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <div class="signup-box">
                <form>
                    <div class="form-group">
                        <h4 style="color: #007bff;">Select a Date</h4>
                        <input type="date" class="form-control" id="datePicker">
                    </div>


                        <div class="form-group">
                        <h4 style="color: #007bff;">Select a Customer</h4>
                            <select class="form-control" id="customerDropdown"></select>
                        </div>

                        
                    <center>
                        <button type="button" class="btn btn-primary" onclick="storeAndPrintValues()">Search</button>
                    </center>
                </form>

                <br>
            </div>
            </div>
        </div>
    </div>
    <?php elseif (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer'): ?>

        <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <div class="signup-box">
                <form>
                    <div class="form-group">
                        <h4 style="color: #007bff;">Select a Date</h4>
                        <input type="date" class="form-control" id="datePicker">
                    </div>


                        <!-- <div class="form-group">
                        <h4 style="color: #007bff;">Select a Customer</h4>
                            <select class="form-control" id="customerDropdown"></select>
                        </div> -->

                        
                    <center>
                        <button type="button" class="btn btn-primary" onclick="storeAndPrintValues()">Search</button>
                    </center>
                </form>

                <br>
            </div>
            </div>
        </div>
    </div>
    <?php endif; ?> 

    <div class="container">
    <div class="container mt-5">
    <div class="row justify-content-center">
    <table class = "table table-bordered" id="displayDietPlanData">
    <thead>
        <tr>
        <th>Diet Plan Type</th>
        <th>Meal Name</th>
        <th>Meal Type</th>
        <th>Calories</th>
        <th>Proteins</th>
        <th>Carbs</th>
        <th>Fat</th>
        </tr>
    </thead>
    <tbody></tbody>
    </table>
    </div>
    </div>
    </div>

    <div class="container">
    <div class="container mt-5">
    <div class="row justify-content-center">
    <table class = "table table-bordered" id="displayActivityPlanData">
    <thead>
        <th>Activity Plan Type</th>
        <th>Activity Type</th>
        <th>Duration</th>
        </tr>
    </thead>
    <tbody></tbody>
    </table>
    </div>
    </div>
    </div>
    <?php if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee'): ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="signup-box">

                    <h4 style="color: #007bff;">Create Diet Plan</h4>
                    <form id="dietPlanForm" method="post" action="">

                    <!-- <div class="form-group">
                        <label for="customer_username" style="color: #333;">Customer:</label>
                        <input type="text" class="form-control" id="customer_username" name="customer_username" required>
                    </div> -->
                    <div class="form-group">
                        <label for="customer_username1" style="color: #333;">Customer:</label>
                        <select class="form-control" id="customer_username1" name="customer_username1" required>
                            <!-- Options will be dynamically populated here -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_date" style="color: #333;">Plan Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date" style="color: #333;">Plan End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <div class="form-group">
                        <label for="diet_plan_type" style="color: #333;">Diet Plan Type:</label>
                        <select class="form-control" id="diet_plan_type" name="diet_plan_type" required>
                        <option value="Ketogenic">Ketogenic</option>
                        <option value="Intermittent">Intermittent</option>
                        <option value="Plant-based">Plant-based</option>
                        <option value="Mediterranean">Mediterranean</option>
                        <option value="Vegan">Vegan</option>
                        <option value="Vegeterian">Vegeterian</option>
                        <option value="Pescetarian">Pescetarian</option>
                        </select>
                    </div>

                    <div class="form-group">
                    <label for="type" style="color: #333;">Meal Type:</label>
                        <select class="form-control" id="type" name="type" required>
                        <option value="Breakfast">Breakfast</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Tithe">Tithe</option>
                        <option value="Dinner">Dinner</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="meal_name" style="color: #333;">Meal Name:</label>
                        <input type="text" class="form-control" id="meal_name" name="meal_name" required>
                    </div>

                    <div class="form-group">
                        <label for="calories" style="color: #333;">Calories:</label>
                        <input type="text" class="form-control" id="calories" name="calories" required>
                    </div>

                    <div class="form-group">
                        <label for="proteins" style="color: #333;">Proteins:</label>
                        <input type="text" class="form-control" id="proteins" name="proteins" required>
                    </div>

                    <div class="form-group">
                        <label for="carbs" style="color: #333;">Carbs:</label>
                        <input type="text" class="form-control" id="carbs" name="carbs" required>
                    </div>

                    <div class="form-group">
                        <label for="fat" style="color: #333;">Fat:</label>
                        <input type="text" class="form-control" id="fat" name="fat" required>
                    </div>

                    <div class="form-group">
                        <label for="meal_date" style="color: #333;">Meal Date:</label>
                        <input type="date" class="form-control" id="meal_date" name="meal_date" required>
                    </div>

                    <center>
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Create Diet Plan</button>
                    </center>
                    </form>
                        </div>
                    </div>
                </div>
                </div>
                <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="signup-box">

                            <h4 style="color: #007bff;">Create Activity Plan</h4>
                            <form id="activityPlanForm" method="post" action="">

                            <div class="form-group">
                                <label for="customer_username2" style="color: #333;">Customer:</label>
                                <select class="form-control" id="customer_username2" name="customer_username2" required>
                                    <!-- Options will be dynamically populated here -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="start_date" style="color: #333;">Plan Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <div class="form-group">
                                <label for="end_date" style="color: #333;">Plan End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <div class="form-group">
                            <label for="activity_plan_type" style="color: #333;">Activity Plan Type:</label>
                                <select class="form-control" id="activity_plan_type" name="activity_plan_type" required>
                                <option value="Cardiovascular">Cardiovascular</option>
                                <option value="Strength">Strength</option>
                                <option value="Flexibility and Stretching">Flexibility and Stretching</option>
                                <option value="Balance and Coordination">Balance and Coordination</option>
                                <option value="High-Intensity Interval Training">High-Intensity Interval Training</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="activity_type" style="color: #333;">Activity Type:</label>
                                <input type="text" class="form-control" id="activity_type" name="activity_type" required>
                            </div>

                            <div class="form-group">
                                <label for="duration" style="color: #333;">Activity Duration (minutes):</label>
                                <input type="number" id="duration" name="duration" required>
                            </div>

                            <div class="form-group">
                                <label for="activity_date" style="color: #333;">Activity Date:</label>
                                <input type="date" class="form-control" id="activity_date" name="activity_date" required>
                            </div>

                            <center>
                                <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Create Activity Plan</button>
                            </center>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <?php endif; ?>
        <?php endif; ?> 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <!-- <div id="selectedValues">Selected Date: <span id="displayDate"></span>, Selected Customer: <span id="displayCustomer"></span></div> -->

    <script>
        // Function to update the selected date in the display box
        function updateSelectedDate() {
            var selectedDate = document.getElementById('datePicker').value;
        }

        // Function to populate the customer dropdown with values from MySQL
        function populateCustomerDropdown() {
            var customerDropdown = document.getElementById('customerDropdown');

            // Fetch customer_usernames from MySQL using PHP
            fetch('get_customer_usernames.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(customer => {
                        var option = document.createElement('option');
                        option.value = customer;
                        option.text = customer;
                        customerDropdown.add(option);
                    });
                });
        }

        // Function to handle button click and fetch/display data from the database
        function storeAndPrintValues() {
            var selectedDate = document.getElementById('datePicker').value;
            var selectedCustomer;

            <?php
            if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer') {                
                echo "selectedCustomer = '" . $_SESSION['username'] . "';";
            } else {
                echo "selectedCustomer = document.getElementById('customerDropdown').value;";
            }
            ?>
                console.log(selectedCustomer); // Log the entire data object to the console

            // Make an AJAX request to fetch data from the server
            fetch('fetch_plan.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'selectedDate=' + encodeURIComponent(selectedDate) +
                    '&selectedCustomer=' + encodeURIComponent(selectedCustomer),
            })
            .then(response => response.json())
            .then(data => {
                // Update the display element with the fetched data
                console.log(data); // Log the entire data object to the console
                fillTable(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        }

        function fillTable(data) {
            // Get the table body
            var tableBody = document.getElementById('displayDietPlanData').getElementsByTagName('tbody')[0];
            // Clear the existing rows in the table body
            tableBody.innerHTML = '';
            // Iterate through the mealName array to create rows in the HTML table
            for (var i = 0; i < data.mealName.length; i++) {
                // Create a new row
                var row = tableBody.insertRow(-1);

                // Insert cells in the row for each data attribute
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);

                // Fill cells with data from the data array
                cell1.innerHTML = data['dietPlanType'][i];
                cell2.innerHTML = data['mealName'][i];
                cell3.innerHTML = data['type'][i];
                cell4.innerHTML = data['calories'][i];
                cell5.innerHTML = data['proteins'][i];
                cell6.innerHTML = data['carbs'][i];
                cell7.innerHTML = data['fat'][i];
            }

            var tableBody = document.getElementById('displayActivityPlanData').getElementsByTagName('tbody')[0];
            // Clear the existing rows in the table body
            tableBody.innerHTML = '';
            // Display additional information (activity plan) outside the loop
            var additionalInfoRow = tableBody.insertRow(-1);
            var activityPlanCell = additionalInfoRow.insertCell(0);
            var activityTypeCell = additionalInfoRow.insertCell(1);
            var durationCell = additionalInfoRow.insertCell(2);

            activityPlanCell.innerHTML = data['activityPlanType'];
            activityTypeCell.innerHTML = data['activityType'];
            durationCell.innerHTML = data['duration'];

        }


        // Function to fetch and display data based on selected date and customer
        function fetchAndDisplayData() {
            var selectedDate = document.getElementById('datePicker').value;
            var selectedCustomer;

            <?php
            if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer') {
                echo "selectedCustomer = '" . $_SESSION['username'] . "';";
            } else {
                echo "selectedCustomer = document.getElementById('customerDropdown').value;";
            }
            ?>
                            console.log(selectedCustomer); // Log the entire data object to the console


            // Fetch and display data from the database
            fetch('fetch_plan.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    selectedDate: selectedDate,
                    selectedCustomer: selectedCustomer,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.mealName[0]); // Outputs: "Porridge"
                fillTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Attach functions to events
        document.getElementById('datePicker').addEventListener('change', updateSelectedDate);
        window.addEventListener('DOMContentLoaded', updateSelectedDate);

        // Attach functions to events
        document.getElementById('datePicker').addEventListener('change', updateSelectedDate);
        window.addEventListener('DOMContentLoaded', populateCustomerDropdown);
    </script>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
<div class="container text-center">
    <div class="copyright">
    &copy; Copyright <strong><span>Well-being App</span></strong>. All Rights Reserved
    </div>
    <div class="contact-info">
        <i class="bi bi-envelope-fill"></i><a href="mailto:info@wellbeing.com">info@wellbeing.com</a>
        <i class="bi bi-phone-fill phone-icon"></i> +1 5589 55488 55
    </div>
    <div class="credits">
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/ -->
    </div>
</div>
</footer><!-- End Footer -->


<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script>
    // JavaScript to handle form submission asynchronously
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("dietPlanForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission
            var formData = new FormData(this);

            // Use AJAX to submit the form data to the PHP script
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process_diet_plan.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Display the response from the server (e.g., success message)
                    console.log(xhr.responseText);
                }
            };
            xhr.send(formData);
            var form = document.getElementById("dietPlanForm");
            form.reset();

        });
    });
</script>
<script>
    // Fetch data from get_customer_usernames.php using JavaScript
    fetch('get_customer_usernames.php')
        .then(response => response.json())
        .then(data => {
            // Populate the dropdown options for Form 1
            const dropdown = document.getElementById('customer_username1');

            data.forEach(username => {
                const option = document.createElement('option');
                option.value = username;
                option.text = username;
                dropdown.add(option);
            });
        })
        .catch(error => console.error('Error fetching customer usernames for Form 1:', error));
</script>
<!-- JavaScript for Form 2 -->
<script>
    // Fetch data from get_customer_usernames.php using JavaScript
    fetch('get_customer_usernames.php')
        .then(response => response.json())
        .then(data => {
            // Populate the dropdown options for Form 2
            const dropdown = document.getElementById('customer_username2');

            data.forEach(username => {
                const option = document.createElement('option');
                option.value = username;
                option.text = username;
                dropdown.add(option);
            });
        })
        .catch(error => console.error('Error fetching customer usernames for Form 2:', error));
</script>
<script>
    // JavaScript to handle form submission asynchronously
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("activityPlanForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission
            var formData = new FormData(this);

            // Use AJAX to submit the form data to the PHP script
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process_activity_plan.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Display the response from the server (e.g., success message)
                    console.log(xhr.responseText);
                }
            };
            xhr.send(formData);
            var form = document.getElementById("activityPlanForm");
            form.reset();
        });
    });
</script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>