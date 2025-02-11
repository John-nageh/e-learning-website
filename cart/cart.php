<?php
session_start();
$is_logged_in = isset($_SESSION['is_logged_in']);
if (!$is_logged_in) {
    header('location: ../registration/login.php');
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$conn = mysqli_connect("localhost", "root", "", "e_learning");
if (!$conn)
    echo mysqli_connect_error();

if (isset($_GET['rem_id'])) {
    $sql = "DELETE FROM `student_cart` WHERE c_id=" . $_GET['rem_id'] . " and s_id=" . $_SESSION['s_id'];
    mysqli_query($conn, $sql);

    $_GET['rem_id'] = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../home/styles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="cart_style.css">
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

    <section class="cart-sec">
        <div>
            <h1>Shopping Cart</h1>

            <?php

            $sql = "SELECT * 
                        FROM course
                        WHERE c_id IN (
                            SELECT c_id 
                            FROM student_cart
                            WHERE s_id = " . $_SESSION['s_id'] . ")";
            $result = mysqli_query($conn, $sql);

            echo '
                    <div class="cart-title">
                        <h3>' . mysqli_num_rows($result) . ' Courses in Cart</h3>
                    </div>';

            $total = 0;

            while ($row = $result->fetch_assoc()) {
                $total += $row['c_price'];
                echo '
                        <div class="cart-item">
                            <img src="../home/' . $row['c_image'] . '" alt="' . $row['c_name'] . '" class="course-image">
                            <div class="course-details">
                                <h2>' . $row['c_name'] . '</h2>
                                <p> by ';

                $sql = "select i_name from instructor where i_id = " . $row['i_id'];
                $i_name = mysqli_query($conn, $sql);
                $i_name = $i_name->fetch_assoc();

                echo $i_name['i_name'] . '</p>
                                <div class="rating">
                                    <span class="rating-number">' . 4 . '</span>
                                    <span> ★</span>
                                    <span> ★</span>
                                    <span> ★</span>
                                    <span> ★</span>
                                    <span> ★</span>
                                    <span class="rating-num">(' . 4.5 . ' ratings)</span>
                                </div>
                                <p class="course-overview">' . $row['c_desc'] . '</p>
                                <div class="actions">
                                    <a href="cart.php?rem_id=' . $row['c_id'] . '" class="remove">Remove</a>
                                </div>
                            </div>
                            <p class="price">' . $row['c_price'] . '</p>
                        </div>';
            }


            echo '
                </div>
                <div class="checkout-section">
                    <h3>Total:</h3>
                    <h2>£'.$total.'</h2>
                    <a href="payment.php?total='.$total.'" class="checkout-btn">Checkout</a>
                </div>
            ';

            ?>

    </section>

    <!--header-->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>