<?php
session_start();
// Include the database connection file
include 'db_connection.php';



// Function to fetch data from the biometrics table
function fetchBiometricsData($conn, $username) {
    $sql = "SELECT * FROM biometrics WHERE customer_username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result;
}

function fetchAllBiometricsData($conn) {
    $sql = "SELECT * FROM biometrics";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer'){
        $username = $_SESSION['username'];
        $height = $_POST["height"];
        $weight = $_POST["weight"];
        $body_fat_percentage = $_POST["body_fat_percentage"];
        $muscle_percentage = $_POST["muscle_percentage"];
        $bone_percentage = $_POST["bone_percentage"];
        $fluid_percentage = $_POST["fluid_percentage"];
        $measurement_date = date("Y-m-d");
    }

    // Insert data into the biometrics table
    $insert_sql = "INSERT INTO biometrics (customer_username, measurement_date, weight, height, body_fat_percentage, muscle_percentage, fluid_percentage, bone_percentage)
                   VALUES ('$username', '$measurement_date', '$weight', '$height', '$body_fat_percentage', $muscle_percentage, $fluid_percentage, $bone_percentage)";
    
    if ($conn->query($insert_sql) === TRUE) {
        if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer'){
             // Fetch updated data after insertion
            $result = fetchBiometricsData($conn, $username);
        }
        elseif (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee'){
            // Fetch updated data after insertion
            $result = fetchAllBiometricsData($conn, $username);
        }
    } 
} else {
    // Fetch data initially
    if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer'){
        // Fetch updated data after insertion
        
        $username= $_SESSION['username'];
        $result = fetchBiometricsData($conn, $username);
   }
   elseif (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee'){
       // Fetch updated data after insertion
    //    $result = fetchAllMedicationData($conn, $username);
       if (isset($_GET['search']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee') {
            $search = $_GET['search'];
            $sql = "SELECT * FROM biometrics WHERE customer_username LIKE '%$search%'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
        } 
   }
}

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



function fetchAllCustomerUsernames($conn) {
    $usernames = array();

    $sql = "SELECT DISTINCT customer_username FROM medication"; // Change 'medication' to your actual table name
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usernames[] = $row['customer_username'];
        }
    }

    return $usernames;
}

if (isset($_GET['customer_username']) && $_SESSION['login_type'] === 'employee') {
    $selectedCustomer = $_GET['customer_username'];

    // Fetch data based on the selected customer username
    $sql = "SELECT * FROM biometrics WHERE customer_username LIKE '%$selectedCustomer%'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default behavior - fetch all data
    if ($_SESSION['login_type'] === 'employee') {
        // Fetch all medication data for employees
        $result = fetchAllBiometricsData($conn);
    }
}




?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Well-being App | Biometrics</title>

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

    <!-- =======================================================
    * Template Name: Anyar
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex: 1;
    } 

    /* Adjustments for your footer */
    #footer {
      position: sticky;
    }
    </style>
    </head>

    <body style="background-color: #1B72BD; min-height: 100vh;">

        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="index.php">Well-being App</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href=index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar">
            <ul>
            <li><a class="nav-link scrollto" href="index.php">Home</a></li>
            <li><a class="nav-link scrollto " href="index.php #services">Services</a></li>
            <li class="dropdown"><a href="#"><span>Plan</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                <li><a href="#">Activity Plan</a></li>
                <li><a href="#">Diet Plan</a></li>
                </ul>
            </li>
            <li><a class="nav-link " href="medication.php">Medication</a></li>
            <li><a class="nav-link active href="biometrics.php">Biometrics</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="medication.php?logout=true" class="nav-link">Logout</a></li>
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
        <!-- <div style="height: 10000px;"> -->
        <div class="container">
        <div class="container mt-5">
        <div class="row justify-content-center">



        <?php if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee'): ?>
            <div class="container mt-3 mb-3">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="search-box">
                            <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="input-group mb-3">
                                    <select class="form-select" name="customer_username">
                                    <option value="">Select a customer username</option>
                                        <!-- Populate the options dynamically based on available customer usernames -->
                                        <?php
                                        // Fetch customer usernames from the database and populate the dropdown options
                                        $customerUsernames = fetchAllCustomerUsernames($conn); // Using the function from db_connection.php
                                        foreach ($customerUsernames as $customerUsername) {
                                            echo "<option value='" . $customerUsername . "'>" . $customerUsername . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit" style="color: white; background-color: gray; border-color: white;">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>




        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Customer Username</th> 
                <th>Height [m]</th>
                <th>Weight [Kg]</th>
                <th>Body Fat [%]</th>
                <th>Muscle [%]</th>
                <th>Fluid [%]</th>
                <th>Bone [%]</th>
                <th>Date</th>

            </tr>
            </thead>
            <tbody>
            <?php

            // Display data in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                // echo "<tr><td>" . $row["customer_username"] . "</td><td>" . $row["height"] . "</td><td>" . $row["weight"] . "</td><td>" . $row["body_fat_percentage"] . "</td><td>" . $row["fluid_percentage"] . "</td><td>" . $row["bone_percentage"] . "</td><td>" . $row["measurement_date"] "</td></tr>";
                echo "<tr><td>" . $row["customer_username"] . "</td><td>" . $row["height"] . "</td><td>" . $row["weight"] . "</td><td>" . $row["body_fat_percentage"] . "</td><td>". $row["muscle_percentage"] . "</td><td>" . $row["fluid_percentage"] . "</td><td>" . $row["bone_percentage"] . "</td><td>" . $row["measurement_date"] . "</td></tr>";


            }
            } else {
                echo "<tr><td colspan='8'>No data found</td></tr>";
            }
            ?>
            </tbody>
        </table>
        </div>
        </div>

        <?php if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer'): ?>
        <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="signup-box">

                    <h4 style="color: #007bff;">Add Measurement</h4>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    
                    <div class="form-group">
                        <label for="height" style="color: #333;">Height:</label>
                        <input type="text" class="form-control" id="height" name="height" required>
                    </div>

                    <div class="form-group">
                        <label for="weight" style="color: #333;">Weight:</label>
                        <input type="text" class="form-control" id="weight" name="weight" required>
                    </div>

                    <div class="form-group">
                        <label for="body_fat_percentage" style="color: #333;">Body Fat:</label>
                        <input type="text" class="form-control" id="body_fat_percentage" name="body_fat_percentage" required>
                    </div>

                    <div class="form-group">
                        <label for="muscle_percentage" style="color: #333;">Muscle:</label>
                        <input  type="text" class="form-control" id="muscle_percentage" name="muscle_percentage" required>
                    </div>

                    <div class="form-group">
                        <label for="fluid_percentage" style="color: #333;">Fluid:</label>
                        <input  type="text" class="form-control" id="fluid_percentage" name="fluid_percentage" required>
                    </div>
                    <div class="form-group">
                        <label for="bone_percentage" style="color: #333;">Bone:</label>
                        <input  type="text" class="form-control" id="bone_percentage" name="bone_percentage" required>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Add Measurement</button>
                    </center>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <?php endif; ?> 

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

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>

    </body>

    </html>