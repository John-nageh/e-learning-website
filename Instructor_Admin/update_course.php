
<?php
// Start session and connect to the database
session_start();
header('Content-Type: application/json'); // Respond with JSON
$conn = mysqli_connect("localhost", "root", "", "e_learning");

if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Retrieve POST data
$courseId = $_POST['courseId'];
$courseName = $_POST['courseName'];
$coursePrice = $_POST['coursePrice'];
$courseLessons = $_POST['courseLessons'];
$courseLevel = $_POST['courseLevel'];

// Handle optional image upload
$courseImage = null;
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
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid image type']);
        exit;
    }
}

// Build the SQL query
$sql = "UPDATE course SET 
        c_name = '$courseName', 
        c_price = '$coursePrice', 
        c_no_of_lessons = '$courseLessons'";

if ($courseLevel) {
    $sql .= ", c_level = '$courseLevel'";
}

if ($courseImage) {
    $sql .= ", c_image = '$courseImage'";
}

$sql .= " WHERE c_id = '$courseId'";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Course updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
}

// Close connection
mysqli_close($conn);
?>
