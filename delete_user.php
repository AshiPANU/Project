<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = $_GET['id'];
$delete_query = "DELETE FROM user WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    $_SESSION['success'] = "ลบผู้ใช้เรียบร้อยแล้ว";
} else {
    $_SESSION['error'] = "มีข้อผิดพลาดในการลบผู้ใช้";
}
header("Location: manage_users.php");
exit();
