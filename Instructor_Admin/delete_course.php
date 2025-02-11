<?php
// Database connection
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "e_learning");

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Check if the courseId is set
if (isset($_POST['courseId'])) {
    $courseId = $_POST['courseId']; // Sanitize input to prevent SQL injection

    // Delete the course from the database
    $sql1 = "DELETE FROM course WHERE c_id = " . $courseId;
    $sql2 = "DELETE FROM old_cart WHERE c_id = " . $courseId;
    $sql3 = "DELETE FROM student_cart WHERE c_id = " . $courseId;
    if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3))
        echo json_encode(['success' => true, 'message' => 'Course deleted successfully']);
    else
        echo json_encode(value: ['success' => false, 'message' => 'Invalid request: course not deleted']);
} else {
    echo json_encode(value: ['success' => false, 'message' => 'Invalid request: courseId not provided']);
}

// Close the database connection
mysqli_close($conn);
?>