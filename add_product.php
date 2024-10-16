<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    // อัปโหลดรูปภาพ
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ตรวจสอบว่าคือรูปภาพจริงหรือไม่
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $_SESSION['error'] = "ไฟล์ไม่ใช่รูปภาพ";
    }

    // ตรวจสอบว่ามีไฟล์อัพโหลดแล้วหรือไม่
    if (file_exists($target_file)) {
        $_SESSION['error'] = "ไฟล์นี้มีอยู่แล้ว";
        $uploadOk = 0;
    }

    // ตรวจสอบขนาดไฟล์
    if ($_FILES["product_image"]["size"] > 5000000) {
        $_SESSION['error'] = "ไฟล์ใหญ่เกินไป";
        $uploadOk = 0;
    }

    // ตรวจสอบรูปแบบไฟล์
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION['error'] = "อนุญาตเฉพาะไฟล์ JPG, JPEG, PNG เท่านั้น";
        $uploadOk = 0;
    }

    // ตรวจสอบและอัปโหลดไฟล์
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // แค่เก็บชื่อไฟล์ในฐานข้อมูล
            $image_name = basename($_FILES["product_image"]["name"]); // ดึงชื่อไฟล์

            $query = "INSERT INTO products (product_code, product_name, product_description, product_price, product_quantity, product_image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssdss', $product_code, $product_name, $product_description, $product_price, $product_quantity, $image_name);

            if ($stmt->execute()) {
                $_SESSION['success'] = "เพิ่มสินค้าสำเร็จ";
                header("Location: manage_products.php");
                exit();
            } else {
                $_SESSION['error'] = "เกิดข้อผิดพลาดในการเพิ่มสินค้า";
            }
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
        }
    } else {
        $_SESSION['error'] = "ไม่สามารถอัปโหลดรูปภาพได้";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลสินค้า</title>
    <link rel="stylesheet" href="css/add_product.css">
</head>

<body>

    <div class="container">
        <h2>เพิ่มข้อมูลสินค้า</h2>

        <!-- แสดงข้อความเมื่อมีข้อผิดพลาดหรือสำเร็จ -->
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

        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="product_code">รหัสสินค้า:</label>
                <input type="text" id="product_code" name="product_code" required>
            </div>

            <div>
                <label for="product_name">ชื่อสินค้า:</label>
                <input type="text" id="product_name" name="product_name" required>
            </div>

            <div>
                <label for="product_description">รายละเอียดสินค้า:</label>
                <textarea id="product_description" name="product_description" required></textarea>
            </div>

            <div>
                <label for="product_price">ราคา:</label>
                <input type="number" step="0.01" id="product_price" name="product_price" required>
            </div>

            <div>
                <label for="product_quantity">จำนวนสินค้า:</label>
                <input type="number" id="product_quantity" name="product_quantity" required>
            </div>

            <div>
                <label for="product_image">รูปภาพสินค้า:</label>
                <input type="file" id="product_image" name="product_image" accept="image/*" required>
            </div>

            <div>
                <input type="submit" value="เพิ่มสินค้า">
            </div>
            <div>
                <a href="product.php" class="btn">ย้อนกลับ</a>
            </div>
        </form>
    </div>

</body>

</html>