<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js "></script>
<link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css " rel="stylesheet">

<?php
require 'conn.php';
require 'vendor/autoload.php';

set_time_limit(600);

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];

    // โหลดไฟล์ Excel
    $spreadsheet = IOFactory::load($file);

    // ระบุ Sheet ที่ต้องการ (เช่น Sheet ที่ 2)
    $spreadsheet->setActiveSheetIndex(1);  // ใช้ Index ของ Sheet ที่ต้องการ
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    $sql = "INSERT INTO `report` (`id_report`, `id_card`, `fullname`, `age`, `sex`, `bmi`, `waist`, `systolic`, `diastolic`, `bpressure`, `bcompleteness`, `bsugar`, `xray`, `urine`, `liver`, `synovialacid`, `kidney`, `bfat`, `heart`, `date`) VALUES ";

    $values = [];
    foreach ($data as $index => $col) {
        if ($index < 9) {
            continue;
        }
        
        // ตรวจสอบว่าทุกค่าว่างหรือไม่
        if (empty(array_filter($col))) {
            break; // หยุดลูปเมื่อพบว่า row นั้นเป็นค่าว่างทั้งหมด
        }

        $id_card = $col[2];
        $fullname = $col[3];
        $age = $col[4];
        $sex = $col[5];
        $bmi = $col[43];
        $waist = $col[40];
        $systolic = $col[7];
        $diastolic = $col[9];
        $bpressure = $col[20];
        $bcompleteness = $col[22];
        $bsugar = $col[23];
        $xray = $col[29];
        $urine = $col[28];
        $liver = $col[27];
        $synovialacid = $col[26];
        $kidney = $col[25];
        $bfat = $col[24];
        $heart = $col[39];
        $date = $col[46];
    
        $values[] = "('','$id_card','$fullname','$age','$sex','$bmi','$waist','$systolic','$diastolic','$bpressure','$bcompleteness','$bsugar','$xray','$urine','$liver','$synovialacid','$kidney','$bfat','$heart','$date')";
    }
    
    if (!empty($values)) {
        $sql .= implode(",", $values);
        $conn->query($sql);
    }
    
    echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'success',
                    text: 'อัพโหลดสำเร็จ',
                    icon: 'success',
                    timer: '5000',
                    showConfirmButton: false
                });
            });
          </script>";
    header('refresh:2; url=importexecl.php');
} else {
    echo "No file uploaded.";
}

$conn->close();
