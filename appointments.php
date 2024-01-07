<?php
session_start();
// Include the database connection file
include 'db_connection.php';



// Function to fetch data from the medication table
function fetchAppointmentsDataForCustomer($conn, $username) {
    $sql = "SELECT * FROM customer_meets_employee WHERE customer_username = ? AND appointment_date > NOW()";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result;
}
function fetchAppointmentsDataForEmployee($conn, $username) {
    $sql = "SELECT * FROM customer_meets_employee WHERE employee_username = ? AND customer_meets_employee.appointment_date > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result;
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

if (isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee') {
    $result = fetchAppointmentsDataForEmployee($conn, $_SESSION['username']);
} elseif (isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer') {
    $result = fetchAppointmentsDataForCustomer($conn, $_SESSION['username']);
}


// Adding a new appointment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $customer_username = $_POST["customer_username"];
    $employee_username = $_SESSION["username"];
    $appointment_type = $_POST["appointment_type"];
    $appointment_date = $_POST["appointment_date"];
    
    // Prepare SQL statement to insert appointment data into the database
    $insert_sql = "INSERT INTO customer_meets_employee (customer_username, employee_username, appointment_date, appointment_type)
                   VALUES (?, ?, ?, ?)";
    
    // Create a prepared statement
    $stmt = $conn->prepare($insert_sql);

    if ($stmt) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssss", $customer_username, $employee_username, $appointment_date, $appointment_type);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            // Appointment added successfully, redirect to the same page
            header("Location: appointments.php");
            exit();
        } else {
            // Error in execution
            echo "Error adding appointment: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        echo "Error in prepared statement: " . $conn->error;
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Well-being App | Appointments</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <style>
    #header1{
        background: rgba(5, 87 , 158, 0.9);
        height: 60px;
    }

    #header1 .logo1 a{
        color: white;
    }

    #header1 .logo1{
        font-size: 30px;
        margin: 0;
        padding: 0;
        line-height: 1;
        font-weight: 400;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
  </style>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

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
  <header id="header1" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo1"><a href="index.php">Well-being App</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <li><a  href="#services">Services</a></li>
          <li class="dropdown"><a href="#"><span>Plan</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Activity Plan</a></li>
              <li><a href="#">Diet Plan</a></li>
            </ul>
          </li>
          <li><a href="medication.php">Medication</a></li>
          <li><a href="biometrics.php">Biometrics</a></li>
          <li><a class="nav-link active" href="appointments.php">Appointments</a></li>
          <li><a href="index.php">Logout</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->  

  <main id="main" style="padding-top: 100px; padding-bottom: 20px;"> <!-- Adjust the padding value as needed -->
        <div style="height: 10000px;">
        <div class="container">
        <div class="container mt-5">
        <div class="row justify-content-center">

            
        <?php if (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'employee'): ?>
            
            <div class="section-title">
                <h2>My Appointments </h2>
            </div>
            <table class="table table-bordered">

                <thead>
                <tr>
                    <th>Customer Username</th> 
                    <th>Appointment Type</th>
                    <th>Appointment Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /// Display data in the table
                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["customer_username"] . "</td>
                        <td>" . $row["appointment_type"] . "</td>
                        <td>" . $row["appointment_date"] . "</td>
                    </tr>";  
                }
                } else {
                    echo "<tr><td colspan='3'>No data found</td></tr>";
                }
                ?>
                </tbody>
            </table>

            <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="signup-box">
            <h4 style="color: #007bff;">Add Appointment</h4>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class="form-group">
                        <label for="customer_username" style="color: #333;">Customer Username:</label>
                        <input type="text" class="form-control" id="customer_username" name="customer_username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="appointment_type" style="color: #333;">Appointment Type:</label>
                        <input type="text" class="form-control" id="appointment_type" name="appointment_type" required>
                    </div>

                    <div class="form-group">
                        <label for="appointment_date" style="color: #333;">Appointment Date:</label>
                        <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
                    </div>

                    <center>
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Add Appointment</button>
                    </center>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
            
        <?php elseif (isset($_SESSION['username']) && isset($_SESSION['login_type']) && $_SESSION['login_type'] === 'customer'): ?>

            
            <div class="section-title">
                <h2>My Appointments</h2>
            </div>
            <table class="table table-bordered">
            <thead>
            <tr>
                <th>Employee Username</th> 
                <th>Appointment Type</th>
                <th>Appointment Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /// Display data in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["employee_username"] . "</td>
                        <td>" . $row["appointment_type"] . "</td>
                        <td>" . $row["appointment_date"] . "</td>
                    </tr>";  
                }
            } else {
                echo "<tr><td colspan='3'>No data found</td></tr>";
            }
            ?>
            </tbody>
        </table>
                    
        <?php endif; ?>
        </div>
        </div>

        </div>

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



















