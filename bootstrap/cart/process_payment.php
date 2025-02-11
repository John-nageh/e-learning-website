<?php
session_start();
header('Content-Type: application/json'); // Return JSON response

if (!isset($_SESSION['s_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "e_learning");
if (!$conn) {
    echo json_encode(['success' => false, 'message' => mysqli_connect_error()]);
    exit;
}

// Insert into payment table
$sql = "INSERT INTO `payment`() VALUES ()";
if (!mysqli_query($conn, $sql)) {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    exit;
}

// Get the last inserted payment ID
$p_id = mysqli_insert_id($conn);

// Fetch all courses from the student's cart
$s_id = $_SESSION['s_id'];
$sql = "SELECT * FROM `student_cart` WHERE s_id = $s_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    exit;
}

// Move courses from student_cart to old_cart
while ($row = mysqli_fetch_array($result)) {
    $c_id = $row['c_id'];
    $sql = "INSERT INTO `old_cart`(`p_id`, `s_id`, `c_id`) VALUES ($p_id, $s_id, $c_id)";
    if (!mysqli_query($conn, $sql)) {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        exit;
    }
}

// Delete courses from student_cart
$sql = "DELETE FROM `student_cart` WHERE s_id = $s_id";
if (!mysqli_query($conn, $sql)) {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    exit;
}

mysqli_close($conn);

// Return success response
echo json_encode(['success' => true]);

?>