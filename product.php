<?php
session_start();
include "config.php";

$query = "SELECT * FROM products";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสินค้า</title>
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/product.css">
</head>

<body>
    <div class="sidenav">
        <img src="logo.png" alt="logo">
        <h2>PTC</h2>
        <a href="admin.php">หน้าแรก</a>
        <a href="customers.php">จัดการสมาชิก</a>
        <a href="product.php">สั่งสินค้า</a>
        <a href="#services">ประวัติ</a>
        <a href="#contact">สินค้าคงคลัง</a>
        <a href="#services">สถานะคำสั่ง</a>
    </div>
    <div class="content">
        <div class="container">
            <h2>รายการสินค้า</h2>

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

            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>รายละเอียด</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>รูปภาพ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['product_code'] . "</td>";
                                echo "<td>" . $row['product_name'] . "</td>";
                                echo "<td>" . $row['product_description'] . "</td>";
                                echo "<td>" . $row['product_price'] . "</td>";
                                echo "<td>" . $row['product_quantity'] . "</td>";
                                echo "<td><img src='uploads/" . $row['product_image'] . "' width='100' height='100'></td>";
                                echo "<td>
                                <a href='edit_product.php?id=" . $row['id'] . "'>แก้ไข</a> |
                                <a href='delete_product.php?id=" . $row['id'] . "' onclick='return confirm(\"คุณต้องการลบสินค้านี้หรือไม่?\");'>ลบ</a>
                            </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>ไม่มีสินค้า</td></tr>";
                        }
                        ?>
                        <div>
                            <a href="add_product.php" class="btn">เพิ่มสินค้า</a>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>