<?php
session_start();
$is_logged_in = isset($_SESSION['is_logged_in']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="instructor_style.css">
    <link rel="stylesheet" href="../home/styles.css">
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
                        <li class="nav-item"><a class="nav-link text-light" href="../home/home.php#courses">Courses</a>
                        </li>
                        <li class="nav-item"><a class="nav-link text-light" href="../home/home.php#team">Team</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="../my_learning/my_learning.php">My
                                Learning</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="../home/home.php#About-us">About
                                Us</a></li>
                    </ul>

                    <!-- Search bar -->

                    <form class="d-flex me-4" method="POST" action="../search/search.php">
                        <input class="form-control me-2 search" type="search" name="searchQuery"
                            placeholder="Search courses..." aria-label="Search" required>
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

    <section class="ins-data">

        <?php
        if (isset($_GET['i_id'])) {
            $conn = mysqli_connect("localhost", "root", "", "e_learning");
            if (!$conn)
                echo mysqli_connect_error();

            $sql = "SELECT i_name, i_image, i_bio, i_job_desc FROM instructor WHERE i_id = " . $_GET['i_id'];
            $result = mysqli_query($conn, $sql);

            if ($row = mysqli_fetch_assoc($result)) {
                echo '<div>
                        <h2 style="font-weight: bold; color: black;">Instructor</h2>
                        <h5 style="color: gray;">' . $row['i_bio'] . ' Instructor</h5>
                        <div class="img-container">
                            <img src="../home/' . $row['i_image'] . '" alt=' . $row['i_image'] . '>
                            <ul style="padding-top: 35px;">
                                <li>⭐ 4.8 Instructor Rating</li>
                                <li>📜 8,934 Reviews</li>
                                <li>👨‍🎓 44,025 Students</li>
                                <li>▶️ ';

                $sql = "SELECT * FROM course WHERE i_id=" . $_GET['i_id'];
                $result = mysqli_query($conn, $sql);

                echo mysqli_num_rows($result) . ' Courses</li>
                            </ul>
                        </div>
                        <h2 style=" text-decoration: underline; user-select: none;">' . $row['i_name'] . '</h2>
                    </div>

                    <div class="ins-disc">
                        <h4 style="font-weight: bold;">' . $row['i_bio'] . '
                            Instructor</h4>
                        <p>
                            ' . $row['i_job_desc'] . '
                        </p>
                    </div>';
            }
        }
        ?>



    </section>

    <section class="ins-courses">
        <h2>My Courses</h2>

        <div class="courses-list">
            <?php

            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                    <div class="ins-course-card">
                        <figure class="card-banner img-holder" style="--width: 370; --height: 220;">
                            <img src="../home/' . $row['c_image'] . '" width="370" height="220" loading="lazy"
                                alt="' . $row['c_desc'] . '">
                        </figure>

                        <div class="abs-badge">
                            <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
                            <span class="span">' . $row['c_no_of_lessons'] . ' Weeks</span>
                        </div>

                        <div class="card-content">
                            <span class="badge">Beginner</span>';
                if ($is_logged_in) {
                    $s_id = $_SESSION['s_id'];
                    $c_id = $row["c_id"];
                    $sql = "SELECT * FROM `old_cart` WHERE s_id = $s_id and c_id = $c_id;";
                    $result2 = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result2) == 0)
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
                            <data class="price" value="' . $row['c_price'] . '"> $' . $row['c_price'] . '</data>
                            <ul class="card-meta-list">
                                <li class="card-meta-item">
                                    <ion-icon name="library-outline" aria-hidden="true"></ion-icon>
                                    <span class="span">' . $row['c_no_of_lessons'] . '</span>
                                </li>

                                <li class="card-meta-item">
                                    <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
                                    <span class="span">';

                $sql = "SELECT count(s_id) FROM old_cart WHERE c_id = " . $row['c_id'];
                $no_of_st = mysqli_query($conn, $sql);
                $no_of_st = mysqli_fetch_assoc($no_of_st);

                echo $no_of_st['count(s_id)'] . ' Students</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                ';
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
                Learn the basics of web development, including HTML, CSS, and JavaScript, in this beginner-friendly
                course.
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

    <!--header-->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // Create an observer to detect when the section is in the viewport
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add class to trigger animation
                    entry.target.classList.add("visible");
                    // Stop observing after the animation triggers
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 }); // Trigger when 50% of the section is in view

        // Target the element to be animated
        const section = document.querySelector(".ins-data");

        // Observe the section
        observer.observe(section);

    </script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>