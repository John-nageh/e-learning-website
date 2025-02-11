<?php
session_start();
header('Content-Type: application/json'); // Return JSON response

$user_id = $_SESSION['i_id'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "e_learning");
if (!$conn) {
    echo json_encode(['success' => false, 'message' => mysqli_connect_error()]);
    exit;
}

// Retrieve and sanitize input values
$profileName = $_POST['profileName'];
$profileEmail = $_POST['profileEmail'];
$profilePhone = $_POST['profilePhone'];

if (!empty($_FILES['profileImage']['name'])) {
    $targetDir = "../home/images/";
    $fileName = basename($_FILES['profileImage']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validate file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFilePath)) {
            $profileImagePath = "images/" . $fileName;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload profile image']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit;
    }
} else {
    $profileImagePath = null; // No new image uploaded
}

// Update the database
$sql = "UPDATE instructor 
        SET i_name = '$profileName', 
            i_email = '$profileEmail', 
            i_phone = '$profilePhone'";

if ($profileImagePath) {
    $sql .= ", i_image = '$profileImagePath'";
}

$sql .= " WHERE i_id = '$user_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>