<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js "></script>
  <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css " rel="stylesheet">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <link rel="icon" type="image/png" href="health-check.png" />
  <title>ระบบนำ excel เข้า database</title>
  <style>
    /* Loader แสดงตรงกลางหน้าจอ */
    .loader-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color:whitesmoke;
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loader {
      border: 16px solid gray;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* เนื้อหาใน body ถูกจางลง */
    .fade {
      opacity: 0.5;
      pointer-events: none;
    }
  </style>
</head>

<body style="background-color: #DBD5A4;">

  <div class="card" id="content" style="margin: 180px 200px 50px 200px;">
    <div class="card-header" style="background-color: #649173;">
      <h3 class="card-title">Import Excel To Database </h3>
    </div>
    <div class="card-body">
      <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm" onsubmit="showLoader()">
        <div class="form-group">
          <div class="input-group mb-3">
            <div class="custom-file">
              <input type="file" id="excelFile" name="excelFile" accept=".xlsx, .xls">
            </div>
          </div>
        </div>
        <button type="submit" id="uploadBtn" class="btn btn-success">Upload</button>
      </form>
    </div>
    <div class="card-footer">
    </div>
  </div>

  <!-- Loader แสดงตรงกลางหน้าจอ -->
  <div class="loader-container" id="loader">
    <div class="loader"></div>
  </div>

  <script>
    // ฟังก์ชันตรวจสอบว่าเลือกไฟล์หรือยัง
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
      const excelFileInput = document.getElementById('excelFile');
      if (!excelFileInput.files.length) {
        event.preventDefault(); // ป้องกันการส่งฟอร์มถ้าไม่ได้เลือกไฟล์
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'กรุณาเลือกไฟล์ก่อนอัปโหลด!'
        });
      }
    });

    // ฟังก์ชันแสดงตัวโหลด และทำให้เนื้อหาจางลง
    function showLoader() {
      // แสดงตัวโหลด
      document.getElementById("loader").style.display = "flex";
      // ทำให้เนื้อหาใน body จางลง
      document.getElementById("content").classList.add("fade");
    }
  </script>

</body>

</html>
