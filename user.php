<?php
session_start();
require('conn.php');

function convertToThaiDate($date)
{
    // Convert the date to DateTime object
    $datetime = new DateTime($date);

    // Define Thai month names
    $thai_months = array(
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม'
    );

    // Get day, month, and year
    $day = $datetime->format('j'); // Day without leading zero
    $month = $thai_months[(int)$datetime->format('n')]; // Translate month to Thai
    $year = (int)$datetime->format('Y') + 543 + 1; // Convert AD to BE (Buddhist Era) +1 เพราะต้องปัดเป็นปีงบ

    // Return formatted date in Thai
    return "{$year}";
}

function highlightYear($year, $selectedYear)
{
    return $year == $selectedYear ? 'btn-info' : 'btn-outline-info';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="health-check.png" />
    <title>Health Checkup Results</title>

</head>
<style>
    body {
        font-family: 'Prompt';
    }

    .dot {
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
    }
</style>

<body style="background-color: darkslategrey;">
    <?php

    if (isset($_GET['year'])) {
        $selectedYear = $_GET['year'];
    } else {
        $selectedYear = date("Y") - 1; //ปีเริ่มต้น
    }
    // echo $selectedYear;
    if (isset($_SESSION['cid'])) {
        $cid = $_SESSION['cid'];

        // $y = date("Y") - 1;
        // ดึงเฉพาะ 2 หลักท้ายของปี

        $shortYear = substr($selectedYear, -2);
        // echo $shortYear;

        require('sql.php');
    ?>
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <?php if ($row = $result_sql->fetch_assoc()) { ?>
                            <div class="card-header">
                                <h3 class="card-title text-center mb-0">ผลการตรวจสุขภาพประจำปี <?= convertToThaiDate($row['vstdate']) ?></h3>
                            </div>
                            <div class="p-2 border">
                                <div class="">
                                    <p class="mb-0"><?= $row['fullname'] ?></p>
                                </div>
                                <div class="container text-start p-0 ">
                                    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
                                        <div class="col ">
                                            <div class="">ส่วนสูง <?= $row['height'] ?> ซม.</div>
                                        </div>
                                        <div class="col ">
                                            <div class="">น้ำหนัก <?= $row['bw'] ?> กก.</div>
                                        </div>
                                        <div class="col ">
                                            <div class="">อายุ <?= $row['age_y'] ?> ปี</div>
                                        </div>
                                        <div class="col ">
                                            <div class="">เพศ <?= $row['name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border">
                                <div class="container text-center p-0">
                                    <div class="row row-cols-3 row-cols-lg-5 g-2 g-lg-3">
                                        <div class="col p-0">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="dot" style="background-color: green;"></span>
                                                <span class="ms-1">ปกติ</span>
                                            </div>
                                        </div>
                                        <div class="col p-0">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="dot" style="background-color: yellow;"></span>
                                                <span class="ms-1">มีความเสี่ยง</span>
                                            </div>
                                        </div>
                                        <div class="col p-0">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="dot" style="background-color: red;"></span>
                                                <span class="ms-1">ควรพบแพทย์</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ดัชนีมวลกาย</th>
                                        <td><?= $row['bmi']; ?>
                                            <?php
                                            if ($row['bmi'] < 18.5) {
                                                echo '<span class="dot" style="background-color: red;"></span>';
                                            } elseif ($row['bmi'] >= 18.6 && $row['bmi'] <= 22.9) {
                                                echo '<span class="dot" style="background-color: green;"></span>';
                                            } elseif ($row['bmi'] >= 23.0 && $row['bmi'] <= 24.9) {
                                                echo '<span class="dot" style="background-color: yellow;"></span>';
                                            } elseif ($row['bmi'] >= 25.0 && $row['bmi'] <= 29.9) {
                                                echo '<span class="dot" style="background-color: yellow;"></span>';
                                            } elseif ($row['bmi'] > 30.0) {
                                                echo '<span class="dot" style="background-color: red;"></span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">รอบเอว</th>
                                        <td>
                                            <?= $row['waist']; ?>
                                            <?php
                                            if ($row['waist'] >= 90 && $row['name'] == 'ชาย') {
                                                echo '<span class="dot" style="background-color: yellow;"></span>';
                                            } elseif ($row['waist'] >= 80 && $row['name'] == 'หญิง') {
                                                echo '<span class="dot" style="background-color: yellow;"></span>';
                                            } else {
                                                echo '<span class="dot" style="background-color: green;"></span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ความดันโลหิตค่าบน</th>
                                        <td><?= $row['bps']; ?>
                                            <?php
                                            if ($row['bps'] >= 90 && $row['bps'] <= 140) {
                                                echo '<span class="dot" style="background-color: green;"></span>';
                                            } else {
                                                echo '<span class="dot" style="background-color: yellow;"></span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ความดันโลหิตค่าล่าง</th>
                                        <td><?= $row['bpd']; ?>
                                            <?php
                                            if ($row['bpd'] >= 60 && $row['bpd'] <= 90) {
                                                echo '<span class="dot" style="background-color: green;"></span>';
                                            } else {
                                                echo '<span class="dot" style="background-color: yellow;"></span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ความดันโลหิต</th>
                                        <td><?php
                                            if (($row['bps'] >= 90 && $row['bps'] <= 140) && (($row['bpd'] >= 60 && $row['bpd'] <= 90))) {
                                                echo '<span>ปกติ</span>';
                                            } else {
                                                echo '<span>ความดันสูง</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">เอกซเรย์</th>
                                        <td><?= $row['xray']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ผลตรวจปัสสาวะ</th>
                                        <td>
                                            <?php
                                            if (($row['Color'] != 'Yellow') &&
                                                ($row['App'] != 'Clear') &&
                                                ($row['Ph'] >= 4.6 && $row['Ph'] <= 8.00) &&
                                                ($row['Spg'] >= 1.003 && $row['Spg'] <= 1.030) &&
                                                ($row['Pro'] != 'Negative') &&
                                                ($row['Bld'] != 'Negative') &&
                                                ($row['WBC'] != '0-1' && $row['WBC'] != '0-2' && $row['WBC'] != '0-3' && $row['WBC'] != '0-4' && $row['WBC'] != '0-5') &&
                                                ($row['RBC'] != '0-1' && $row['RBC'] != '0-2')($row['EPI'] != '0-1')
                                            ) {
                                                echo '<span>ผิดปกติ</span>';
                                            } else {
                                                echo '<span>ปกติ</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ความสมบูรณ์ของเลือด</th>
                                        <td>
                                            <?php
                                            if ($row['Hct'] >= 37 && $row['Hct'] <= 52) {
                                                echo '<span>ปกติ</span>';
                                            } else {
                                                echo '<span>โลหิตจาง</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">น้ำตาลในเลือด</th>
                                        <td>
                                            <?php
                                            if (is_null($row['FBS']) || $row['FBS'] === '') {
                                                echo '-';
                                            } elseif ($row['FBS'] >= 74 && $row['FBS'] <= 106) {
                                                echo '<span>ปกติ</span>';
                                            } else {
                                                echo '<span>น้ำตาลสูง</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ไขมันในเลือด</th>
                                        <td>
                                            <?php
                                            if (is_null($row['Chol']) || $row['Chol'] === '') {
                                                echo '-';
                                            } elseif ($row['Chol'] > 200) {
                                                echo '<span>ไขมันสูง</span>';
                                            } else {
                                                echo '<span>ปกติ</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">กรดในไขข้อ</th>
                                        <td>
                                            <?php
                                            if (is_null($row['Uricacid']) || $row['Uricacid'] === '') {
                                                echo '-';
                                            } elseif ($row['Uricacid'] >= 3.5 && $row['Uricacid'] <= 7.2) {
                                                echo '<span>ปกติ</span>';
                                            } else {
                                                echo '<span>ผิดปกติ</span>';
                                            }
                                            ?>
                                        </td>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">การทำงานของไต</th>
                                        <td>
                                            <?php
                                            if ((is_null($row['BUN']) || $row['BUN'] === '') || (is_null($row['Cr']) || $row['Cr'] === '')) {
                                                echo '-';
                                            } elseif (($row['BUN'] >= 8 && $row['BUN'] <= 20) && ($row['Cr'] >= 0.72 && $row['Cr'] <= 1.18)) {
                                                echo '<span>ปกติ</span>';
                                            } else {
                                                echo '<span>ผิดปกติ</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">การทำงานของตับ</th>
                                        <td>
                                            <?php
                                            if ((is_null($row['ALK']) || $row['ALK'] === '') ||
                                                (is_null($row['AST']) || $row['AST'] === '') ||
                                                (is_null($row['ALT']) || $row['ALT'] === '')
                                            ) {
                                                echo '-';
                                            } elseif (($row['ALK'] >= 30 && $row['ALK'] <= 120) &&
                                                ($row['AST'] >= 0 && $row['AST'] <= 50) &&
                                                ($row['ALT'] >= 0 && $row['ALT'] <= 50)
                                            ) {
                                                echo '<span>ปกติ</span>';
                                            } else {
                                                echo '<span>ผิดปกติ</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <th class="bg-info-subtle text-start" style="width: 50%;">ผลการตรวจคลื่นหัวใจ</th>
                                        <td><?= $row['heart']; ?></td>
                                    </tr> -->
                                </table>
                            </div>
                        <?php } ?>
                        <div class="card-footer text-center">
                            <!-- Buttons for selecting year -->
                            <a href="?year=<?= date("Y") - 3 ?>" class="btn <?= highlightYear(date("Y") - 3, $selectedYear); ?>"><?= date("Y") + 543 - 2 ?></a>
                            <a href="?year=<?= date("Y") - 2 ?>" class="btn <?= highlightYear(date("Y") - 2, $selectedYear); ?>"><?= date("Y") + 543 - 1 ?></a>
                            <a href="?year=<?= date("Y") - 1 ?>" class="btn <?= highlightYear(date("Y") - 1, $selectedYear); ?>"><?= date("Y") + 543 ?></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container mt-5">
            <div class="alert alert-warning text-center">
                ไม่พบข้อมูล
            </div>
        </div>
    <?php } ?>
</body>

</html>