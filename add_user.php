<?php
session_start();
include "config.php"; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $usertier = $_POST['usertier'];

    // แฮชรหัสผ่าน
    $passwordenc = password_hash($password, PASSWORD_DEFAULT);

    // เพิ่มผู้ใช้ใหม่
    $query = "INSERT INTO user (name, lastname, username, password, usertier) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $name, $lastname, $username, $passwordenc, $usertier);
    if ($stmt->execute()) {
        $_SESSION['success'] = "เพิ่มผู้ใช้ใหม่เรียบร้อยแล้ว";
        header("Location: manage_users.php");
        exit();
    } else {
        $_SESSION['error'] = "มีข้อผิดพลาดในการเพิ่มผู้ใช้";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มผู้ใช้</title>
    <link rel="stylesheet" href="css/add_user.css">
</head>
<body>
    <div class="container">
        <h2>เพิ่มผู้ใช้ใหม่</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="" method="post">
            <input type="text" name="name" required placeholder="ชื่อของคุณ">
            <input type="text" name="lastname" required placeholder="นามสกุลของคุณ">
            <input type="text" name="username" required placeholder="ชื่อผู้ใช้">
            <input type="password" name="password" required placeholder="รหัสผ่านของคุณ">
            <select name="usertier" required>
                <option value="seller">Seller</option>
                <option value="storage">Storage</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" value="เพิ่มผู้ใช้" class="form-btn">
        </form>

        <a href="manage_users.php" class="btn">กลับไปยังหน้าจัดการสมาชิก</a>
    </div>
</body>
</html>
