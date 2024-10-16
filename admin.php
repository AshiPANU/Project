<?php
include "config.php";

$current_month = date('m');
$current_year = date('Y');

$query = "SELECT COUNT(*) AS new_customers FROM customers WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $current_month, $current_year); // ใช้ 'ii' สำหรับค่า integer ของเดือนและปี
$stmt->execute();
$stmt->bind_result($new_customers);
$stmt->fetch(); // ดึงข้อมูลจำนวนลูกค้าใหม่
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
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
        <div class="content1">
            <div class="subcontent">
                <div class="small-box">
                    <div class="inner text-center">
                        <h1 class="#">ผู้ดูแลระบบ</h1>
                    </div>
                    <a href="manage_users.php" class="small-box-footer"> คลิกจัดการระบบ <i class="#"></i></a>
                </div>
            </div>
            <div class="subcontent">
                <div class="small-box">
                    <div class="inner text-center">
                        <h1 class="#">รายชื่อลูกค้า</h1>
                    </div>
                    <a href="customers.php" class="small-box-footer "> คลิกจัดการระบบ <i class="#"></i></a>
                </div>
            </div>
            <div class="subcontent">
                <div class="small-box">
                    <div class="inner text-center">
                        <h1 class="py-3">รายการสินค้า</h1>
                    </div>
                    <a href="product.php" class="small-box-footer"> คลิกจัดการระบบ <i class="#"></i></a>
                </div>
            </div>
            <div class="subcontent">
                <div class="small-box">
                    <div class="inner text-center">
                        <h1 class="#">รายการสั่งซื้อ</h1>
                    </div>
                    <a href="#" class="small-box-footer"> คลิกจัดการระบบ <i class="#"></i></a>
                </div>
            </div>
        </div>
        <div class="content2">
            <div class="subcontent">
                <div class="small-box ">
                    <div class="inner">
                        <h3></h3>
                        <p class="text-danger">ยอดขายประจำวัน</p>
                    </div>
                </div>
                <div class="subcontent">
                    <div class="small-box">
                        <div class="inner">
                            <h3></h3>
                            <p class="text-danger">ยอดขาย 7 วันที่ผ่านมา</p>
                        </div>
                    </div>
                </div>
                <div class="subcontent">
                    <div class="small-box">
                        <div class="inner">
                            <h3></h3>
                            <p class="text-danger">ยอดคำสั่งซื้อประจำวัน</p>
                        </div>
                    </div>
                </div>
                <div class="subcontent">
                    <div class="small-box">
                        <div class="inner">
                            <h3><?php echo $new_customers; ?> คน</h3>
                            <p class="text-danger">ลูกค้าหน้าใหม่ในเดือนนี้</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>