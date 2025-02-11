<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  if(isset($_POST['reset_form'])){
    $conn = mysqli_connect("localhost", "root", "", "e_learning");
    if (!$conn)
      echo mysqli_connect_error();

    $email = strtolower($_POST['reset_email']);
    $new_pass = $_POST['reset_new_pass'];
    $con_pass = $_POST['reset_con_pass'];
    $sql = "SELECT s_email FROM student WHERE s_email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) == 0){
      echo "<script>alert('Email does not exist!'); </script>";
    }elseif($new_pass != $con_pass){
      echo "<script>alert('Both passwords must match!'); </script>";
    }else{
      $sql = "UPDATE student SET s_password = '$new_pass' WHERE s_email = '$email'";
      mysqli_query($conn,$sql);
      echo "<script>alert('Password successfully changed!'); </script>";
      }
    }
  elseif(isset($_POST['login_form'])){
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];
    $conn = mysqli_connect("localhost", "root", "", "e_learning");
    if (!$conn)
        echo mysqli_connect_error();

    $sql = "SELECT s_email, s_password, s_name, s_id, i_id  FROM student WHERE s_email = '$email' AND s_password = '$password'";
    $login = mysqli_query($conn, $sql);

    if(mysqli_num_rows($login) == 0){                             //counts the number of rows
        $error_message = "Invalid email or password.";            //if number of rows returned is 0, creates an error message
        echo "<script>alert('$error_message');</script>";
    } else 
    {
        $_SESSION['is_logged_in'] = true;                         //if query matches data, moves to home page and changes
        $row = mysqli_fetch_assoc($login);                        //fetches database query data
        $_SESSION['username'] = $row['s_name'];                   //extracts s_name to be used in welcome string
        $_SESSION['s_id'] = $row['s_id'];
        $_SESSION['i_id'] = $row['i_id'];
        header('location: ../home/home.php');                     //log in and sign up buttons to a log out button and a welcome string
        exit();
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../home/styles.css">

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
            <a href="../registration/login.php" class="btn btn-light me-4">Login</a>
            <a href="../registration/signup.php" class="btn btn-warning">Sign Up</a>
        </div>
      </div>
    </nav>
  </header>
  <div class="container register">
    <div class="row">
      <div class="col-md-7">
        <img src="images/login.jpg" alt="" class="img-fluid">
      </div>
      <div class="col-md-4">
        <form action="" method="post">
          <h1>Log in your account</h1>
          <div>
            <input id="email" type="email" name="email" placeholder="Email" required>
          </div>
          <div>
            <input id="password" type="password" name="password" placeholder="Password" required>
          </div>
          <button type="submit" name = "login_form">Log in</button>
          <br>
          <h6 style="padding-top:10px;text-align: center;">Forget password?
            <button type="button" class="btn btn-link p-0 reset-pass" style="text-decoration: underline; font-size: inherit; margin-left: 0;" data-toggle="modal" data-target="#forgetModal">
              Reset Password
            </button>
          </h6>
          <div class="divider">or login with</div>
          <h6 style="text-align: center;">
            Don't have an account? <a href="signup.php">Sign up</a> </h6>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="forgetModal" tabindex="-1" role="dialog" aria-labelledby="forgetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="justify-content: space-between;">
          <h5 class="modal-title" id="forgetModalLabel">Reset Password</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" style="background: none; border: none; padding: 0; margin: 0; font-size: 1.5rem; line-height: 1;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form method = "post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="email" class="form-label" style="font-size: 22px;">Email</label>
            <input type="email" class="form-control" id="email" name = "reset_email" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label" style="font-size: 22px;">New Password</label>
            <input type="password" class="form-control" id="password" name = "reset_new_pass" placeholder="New Password" required>
          </div>
          <div class="mb-3">
            <label for="cnf_password" class="form-label" style="font-size: 22px;">Confirm Password</label>
            <input type="password" class="form-control" id="cnf_password" name = "reset_con_pass" placeholder="Confirm Password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name = "reset_form" class="btn btn-primary" style="background-color: #C3413B; color: #fff; border-radius: 5px; border: none; padding: 10px 20px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#A82E29';" onmouseout="this.style.backgroundColor='#C3413B';">
            Reset Password
          </button>
      </form>
        </div>
      </div>
    </div>
  </div>
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>