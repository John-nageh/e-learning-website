<?php
session_start();

if (!isset($_SESSION['s_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['c_id'])) {
        $c_id = $data['c_id'];
        $s_id = $_SESSION['s_id'];

        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "e_learning");
        if (!$conn)
            echo mysqli_connect_error();

        // Insert into student_cart table
        $sql = "SELECT * FROM `student_cart` WHERE s_id = $s_id and c_id = $c_id;";
        $result1 = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result1) == 0) {
            $sql = "INSERT INTO `student_cart` (`s_id`, `c_id`) VALUES ('$s_id', '$c_id')";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Course is added to the cart successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['success' => true, 'message' => 'the Course is already in your cart']);
        }

        mysqli_close($conn);
    } else {
        echo json_encode(['success' => false, 'message' => 'Course ID is missing']);
    }
}
?>