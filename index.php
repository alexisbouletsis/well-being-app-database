<?php
session_start();
// Include the database connection file
include 'db_connection.php';

// Function to fetch data from the medication table
function fetchMedicationData($conn) {
    $sql = "SELECT * FROM medication";
    $result = $conn->query($sql);
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


if (isset($_SESSION['username']) && isset($_SESSION['login_type'])) {
  $username = $_SESSION['username'];
  $login_type = $_SESSION['login_type'];

  // Check the login type and perform the appropriate query to get the user's real name
  if ($login_type === 'employee') {
      $sql = "SELECT name FROM employee WHERE employee_username = ? ";
  } elseif ($login_type === 'customer') {
      $sql = "SELECT name FROM customer WHERE customer_username = ? ";
  }

  // Prepare the statement
  $statement = $conn->prepare($sql);
  $statement->bind_param('s', $username);

  // Execute the query
  $statement->execute();

  // Store the result
  $statement->bind_result($real_name);

  // Fetch the result
  $statement->fetch();

  // Close the statement
  $statement->close();
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
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php">Well-being App</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href=index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <?php if (isset($_SESSION['username'])): ?>
            <li><a href="plan.php">Plan</a></li>
            <li><a class="nav-link" href="medication.php">Medication</a></li>
            <li><a href="biometrics.php">Biometrics</a></li>
            <li><a href="appointments.php">Appointments</a></li>
            <li><a href="medication.php?logout=true" class="nav-link">Logout</a></li>
          <?php else: ?>
              <li><a href="login.php" class="nav-link">Login</a></li>
              <li><a href="signup.php" class="nav-link">Signup</a></li>
          <?php endif; ?>
<!-- 
          <li><a href="login.php">Log In</a></li>
          <li><a href="signup.php">Sign Up</a></li>  -->
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-cntent-center align-items-center">
    <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="carousel-container">
          <!-- <h2 class="animate__animated animate__fadeInDown">Welcome to <span>Well-being App</span></h2> -->
          <?php if (isset($_SESSION['username'])): ?>
            <h2 class="animate__animated animate__fadeInDown">Welcome, <?php echo $real_name; ?></h2>
          <?php else: ?>
              <h2 class="animate__animated animate__fadeInDown">Welcome to <span>Well-being App</span></h2>
          <?php endif; ?>
          <p class="animate__animated animate__fadeInUp">
            Our mission is to empower well-being-focused companies that prioritize health and fitness. 
            We have developed a comprehensive database tailored for companies providing nutritionists, fitness trainers, and health scientists, who, in turn, serve clients seeking to monitor and enhance their physical well-being.
            Our platform is designed to facilitate seamless communication between well-being professionals and their clients, ensuring a personalized and effective approach to health management. 
          </p>
          <?php if (!isset($_SESSION['username'])): ?>
              <a href="signup.php" class="btn-get-started animate__animated animate__fadeInUp scrollto">Sign Up</a>
              <a href="login.php" class="btn-get-started animate__animated animate__fadeInUp scrollto">Log in</a>
            <?php endif; ?>
        </div>
      </div>

    </div>
  </section><!-- End Hero -->

  <main id="main">

  <section id="icon-boxes" class="icon-boxes">
      <div class="container">
      </div>
    </section>End Icon Boxes Section


    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Services</h2>
        </div>

        <div class="row">
          <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box">
              <i class="bi bi-person-walking"></i>
              <?php if (isset($_SESSION['username'])): ?>
                <h4><a href="plan.php">Activity Plan</a></h4>
              <?php else: ?>
                <h4>Activity Plan</h4>
              <?php endif; ?>
              <p>Personalized activity plan, outlining exercises and physical activities tailored to your fitness goals and preferences</p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <i class="bi bi-cup-hot-fill"></i>
              <!-- <h4><a href="dietplan.php">Diet Plan</a></h4> -->
              <?php if (isset($_SESSION['username'])): ?>
                <h4><a href="plan.php">Diet Plan</a></h4> 
              <?php else: ?>
                <h4>Diet Plan</h4> 
              <?php endif; ?>
              <p>Customized diet plan that aligns with your nutritional needs, allowing you to make informed choices for a healthier lifestyle</p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box">
              <i class="bi bi-clipboard-pulse"></i>
              <!-- <h4><a href="biometrics.php">Biometrics</a></h4> -->
              <?php if (isset($_SESSION['username'])): ?>
                <h4><a href="biometrics.php">Biometrics</a></h4>
              <?php else: ?>
                <h4>Biometrics</h4>
              <?php endif; ?>
              <p>Record and monitor your body metrics, such as weight, height, and other relevant measurements, providing a visual representation of your progress over time</p>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="400">
            <div class="icon-box">
              <i class="bi bi-capsule-pill"></i>
              <?php if (isset($_SESSION['username'])): ?>
              <h4><a href="medication.php">Medication</a></h4>
              <?php else: ?>
                <h4>Medication</h4>
              <?php endif; ?>
              <p>Keep track of your medications and health supplements, ensuring a comprehensive overview of your well-being journey and adherence to prescribed treatments</p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
 <footer id="footer">  </div>

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