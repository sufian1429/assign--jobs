<?php require_once('conn.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Report</title>
  <link rel="stylesheet" type="text/css" href="./CSS/dashboard.css">
  <script src="./JS/index.js"></script>
  <link rel="stylesheet" type="text/css" href="./CSS/button/button.css">
<script src="./JS/button.js"></script>
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="images/icons/favicon1.ico"/>
<!--===============================================================================================-->

</head>

<body class="dark-mode">
<div >
      <section id="sidebar">
    <a href="#" class="brand">
      <i class='bx bxs-smile'></i>
      <span class="text">SIT</span>
    </a>
    <ul class="side-menu top">
      <li >
        <a href="Dashboard.php">
          <i class='bx bxs-dashboard' ></i>
          <span class="text">Dashboard</span>
        </a>
      </li>
      <li >
        <a href="Task.php">
          
          <i class='bx bx-task' ></i>
          <span class="text">Task</span>
        </a>
      </li>
      
      <li class="active">
        <a href="Report.php">
          <i class='bx bxs-report' ></i>
          <span class="text">Report</span>
        </a>
      </li>
      <li>
        <a href="Document.php">
          <i class='bx bxs-paper-plane' ></i>
          <span class="text">Document</span>
        </a>
      </li>
      <li>
        <a href="Customer.php">
          <i class='bx bxs-user-rectangle' ></i>
          <span class="text">Customer</span>
        </a>
      </li>
      <li>
        <a href="Project.php">
          <i class='bx bx-paper-plane' ></i>
          <span class="text">Project</span>
        </a>
      </li>
      
    </ul>
    <ul class="side-menu">
      <li>
        <a href="Edit_Profile.php">
          <i class='bx bxs-cog' ></i>
          <span class="text">Edit Profile</span>
        </a>
      </li>
      <li>
        <a href="index.php" class="logout">
          <i class='bx bxs-log-out-circle' ></i>
          <span class="text">Logout</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- SIDEBAR -->
  
  
  
  <!-- CONTENT -->
  <section id="content">
    <!-- NAVBAR -->
    <nav>
      <i class='bx bx-menu' ></i>
      <a href="#" class="nav-link">Categories</a>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Search...">
          <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
        </div>
      </form>
     
      
      <a href="#" class="profile">
        <img src="./img_web/logo.png">
      </a>
    </nav>
    <!-- NAVBAR -->
    <section class="home">
    <div class="form_container">
        <i class="uil uil-times form_close" onclick="closeForm()"></i>
        <div class="form">
        <form method="post" action="Report.php" enctype="multipart/form-data">
    <h2>Add Report</h2>

    <div class="input_box">
        <input name="re_name" type="text" placeholder="งาน" required />
        <i class="uil uil-work"></i>
    </div>

    <div class="input_box">
        <input name="re_type" type="text" placeholder="รายละเอียด" required />
        <i class="uil uil-info-circle"></i>
    </div>

    

    <div class="input_box">
        <input name="re_path" type="file" required />
        <i class="uil uil-file-upload"></i>
    </div>

    <button class="button" type="submit">Add Report</button>
</form>
        </div>
    </div>
</section>

    <!-- MAIN -->
    <main>
      <div class="head-title">
        <div class="left">
          <h1>Report</h1>
          <ul class="breadcrumb">
            <li>
              <a href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right' ></i></li>
            <li>
              <a class="active" href="#">Report</a>
            </li>
          </ul>
          
        </div>
        <?php echo $row_profile['mem_name']; ?>
        <button class="button" id="form-open" onclick="openForm()">
        <a  class="btn-download">
          <i class='bx bxs-book-add' ></i>
          <span class="text">Add Report</span>
        </a></button>
      </div>
      
      <div class="table-data">
        <div class="order">
          <div class="head">
            
            <i class='bx bx-search' ></i>
            <i class='bx bx-filter' ></i>
          </div>
          <table>
    <thead>
        <tr>
            <th>งาน</th>
            <th>รายละเอียด</th>
            
            <th>ไฟล์งาน</th>
        </tr>
    </thead>
    <tbody>
        <?php
       

        // เพิ่มเอกสารใหม่เมื่อส่งแบบฟอร์ม
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $re_name = $_POST['re_name'];
            $re_type = $_POST['re_type'];
           

            // อัปโหลดไฟล์งาน
            $target_dir = "file/";
            $target_file = $target_dir . basename($_FILES["re_path"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // ตรวจสอบว่าไฟล์เป็นรูปภาพหรือไม่
            if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
                echo "อัปโหลดไฟล์เฉพาะ PDF, DOC หรือ DOCX เท่านั้นที่อนุญาตให้อัปโหลด";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "อัปโหลดไฟล์ไม่สำเร็จ";
            } else {
                if (move_uploaded_file($_FILES["re_path"]["tmp_name"], $target_file)) {
                    // บันทึกข้อมูลลงในฐานข้อมูล
                    $sql = "INSERT INTO report (re_name, re_type, re_path ) VALUES ('$re_name', '$re_type', '$target_file')";
                    if ($assign->query($sql) === TRUE) {
                        echo "เพิ่มเอกสารเรียบร้อยแล้ว";
                    } else {
                        echo "การบันทึกข้อมูลล้มเหลว: " . $assign->error;
                    }
                } else {
                    echo "พบข้อผิดพลาดในการอัปโหลดไฟล์";
                }
            }
        }

        // แสดงรายการเอกสารทั้งหมดจากฐานข้อมูล
        $sql = "SELECT report.re_name, report.re_type,  report.re_path FROM report ";
        $result = $assign->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['re_name'] . "</td>";
                echo "<td>" . $row['re_type'] . "</td>";
                
                echo "<td><a href='" . $row['re_path'] . "'>ดาวน์โหลด</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>ไม่พบเอกสาร</td></tr>";
        }

        
        ?>
    </tbody>
</table>


        </div>
      </div>
    </main>
    <!-- MAIN -->
  </section>
    </div>
      </body>
</html>

<?php
$profile->free_result();
$assign->close();
?>
