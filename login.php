header('Access-Control-Allow-Origin: https://seconds12331.github.io');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

<?php
session_start();
$conn = new mysqli("localhost", "root", "", "login_db");

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['username'];
    $userPassword = $_POST['password'];

    // 준비된 문을 사용하여 SQL 인젝션 방지
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // 사용자 확인
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // 비밀번호 검증 (예: 비밀번호가 해시된 경우)
        if (password_verify($userPassword, $row['password'])) {
            $_SESSION['username'] = $userId;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }

    $stmt->close();
}

$conn->close();
?>
