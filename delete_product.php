<?php
session_start();
include "config.php";

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $query = "SELECT product_image FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = "uploads/" . $row['product_image'];

        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $delete_query = "DELETE FROM products WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param('i', $product_id);

    if ($delete_stmt->execute()) {
        $_SESSION['success'] = "ลบสินค้าสำเร็จ";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการลบสินค้า";
    }

    header("Location: manage_products.php");
    exit();
} else {
    $_SESSION['error'] = "ไม่พบรหัสสินค้าที่ต้องการลบ";
    header("Location: manage_products.php");
    exit();
}
?>
