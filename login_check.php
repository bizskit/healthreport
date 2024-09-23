<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js "></script>
<link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css " rel="stylesheet">
<?php
require('conn.php');
session_start(); // ย้าย session_start() ขึ้นมาที่บรรทัดแรก

// ตรวจสอบว่ามีการส่งข้อมูล cid และ password มาจากฟอร์ม
if (isset($_POST['cid'])) {
    $cid = $_POST['cid'];
    // $password = md5($_POST['password']); // เข้ารหัสรหัสผ่านด้วย MD5 ก่อน

    // ใช้ prepared statements เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare("SELECT cid FROM patient WHERE cid = ? ");
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['cid'] = $cid;

        echo "
            <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful',
                    text: 'ล็อคอินสำเร็จ',
                }).then(function() {
                    window.location = 'user.php';
                });
            });
            </script>
            ";
    } else {
        // กรณีไม่พบผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
        echo "
        <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                title: 'User Not Found',
                text: 'ไม่พบข้อมูลผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            }).then(function() {
                window.location = 'index.php';
            });
        });
        </script>
        ";
    }

    $stmt->close();
} else {
    // กรณีไม่ได้ส่งข้อมูล cid หรือ password
    echo "
    <script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            title: 'No Data',
            text: 'กรุณากรอกข้อมูลบัตรประชาชนและรหัสผ่าน',
        }).then(function() {
            window.location = 'index.php';
        });
    });
    </script>
    ";
    exit();
}
?>