<?php
// Database connection
session_start();
header('Content-Type: application/json'); // Return JSON response
$conn = mysqli_connect("localhost", "root", "", "e_learning");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the course data from the form
$courseName = $_POST['courseName'];
$coursePrice = $_POST['coursePrice'];
$courseLessons = $_POST['courseLessons'];
$courseLevel = $_POST['courseLevel'];
$i_id = $_SESSION['i_id'];

// Handle file upload if an image was provided;
if (!empty($_FILES['courseImage']['name'])) {
    $targetDir = "../home/images/";
    $fileName = basename($_FILES['courseImage']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validate file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['courseImage']['tmp_name'], $targetFilePath)) {
            $courseImage = "images/" . $fileName;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload profile image']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit;
    }
} else
    $courseImage = 'images/course-3.jpg';

// Prepare and execute the SQL query
$sql = "INSERT INTO course(c_name, c_price, c_no_of_lessons, c_level, c_image, c_desc, i_id) 
        VALUES ('$courseName', '$coursePrice', '$courseLessons', '$courseLevel', '$courseImage', 'best course.', '$i_id')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Course added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
}

// Close the connection
mysqli_close($conn);
?>