<?php
$mysqli = new mysqli("localhost", "root", "", "login_db"); // 데이터베이스 연결 설정

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // 입력받은 사용자 이름
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 비밀번호 암호화

    // 데이터베이스에 사용자 정보 삽입
    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    echo "회원가입이 완료되었습니다!";
}
?>

<form method="post" action="register.php">
    <input type="text" name="username" placeholder="사용자 이름" required>
    <input type="password" name="password" placeholder="비밀번호" required>
    <button type="submit">회원가입</button>
</form>
