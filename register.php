<?php
session_start();

// เชื่อมต่อกับฐานข้อมูล
require 'db.php'; // ตรวจสอบว่า path ของไฟล์ถูกต้อง

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cid = $_POST['cid'];
    $password = md5($_POST['password']); // ใช้ MD5 หรือควรใช้วิธีที่ปลอดภัยกว่า
    $role = 'user'; // กำหนดค่าเริ่มต้นให้เป็น 'user'
    $phone = $_POST['phone'];

    // ตรวจสอบว่า CID มีอยู่ในฐานข้อมูลแล้วหรือไม่
    if ($stmt = $mysqli->prepare("SELECT id FROM users WHERE cid = ?")) {
        $stmt->bind_param("s", $cid);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<div class='alert alert-danger'>หมายเลขบัตรประชาชนนี้ได้ลงทะเบียนไว้แล้ว</div>";
        } else {
            // ถ้า CID ยังไม่มีในฐานข้อมูล ให้ทำการลงทะเบียน
            if ($stmt = $mysqli->prepare("INSERT INTO users (cid, password, role, phone) VALUES (?, ?, ?, ?)")) {
                $stmt->bind_param("ssss", $cid, $password, $role, $phone);

                if ($stmt->execute()) {
                    $stmt->close();
                    $mysqli->close();
                    // การเปลี่ยนเส้นทางไปยังหน้า login.php
                    header("Location: login.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                }

            } else {
                echo "<div class='alert alert-danger'>Prepare failed: " . $mysqli->error . "</div>";
            }
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Prepare failed: " . $mysqli->error . "</div>";
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- เพิ่ม Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- เพิ่มฟอนต์ Noto Sans Thai -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;700&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Noto Sans Thai', sans-serif;
    }

    .container {
        max-width: 500px;
        margin-top: 100px;
    }

    .registration-form {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="registration-form">
            <h2 class="text-center">ลงทะเบียนใช้งานระบบ</h2>
            <form method="post">
                <div class="form-group">
                    <label for="cid">หมายเลขบัตรประจำตัวประชาชน 13 หลัก:</label>
                    <input type="text" id <cid" name="cid" class="form-control" required
                        placeholder="กรอกเลขบัตรประชาชน">
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน:</label>
                    <input type="password" id="password" name="password" class="form-control" required
                        placeholder="กรอกรหัสผ่าน">
                </div>
                <div class="form-group">
                    <label for="phone">หมายเลขโทรศัพท์:</label>
                    <input type="text" id="phone" name="phone" class="form-control" minlength="2" maxlength="10"
                        required placeholder="กรอกเบอร์โทรศัพท์">
                </div>
                <button type="submit" class="btn btn-success btn-block">ลงทะเบียน</button>
            </form>
        </div>
    </div>

    <!-- เพิ่ม jQuery และ Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>