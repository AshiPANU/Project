<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['usertier'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM user";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสมาชิก</title>
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/manage_users.css">
</head>

<body>
    <div class="sidenav">
        <img src="logo.png" alt="logo">
        <h2>PTC</h2>
        <a href="admin.php">หน้าแรก</a>
        <a href="#">จัดการสมาชิก</a>
        <a href="#about">สั่งสินค้า</a>
        <a href="#services">ประวัติ</a>
        <a href="#contact">สินค้าคงคลัง</a>
        <a href="#services">สถานะคำสั่ง</a>
    </div>
    <div class="content">
        <div class="container">
            <h2>จัดการสมาชิก</h2>

            <?php
            if (isset($_SESSION['success'])) {
                echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>ระดับผู้ใช้</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['lastname']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['usertier']; ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>">แก้ไข</a>
                                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบผู้ใช้คนนี้?');">ลบ</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">ไม่มีผู้ใช้ในระบบ</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <a href="add_user.php" class="btn">เพิ่มผู้ใช้ใหม่</a>
            <a href="logout.php" class="btn">ออกจากระบบ</a>
        </div>
    </div>
</body>

</html>