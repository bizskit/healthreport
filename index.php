<?php
session_start();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cid = $_POST['cid']; 
    $password = md5($_POST['password']);

    if ($stmt = $mysqli->prepare("SELECT id, role FROM users WHERE cid = ? AND password = ?")) {
        $stmt->bind_param("ss", $cid, $password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $role);
            $stmt->fetch();

            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            $_SESSION['cid'] = $cid;

            header("Location: user.php");
            exit();
        } else {
            echo "รหัสผ่านไม่ถูกต้อง กรุณาลองอีกครั้ง";
        }

        $stmt->close();
    } else {
        echo "Prepare failed: " . $mysqli->error;
    }
}

if (isset($mysqli)) {
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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

        .login-form {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2 class="text-center">เข้าสู่ระบบ</h2>
            <form method="post">
                <div class="form-group">
                    <label for="cid">กรอกหมายเลขบัตรประชาชน:</label>
                    <input type="text" id="cid" name="cid" class="form-control" required placeholder="กรอกหมายเลขบัตรประชาชน 13 หลัก">
                </div>
                <div class="form-group">
                    <label for="password">กรอกรหัสผ่าน:</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="กรอกรหัสผ่าน">
                </div>
                <button type="submit" class="btn btn-success btn-block">เข้าสู่ระบบ</button>
                <div class="text-right">
                    <br><a href="register.php">สมัครใช้งานระบบ</a>
                </div>
            </form>
        </div>
    </div>

    <!-- เพิ่ม jQuery และ Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
