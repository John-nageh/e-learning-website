<?php
session_start();
$is_logged_in = isset($_SESSION['is_logged_in']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if ($is_logged_in && isset($_SESSION['i_id'])) {
  if ($_SESSION['i_id'])
    header('location: ../instructor_admin/admin_instructor.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Learning Website</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap"
    rel="stylesheet">
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
            <li class="nav-item"><a class="nav-link text-light" href="../my_learning/my_learning.php">My Learning</a>
            </li>
            <li class="nav-item"><a class="nav-link text-light" href="../home/home.php#About-us">About Us</a></li>
          </ul>

          <!-- Search bar -->

          <form class="d-flex me-4" method="POST" action="../search/search.php">
            <input class="form-control me-2 search" type="search" name="searchQuery" placeholder="Search courses..."
              aria-label="Search" required>
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

  <section class="section hero has-bg-image" id="home" aria-label="home"
    style="background-image: url('images/hero-bg.svg')">
    <div class="container">

      <div class="hero-content">

        <h1 class="h1 section-title">
          Discover the Best Online Learning Platform to <span class="span">Elevate</span> Your Skills and Achieve Your
          Dreams.
        </h1>

        <p class="hero-text">
          Your gateway to quality online learning.<br> Explore courses, gain skills, and achieve your goals.<br>
          All in one place.
        </p>

        <a href="#courses" class="btn btn-find-course"> Find Courses</a>

      </div>

      <figure class="hero-banner">

        <div class="two-photos">

          <div class="img-holder one" style="--width: 150; --height: 100;">
            <img src="images/hero2.jpg" width="150" height="100" alt="hero banner" class="img-cover">
          </div>
          <div class="img-holder three" style="--width: 300; --height: 250; ">
            <img src="images/hero3.jpg" width="300" height="250" alt="hero banner" class="img-cover">
          </div>
        </div>
        <div class="img-holder two" style="--width: 240; --height: 370;">
          <img src="images/hero1.jpg" width="240" height="370" alt="hero banner" class="img-cover">
        </div>


      </figure>

    </div>
  </section>

  <!-- Courses  -->
  <section class="section course" id="courses" aria-label="course">
    <div class="container">

      <p class="section-subtitle">Popular Courses</p>

      <h2 class="h2 section-title">Pick a Course To Get Started</h2>

      <div class="browse">
        <a href="../courses/courses.php" class="btn btn-light me-4 btn1 ">
          View more courses
        </a>
      </div>

      <ul class="grid-list">

        <?php

        $conn = mysqli_connect("localhost", "root", "", "e_learning");
        if (!$conn)
          echo mysqli_connect_error();

        $sql = "SELECT 
                      c.c_id, 
                      c.c_name, 
                      c.c_desc,
                      c.c_no_of_lessons,
                      c.c_price,
                      c.c_image,
                      c.c_level,
                      COUNT(o.s_id) AS student_count
                  FROM 
                      course c
                  JOIN 
                      old_cart o
                  ON 
                      c.c_id = o.c_id
                  GROUP BY 
                      c.c_id
                  ORDER BY 
                      student_count DESC
                  LIMIT 3";
        $result = mysqli_query($conn, $sql);

        // course cards
        while ($row = mysqli_fetch_assoc($result)) {
          echo '
              <li>
                <div class="course-card">
                  <figure class="card-banner img-holder" style="--width: 370; --height: 220;">
                    <img src="' . $row['c_image'] . '" width="370" height="220" loading="lazy"
                      alt="' . $row['c_name'] . '" class="img-cover">
                  </figure>

                  <div class="abs-badge">
                    <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
                    <span class="span">' . $row['c_no_of_lessons'] . ' Weeks</span>
                  </div>

                  <div class="card-content">
                    <span class="badge">' . $row['c_level'] . '</span>';

          if ($is_logged_in) {
            $c_id = $row["c_id"];
            $s_id = $_SESSION['s_id'];
            $sql = "SELECT * FROM `old_cart` WHERE s_id = $s_id and c_id = $c_id;";
            $is_present = mysqli_query($conn, $sql);
            if (mysqli_num_rows($is_present) == 0)
              echo '<h3><a href="#courseModal" onclick="openModal(' . '\'' . $row['c_name'] . '\', ' . '\'' . $row['c_desc'] . '\', ' . '\'' . $row['c_no_of_lessons'] . '\', ' . '\'' . $row['c_price'] . '\', ' . '\'' . $row['c_id'] . '\')" class="card-title">' . $row["c_name"] . '</a></h3>';
            else
              echo '<h3><a href="../course_content/course_page.php?c_id=' . $row['c_id'] . '" class="card-title">' . $row["c_name"] . '</a></h3>';
          } else
            echo '<h3><a href="#courseModal" onclick="openModal(' . '\'' . $row['c_name'] . '\', ' . '\'' . $row['c_desc'] . '\', ' . '\'' . $row['c_no_of_lessons'] . '\', ' . '\'' . $row['c_price'] . '\', ' . '\'' . $row['c_id'] . '\')" class="card-title">' . $row["c_name"] . '</a></h3>';
          echo
            '<div class="wrapper">
                      <div class="rating-wrapper">
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                      </div>
                      <p class="rating-text">(4.8/5 Rating)</p>
                    </div>

                    <data class="price" value="' . $row['c_price'] . '">$' . $row['c_price'] . '</data>
                    <ul class="card-meta-list">
                      <li class="card-meta-item">
                        <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
                        <span class="span">' . $row['c_no_of_lessons'] . ' Lessons</span>
                      </li>

                      <li class="card-meta-item">
                        <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
                        <span class="span">' . $row['student_count'] . ' Students</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
            ';
        }

        ?>

      </ul>

    </div>
  </section>

  <!--Our Team-->
  <section id="team" style="padding: 50px 20px; text-align: center; background-color: white;">
    <p class="section-subtitle" style="margin-bottom: 150px;">Meet Our Instructors</p>

    <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; padding-top: -100px;">

      <!-- Mentor cards -->
      <?php

      $sql = "SELECT i_name, i_image, i_bio, i_id FROM instructor WHERE i_id < 5";
      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="team-card">
                  <div class="image-container">
                    <img src=' . $row['i_image'] . ' alt=' . $row['i_name'] . '>
                  </div>
                  <h3><a href="../instructor/instructor.php?i_id=' . $row['i_id'] . '">' . $row['i_name'] . '</a></h3>
                  <p>' . $row['i_bio'] . '</p>
                  <p>⭐ 4.6</p>
                </div>';
      }
      ?>

    </div>
  </section>

  <h2 class="h2 section-title " style="display: block;">Our Impact in Numbers</h2>
  <div class="container-status" style="padding-top: 4px ;">
    <section id="stats" class="stats-section">
      <div class="stat">
        <h2 class="stat-number" data-target="3500">0</h2>
        <p class="stat-label">LEARNERS</p>
      </div>
      <div class="stat">
        <h2 class="stat-number" data-target="4960">0</h2>
        <p class="stat-label">GRADUATES</p>
      </div>
      <div class="stat">
        <h2 class="stat-number" data-target="99">0</h2>
        <p class="stat-label">COUNTRIES REACHED</p>
      </div>
      <div class="stat">
        <h2 class="stat-number" data-target="520">0</h2>
        <p class="stat-label">COURSES PUBLISHED</p>
      </div>
    </section>
  </div>


  <div id="courseModal" class="modal">
    <div class="modal-content">
      <div class="course-title" id="modalTitle">Build Responsive Real-World Websites with HTML and CSS</div>
      <ul class="card-meta-list">
        <li class="card-meta-item">
          <ion-icon name="library-outline"></ion-icon>
          <span class="span" id="modalno">58 Lessons</span>
        </li>
        <li class="card-meta-item">
          <ion-icon name="people-outline"></ion-icon>
          <span class="span">20 Students</span>
        </li>
        <li class="card-meta-item">
          <ion-icon name="time-outline"></ion-icon>
          <span class="span" id="modaltime">3 Weeks</span>
        </li>
      </ul>
      <p class="course-description" id="modaldesc">
        Learn the basics of web development, including HTML, CSS, and JavaScript, in this beginner-friendly course.
        This course is designed to provide you with a solid foundation to start building your own websites.
      </p>

      <div class="price-and-btn">
        <div class="course-price" id="modalprice">$49.99</div>
        <button class="add-to-cart-btn" onclick="addChart()">Add to Cart</button>
      </div>
    </div>
  </div>
  <script>
    var c_id;
    function openModal(name, desc, no, price, id) {
      document.getElementById('modalTitle').textContent = name;
      document.getElementById('modaldesc').textContent = desc;
      document.getElementById('modalno').textContent = no + ' lessons';
      document.getElementById('modaltime').textContent = no + ' weeks';
      document.getElementById('modalprice').textContent = '$' + price;
      c_id = id;

      document.getElementById('courseModal').style.display = 'flex';
    }

    function closeModal() {
      document.getElementById('courseModal').style.display = 'none';
    }

    function addChart() {
      <?php
      if (!$is_logged_in) {
        echo "
        alert('Please log in to add to cart');
        return;
        ";
      }
      ?>

      // Use fetch to send c_id to the PHP script
      fetch('../courses/add_to_cart.php', {
        method: 'POST',
        body: JSON.stringify({ c_id: c_id }), // Send c_id to PHP as JSON
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('courseModal').style.display = 'none';
            alert(data.message);
          } else {
            console.error('Error adding to cart');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

    // Close modal if clicked outside of the content
    window.addEventListener('click', function (event) {
      const modal = document.getElementById('courseModal');
      if (event.target === modal) {
        closeModal();
      }
    });
  </script>


  <footer class="footer" id="About-us">
    <div class="footer-top section">
      <div class="container grid-list">
        <!-- Footer Brand -->
        <div class="footer-brand">
          <a href="#" class="logo">
            <img src="images/logo1.png" width="150" height="50" alt="E-Learning logo">
          </a>
          <p class="footer-brand-text">
            Your gateway to quality online learning . Explore courses, gain skills, <br>and achieve your goals.
            All in one place.
          </p>

          <div class="wrapper">
            <span class="span">Call: </span>
            <a href="tel:+201158917944" class="footer-links">+20 115 8917 944</a>
          </div>
          <div class="wrapper">
            <span class="span">Email: </span>
            <a href="mailto:info@e-learning.com" class="footer-links">info@e-learning.com</a>
          </div>
          <div class="footer-bottom">
            <div class="container">
              <p class="copyright">
                Copyright 2024 All Rights Reserved by <a href="#" class="copyright-link"> Double Rahom & Double John
                  ^_^</a>
              </p>
            </div>
          </div>
        </div>

        <div class="footer-right">
          <div class="footer-links">
            <ul class="footer-list">
              <li>
                <p class="footer-list-title">Online Platform</p>
              </li>
              <li><a href="#" class="footer-link">About</a></li>
              <li><a href="#courses" class="footer-link">Courses</a></li>
              <li><a href="#team" class="footer-link">Instructor</a></li>
              <li><a href="#" class="footer-link">Purchase Guide</a></li>
            </ul>

            <ul class="footer-list">
              <li>
                <p class="footer-list-title">Links</p>
              </li>
              <li><a href="#" class="footer-link">Contact Us</a></li>
              <li><a href="#" class="footer-link">News & Articles</a></li>
              <li><a href="#" class="footer-link">FAQ's</a></li>
              <li><a href="../registration/login.html" class="footer-link">Sign In/Registration</a></li>
            </ul>
          </div>

          <div class="footer-social">
            <p class="footer-list-title">Follow Us</p>
            <div class="social-list">
              <a href="#" class="social-link"><ion-icon name="logo-facebook"></ion-icon></a>
              <a href="#" class="social-link"><ion-icon name="logo-linkedin"></ion-icon></a>
              <a href="#" class="social-link"><ion-icon name="logo-instagram"></ion-icon></a>
              <a href="#" class="social-link"><ion-icon name="logo-twitter"></ion-icon></a>
              <a href="#" class="social-link"><ion-icon name="logo-youtube"></ion-icon></a>
            </div>
          </div>
        </div>
  </footer>



  <script src="statistics.js"></script>

  <!-- Bootstrap JS -->
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>