<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['usertier'] = $user['usertier'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['admin_logged_in'] = true;

            if ($_SESSION['usertier'] == 'admin') {
                header("Location: admin.php");
            } elseif ($_SESSION['usertier'] == 'storage') {
                header("Location: storage.php");
            } else {
                header("Location: seller.php");
            }
            exit();
        } else {
            $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <div class="formall">
        <form action="" method="post">
            <img src="logo.png" alt="logo">
            <h3>เข้าสู่ระบบ</h3>
            
            <?php if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            } ?>
            <input type="text" name="username" required placeholder="ชื่อผู้ใช้ของคุณ">
            <input type="password" name="password" required placeholder="รหัสผ่านของคุณ">
            <input type="submit" value="เข้าสู่ระบบ" class="form-btn">
        </form>
    </div>

</body>

</html>