<?php
session_start();
// Include the database connection file
include 'db_connection.php';

// Function to fetch data from the biometrics table for a specific user
function fetchBiometricsDataForUser($conn, $username) {
    $sql = "SELECT * FROM biometrics WHERE customer_username = '$username'";
    $result = $conn->query($sql);
    return $result;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $body_fat_percentage = $_POST["body_fat_percentage"];
    $muscle_percentage = $_POST["muscle_percentage"];
    $fluid_percentage = $_POST["fluid_percentage"];
    $bone_percentage = $_POST["bone_percentage"];
    $measurement_date = $_POST["measurement_date"];
    $customer_username = $_POST["customer_username"];

    // Insert data into the medication table
    $insert_sql = "INSERT INTO biometrics ( weight, height, body_fat_percentage, muscle_percentage, fluid_percentage,bone_percentage,measurement_date,customer_username)
                   VALUES ('$weight', '$height', '$body_fat_percentage', '$muscle_percentage', '$fluid_percentage','$bone_percentage','$measurement_date','$customer_username')";
    if ($conn->query($insert_sql) === TRUE) {
        // Fetch updated data after insertion
        $result = fetchBiometricsDataForUser($conn,$username);
    } 
} else {
    // Fetch data for a specific user (replace 'sample_user' with the actual username)
    $username = 'paris2';
    $result = fetchBiometricsDataForUser($conn, $username);
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

  <title>Well-being App</title>
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
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href=index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

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
          <li><a class="nav-link active" href="biometrics.php">Biometrics</a></li>
          <?php if (isset($_SESSION['username'])): ?>
                <li><a href="index.php?logout=true" class="nav-link">Logout</a></li>
          <?php else: ?>
                <li><a href="login.php" class="nav-link">Login</a></li>
                <li><a href="signup.php" class="nav-link">Signup</a></li>
          <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->  

  <main id="main">


    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Biometrics</h2>
        </div>

            <table class="table table-bordered">
            <thead>
            <tr>
                <th>Customer Username</th>
                <th>Weight</th> 
                <th>Height</th>
                <th>Body Fat Percentage</th>
                <th>Muscle Percentage</th>
                <th>Fluid Percentage</th>
                <th>Bone Percentage</th>
                <th>Measurement Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Display data in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["customer_username"] . "</td>
                        <td>" . $row["weight"] . "</td>
                        <td>" . $row["height"] . "</td>
                        <td>" . $row["body_fat_percentage"] . "</td>
                        <td>" . $row["muscle_percentage"] . "</td>
                        <td>" . $row["fluid_percentage"] . "</td>
                        <td>" . $row["bone_percentage"] . "</td>
                        <td>" . $row["measurement_date"] . "</td>
                        <td>
                            <i class='bi bi-pencil pencil-icon action-icon' onclick='editRow(this)'></i>
                        </td>
                      </tr>
                      <tr class='edit-row' style='display:none;'>
                      <td contenteditable='true'>" . $row["customer_username"] . "</td>
                      <td contenteditable='true'>" . $row["weight"] . "</td>
                      <td contenteditable='true'>" . $row["height"] . "</td>
                      <td contenteditable='true'>" . $row["body_fat_percentage"] . "</td>
                      <td contenteditable='true'>" . $row["muscle_percentage"] . "</td>
                      <td contenteditable='true'>" . $row["fluid_percentage"] . "</td>
                      <td contenteditable='true'>" . $row["bone_percentage"] . "</td>
                      <td contenteditable='true'>" . $row["measurement_date"] . "</td>
                      <td>
                          <i class='bi bi-check check-icon action-icon' onclick='saveEdit(this)'></i>
                          <i class='bi bi-x close-icon action-icon' onclick='cancelEdit(this)'></i>
                      </td>
                    </tr>";  
                }
            } else {
                echo "<tr><td colspan='3'>No data found</td></tr>";
            }
            ?>
            </tbody>
            </table>


      </div>
    </section><!-- End Services Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
 <footer id="footer" style="position: fixed; width: 100%; bottom: 0;">  </div>
    <div class="container text-center">
        <div class="copyright">
        &copy; Copyright <strong><span>Well-being App</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
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
<!-- Font Awesome CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"></script>
<script>
    function editRow(button) {
        var row = button.closest('tr');
        var editRow = row.nextElementSibling;
        row.style.display = 'none';
        editRow.style.display = 'table-row';
    }

    function saveEdit(button) {
        var editRow = button.closest('tr');
        var row = editRow.previousElementSibling;

        // Loop through each cell in the edit row and update the corresponding cell in the view row
        var cells = editRow.getElementsByTagName('td');
        for (var i = 0; i < cells.length - 1; i++) { // Exclude the last cell with buttons
            var newValue = cells[i].textContent;
            row.getElementsByTagName('td')[i].textContent = newValue;
        }

        editRow.style.display = 'none';
        row.style.display = 'table-row';
    }

    function cancelEdit(button) {
        var editRow = button.closest('tr');
        var row = editRow.previousElementSibling;
        editRow.style.display = 'none';
        row.style.display = 'table-row';
    }
</script>
</body>

</html>
