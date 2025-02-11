<?php
session_start();
$is_logged_in = isset($_SESSION['is_logged_in']);
if (!$is_logged_in) {
    header('location: ../registration/login.php');
}
$conn = mysqli_connect("localhost", "root", "", "e_learning");
if (!$conn)
    echo mysqli_connect_error();
isset($_GET['c_id']) ? $c_id = $_GET['c_id'] : $c_id = 101;
$sql = "SELECT 
            c.c_name, 
            c.c_desc, 
            c.i_id, 
            c.c_no_of_lessons,
            c.c_level,
            i.i_name, 
            i.i_image,
            i.i_bio
        FROM 
            course c
        JOIN 
            instructor i
        ON 
            c.i_id = i.i_id
        WHERE 
            c.c_id = '$c_id';";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);
$c_name = $result['c_name'];
$c_desc = $result['c_desc'];
$c_no_of_lessons = $result['c_no_of_lessons'];
$c_level = $result['c_level'];
$i_id = $result['i_id'];
$i_name = $result['i_name'];
$i_image = $result['i_image'];
$i_bio = $result['i_bio'];
$v_sql = "SELECT v_num, v_path, v_title, v_duration FROM course_video WHERE c_id = $c_id";
$v_result = mysqli_query($conn, $sql);
$total_time = 0;
srand($c_id);
$time = array();
for ($i = 1; $i <= $c_no_of_lessons; $i++) {
    $x = rand(2, 59);
    $total_time += $x;
    $time[] = $x;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="course_page.css">
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center logo" href="../home/home.php">
                    <img src="../home/images/logo1.png" alt="Logo" width="50" height="50" class="me-2">
                    <span>E-Learning</span>
                </a>

                <!-- Toggler for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            </div>
        </nav>
    </header>
    <section>
        <div class="course">
            <div class="course-main" style="width: 70%">
                <div class="course-video">
                    <video controls>
                        <source src="videos/video1.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="course-card">
                    <h1><?php echo $c_name; ?></h1>
                    <div class="course-statics" style="display: flex;">
                        <div>
                            <h2 style="color: #ff9d00e8;">4.8 ★</h2>
                            <p>5,736 ratings</p>
                        </div>
                        <div>
                            <h2>33,957</h2>
                            <p>Students </p>
                        </div>
                        <div>
                            <h2><?php echo round(($total_time / 60), 1) . " hours" ?></h2>
                            <p>Total</p>
                        </div>

                        <div>
                            <h2><?php echo $c_no_of_lessons; ?></h2>
                            <p>Lessons</p>
                        </div>

                        <div>
                            <h2><?php echo $c_level; ?></h2>
                            <p>Skill Level</p>
                        </div>

                        <div>
                            <h2>Arabic</h2>
                            <p>Languages</p>
                        </div>
                    </div>

                    <div class="course-desc">
                        <b>Description</b>
                        <div>
                            <p><?php echo $c_desc; ?></p>
                        </div>
                    </div>

                    <div class="course-inst">
                        <b>Instructor</b>
                        <div>
                            <div style="display: flex;">
                                <img src="<?php echo '../home/' . $i_image; ?>" alt="" class="img-fluid rounded-circle"
                                    style="width: 100px; height: 120px; object-fit: cover;">
                                <ul>
                                    <h4 style="font-size: 18px; font-weight: bold; ">
                                        <a
                                            href="../instructor/instructor.php?i_id=<?php echo $i_id; ?>"><?php echo $i_name; ?></a>
                                    </h4>
                                    <p style="font-size: 14px;">
                                        <?php echo $i_bio . " Instuctor"; ?>
                                    </p>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="width:30%; padding: 0px;">
                <div class="card" style=" border-radius: 0px; padding-top: 1px;">
                    <div class="card-header text-center">
                        <h5>Course Content</h5>
                    </div>
                    <?php
                    for ($i = 0; $i < $c_no_of_lessons; $i++) {
                        echo '<div id="section1Content" class="accordion-collapse collapse show" aria-labelledby="section1Heading" data-bs-parent="#courseAccordion">' .
                            '<div class="accordion-body">' .
                            '<ul class="list-group" style="border-radius: 0px;">' .
                            '<li class="list-group-item d-flex justify-content-between align-items-center clickable-item" data-action="#"> ' .
                            '<div>' .
                            '<input type="checkbox" class="form-check-input me-2" >' .
                            'Video ' . "$i" .
                            '</div>' .
                            '<span>' . $time[$i] . ' mins' . '</span>' .
                            '</li>
                                        </ul>
                                    </div>
                                </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        </div>
        <!-- Bootstrap Bundle JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </section>


</body>

</html>