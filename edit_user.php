<?php
session_start();
include "config.php"; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่าได้รับ ID มาหรือไม่
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

// ดึงข้อมูลผู้ใช้ตาม ID
$id = $_GET['id'];
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: manage_users.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // อัปเดตข้อมูลผู้ใช้
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $usertier = $_POST['usertier'];

    $update_query = "UPDATE user SET name = ?, lastname = ?, username = ?, usertier = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('ssssi', $name, $lastname, $username, $usertier, $id);
    if ($update_stmt->execute()) {
        $_SESSION['success'] = "อัปเดตข้อมูลผู้ใช้เรียบร้อยแล้ว";
        header("Location: manage_users.php");
        exit();
    } else {
        $_SESSION['error'] = "มีข้อผิดพลาดในการอัปเดตข้อมูล";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขผู้ใช้</title>
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>
    <div class="container">
        <h2>แก้ไขข้อมูลผู้ใช้</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="" method="post">
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required placeholder="ชื่อของคุณ">
            <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" required placeholder="นามสกุลของคุณ">
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required placeholder="ชื่อผู้ใช้">
            <select name="usertier" required>
                <option value="seller" <?php echo $user['usertier'] == 'seller' ? 'selected' : ''; ?>>Seller</option>
                <option value="storage" <?php echo $user['usertier'] == 'storage' ? 'selected' : ''; ?>>Storage</option>
                <option value="admin" <?php echo $user['usertier'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <input type="submit" value="อัปเดต" class="form-btn">
        </form>

        <a href="manage_users.php" class="btn">กลับไปยังหน้าจัดการสมาชิก</a>
    </div>
</body>
</html>
