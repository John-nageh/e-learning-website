<?php
session_start();
$is_logged_in = isset($_SESSION['is_logged_in']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$s_id = isset($_SESSION['s_id']) ? $_SESSION['s_id'] : -1;

$conn = mysqli_connect("localhost", "root", "", "e_learning");
if (!$conn)
  echo mysqli_connect_error();

$c_id_sql = "SELECT c_id FROM old_cart WHERE s_id = '$s_id'";

$c_id_result = mysqli_query($conn, $c_id_sql);


$c_ids = array();
// Fetch rows as a numerical array
while ($c_ids_row = $c_id_result->fetch_assoc()) {
  $c_ids[] = $c_ids_row['c_id'];
}

if (isset($_POST['searchQuery'])) {
  $search = $_POST['searchQuery'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="search.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="../home/styles.css">
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap"
    rel="stylesheet">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
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


  <!-- Title Page -->
  <div class="section-subtitle"><?php echo 'Search Results for "' . $search . '"' ?></div>
  <section class="my-learning">
    <div class="Learning">
      <?php

      $sql = "SELECT  course.c_id,
                            course.c_name, 
                            course.c_image,
                            course.c_no_of_lessons,
                            course.c_desc,
                            course.c_price,
                            instructor.i_name 
                        FROM 
                            course 
                        INNER JOIN 
                            instructor 
                        ON 
                            course.i_id = instructor.i_id
                        WHERE 
                            LOWER(c_name) LIKE '%$search%';";
      $result = mysqli_query($conn, $sql);

      while ($row = $result->fetch_assoc()) {
        if (in_array($row['c_id'], $c_ids)) {
          echo
            '<div class="card">' .
            '<div class="card-header">' .
            '<img src="../home/' . $row['c_image'] . '" alt=' . $row['c_name'] . '/>' .
            '<div class="overlay">' .
            '<i class="fas fa-play-circle play-icon"></i>' .
            '</div>' .
            '</div>' .
            '<div class="card-body">' .
            '<h2>' . '<a href="../course_content/course_page.php?c_id=' . $row['c_id'] . '" class="card-link">' . $row['c_name'] . '</a>' . '</h2>' .
            '<p class="author">' . $row['i_name'] . '</p>' .
            '</div>' .
            '</div>';
        } else {
          echo
            '<div class="card">' .
            '<div class="card-header">' .
            '<img src="../home/' . $row['c_image'] . '" alt=' . $row['c_name'] . '/>' .
            '<div class="overlay">' .
            '<i class="fas fa-play-circle play-icon"></i>' .
            '</div>' .
            '</div>' .
            '<div class="card-body">' .
            '<h2><a href="#courseModal"
                             onclick="openModal(' . '\'' . $row['c_name'] . '\', ' . '\'' . $row['c_desc'] . '\', ' . '\'' . $row['c_no_of_lessons'] . '\', ' . '\'' . $row['c_price'] . '\', ' . '\'' . $row['c_id'] . '\')"
                             class="card-title">' . $row["c_name"] . '</a></h2>' .
            '<p class="author">' . $row['i_name'] . '</p>' .
            '</div>' .
            '</div>' .
            '</a>';
        }
      }
      ?>
    </div>
  </section>


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



  </div>


</body>

</html>