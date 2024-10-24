<?php
session_start();

function generateRandomPassword($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; //ตัวที่สุ่ม
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

$generatedPassword = generateRandomPassword(); // สร้างรหัสผ่านแบบสุ่ม

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "config.php";
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password']; // รหัสผ่านที่ได้รับจากฟอร์ม (ซึ่งจะเป็นรหัสผ่านแบบสุ่ม)
    $usertier = $_POST['usertier'];

    // ตรวจสอบว่ามี username ซ้ำหรือไม่
    $username_check = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($username_check);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userc = $result->fetch_assoc();

    if ($userc) {
        $_SESSION['error'] = "Username นี้มีผู้ใช้แล้ว";
    } else {
        $passwordenc = password_hash($password, PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน

        // เพิ่มผู้ใช้ใหม่ลงในฐานข้อมูล
        $query = "INSERT INTO user (name, lastname, username, password, usertier) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssss', $name, $lastname, $username, $passwordenc, $usertier);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['success'] = "ลงทะเบียนสำเร็จ";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบฟอร์มลงทะเบียน</title>
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<div class="formall">
    <form action="" method="post">
        <h3>ลงทะเบียน</h3>
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
        <input type="text" name="name" required placeholder="ชื่อของคุณ">
        <input type="text" name="lastname" required placeholder="นามสกุลของคุณ">
        <input type="text" name="username" required placeholder="ชื่อผู้ใช้">
        
        <!-- ฟิลด์นี้จะแสดงรหัสผ่านที่ถูกสุ่ม -->
        <input type="text" name="password" value="<?php echo $generatedPassword; ?>" required placeholder="รหัสผ่านของคุณ">
        
        <select name="usertier" required>
            <option value="seller">Seller</option>
            <option value="storage">Storage</option>
            <option value="admin">Admin</option>
        </select>
        <input type="submit" value="ลงทะเบียน" class="form-btn">
    </form>
</div>

</body>
</html>
