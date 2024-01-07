<?php
// Include the database connection file
include 'db_connection.php';

function fetchSignupData($conn, $name, $username, $password, $email, $dob, $gender) {
  // Check if the email already exists
  $check_email = "SELECT * FROM customer WHERE email='$email'";
  $email_result = $conn->query($check_email);
  if ($email_result->num_rows > 0) {
      return "Email already exists";
  }

  // Check if the username already exists
  $check_username = "SELECT * FROM customer WHERE customer_username='$username'";
  $username_result = $conn->query($check_username);
  if ($username_result->num_rows > 0) {
      return "Username already exists";
  }

  $date_of_subscription = date("Y-m-d"); // Get the current date in YYYY-MM-DD format

  $sql = "INSERT INTO customer (name, customer_username, password, email, date_of_birth, gender, date_of_subscription) VALUES ('$name', '$username', '$password', '$email', '$dob', '$gender', '$date_of_subscription')";
  
  $result = $conn->query($sql);
  
  if ($result) {
    // Successful signup
    // Perform automated login
    
    // Retrieve user ID after signup
    $newUserId = $conn->insert_id;

    // Set session variables for the newly registered user
    session_start();
    $_SESSION['user_id'] = $newUserId;
    $_SESSION['username'] = $username;
    $_SESSION['login_type'] = 'customer';

    // Redirect to index.php
    header("Location: index.php");
    exit();
  } else {
    return "Signup failed! Please try again.";
  }
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Hash the password for security (use PHP password_hash)
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $signup_result = fetchSignupData($conn, $name, $username, $password, $email, $dob, $gender);

    if ($signup_result !== "Success") {
        // Signup failed, display an error message
        $error_message = $signup_result;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Well-being App | Sign up</title>
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
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php">Well-being App</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href=index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto " href="index.php #services">Services</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Plan</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Activity Plan</a></li>
              <li><a href="#">Diet Plan</a></li>
            </ul>
          </li>
          <li><a href="medication.php">Medication</a></li> -->
          <!-- <li><a href="biometrics.php">Biometrics</a></li> -->
          <li><a class="nav-link" href="login.php">Log In</a></li>
          <li><a href="signup.php">Sign Up</a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>


  </header><!-- End Header -->

  
  <main id="main" style="padding-top: 100px; padding-bottom: 20px;"> <!-- Adjust the padding value as needed -->
  <div class="container">
  <div class="container mt-5">
  <div class="row justify-content-center">
  
    <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
        <div class="container mt-5">
          <div class="row justify-content-center">
              <div class="col-lg-6">
                  <div class="signup-box">

                    <form id="signupForm" action="signup.php" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="dob">Date of Birth:</label>
                                    <!-- <input type="date" class="form-control" id="dob" name="dob" lang="en" required> -->
                                    <input type="date" class="form-control" id="dob" name="dob" lang="en" required>
                                  </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                          <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                              <?php echo $error_message; ?>
                            </div>
                          <?php endif; ?>
                          <center><button type="submit" class="btn btn-primary btn-block">Sign Up</button></center>
                      </form>
                    <p class="text-center mt-3 text-muted">Already have an account? <a href="login.php">Log in</a></p>
                </div>
            </div>
        </div>
    </div>
  </main>



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