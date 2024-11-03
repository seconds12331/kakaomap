<?php
session_start();
$conn = new mysqli("localhost", "root", "", "your_database_name");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $userPassword = $_POST['user_password'];

    $sql = "SELECT * FROM users WHERE username='$userId' AND password='$userPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $userId;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
$conn->close();
?>
