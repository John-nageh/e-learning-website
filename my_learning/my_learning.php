<?php
session_start();
$is_logged_in = isset($_SESSION['is_logged_in']);
if (!$is_logged_in) {
    header('location: ../registration/login.php');
}
$is_logged_in = isset($_SESSION['is_logged_in']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$s_id = $_SESSION['s_id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../home/styles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="my_learning.css">
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg bg-primary shadow">
      <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center logo" href="#">
          <img src="../home/images/logo1.png" alt="Logo" width="50" height="50" class="me-2">
          <span>E-Learning</span>
        </a>

        <!-- Toggler for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto me-4">
            <li class="nav-item"><a class="nav-link text-light" href="../home/home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="../home/home.php#courses">Courses</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="../home/home.php#team">Team</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="../my_learning/my_learning.php">My Learning</a></li>
            <li class="nav-item"><a class="nav-link text-light" href="../home/home.php#About-us">About Us</a></li>
          </ul>

          <!-- Search bar -->

    <form class="d-flex me-4" method="POST" action="../search/search.php">
        <input class="form-control me-2 search" type="search" name="searchQuery" placeholder="Search courses..." aria-label="Search" required>
        <button class="btn btn-outline-light" type="submit">Search</button>
    </form>

          <!-- Cart -->
          <a href="../cart/cart.php" class="me-3 cart">
            <img src="../home/images/cart_icon.png" alt="Cart" width="30" height="30">
          </a>

          <!-- Login and Signup buttons -->
          <?php if ($is_logged_in): ?>
            <span style="font-size: 65%; margin-right: 2%;">Welcome <?php echo $username; ?>! </span>
            <a href="../registration/logout.php" class="btn btn-light me-4">Log out</a>
          <?php else: ?>
            <a href="../registration/login.php" class="btn btn-light me-4">Login</a>
            <a href="../registration/signup.php" class="btn btn-warning">Sign Up</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>
    <section class="my-learning">
        <h1>My Learning</h1>
        <h3>All Courses</h3>
        <div class="Learning">
        <?php 
            $conn = mysqli_connect("localhost", "root", "", "e_learning");
            if (!$conn)
                echo mysqli_connect_error();

            $sql = "SELECT 
                            old_cart.c_id, 
                            course.c_name, 
                            course.c_image,
                            instructor.i_name 
                        FROM 
                            old_cart 
                        INNER JOIN 
                            course 
                        ON 
                            old_cart.c_id = course.c_id
                        INNER JOIN 
                            instructor 
                        ON 
                            course.i_id = instructor.i_id
                        WHERE 
                            old_cart.s_id = '$s_id';";
            $result = mysqli_query($conn, $sql);

            while ($row = $result->fetch_assoc()) {   
                echo '<a href="../course_content/course_page.php?c_id='.$row['c_id'] .'" class="card-link">'.
                        '<div class="card">'.
                            '<div class="card-header">'.
                            '<img src="../home/'.$row['c_image'].'" alt='.$row['c_name'].'/>'.
                                '<div class="overlay">'.
                                    '<i class="fas fa-play-circle play-icon"></i>'.
                                '</div>'.
                            '</div>'.
                            '<div class="card-body">'.
                            '<h2>'.$row['c_name'].'</h2>'.
                            '<p class="author">'.$row['i_name'].'</p>'.
                            '</div>'.
                        '</div>'.
                    '</a>';
            }
        ?>  
            
            
        </div>
    </section>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>