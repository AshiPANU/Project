<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    $query = "INSERT INTO customers (company_name, address, phone_number) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $company_name, $address, $phone_number);

    if ($stmt->execute()) {
        $_SESSION['success'] = "เพิ่มลูกค้าเรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการเพิ่มลูกค้า";
    }
}

// ดึงข้อมูล
$query = "SELECT * FROM customers";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข้อมูลลูกค้า</title>
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/customers2.css">
</head>

<body>
    <div class="sidenav">
        <img src="logo.png" alt="logo">
        <h2>PTC</h2>
        <a href="admin.php">หน้าแรก</a>
        <a href="manage_users.php">จัดการสมาชิก</a>
        <a href="#about">สั่งสินค้า</a>
        <a href="#services">ประวัติ</a>
        <a href="#contact">สินค้าคงคลัง</a>
        <a href="#services">สถานะคำสั่ง</a>
    </div>
    <div class="content">
        <div class="container">
            <h2>ข้อมูลลูกค้า</h2>

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

            <form action="" method="post">
                <div>
                    <label for="company_name">ชื่อบริษัท:</label>
                    <input type="text" id="company_name" name="company_name" required>
                </div>
                <div>
                    <label for="address">ที่อยู่:</label>
                    <input type="text" id="address" name="address">
                </div>
                <div>
                    <label for="phone_number">เบอร์โทร:</label>
                    <input type="text" id="phone_number" name="phone_number">
                </div>
                <div>
                    <input type="submit" value="เพิ่มลูกค้า">
                </div>
            </form>

            <h2>รายชื่อลูกค้า</h2>

            <table>
                <thead>
                    <tr>
                        <th>รหัสลูกค้า</th>
                        <th>ชื่อบริษัท</th>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทร</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['customer_id'] . "</td>";
                            echo "<td>" . $row['company_name'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['phone_number'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>ไม่มีข้อมูลลูกค้า</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>