<?php require_once('conn.php'); ?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Task</title>
  <link rel="stylesheet" type="text/css" href="./CSS/dashboard.css">
  <link rel="stylesheet" type="text/css" href="./CSS/button/button.css">
  <script src="./JS/index.js"></script>
  <script src="./JS/button.js"></script>
  <script src="./JS/butoonLine.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" type="text/css" href="./CSS/button/paper.css">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="images/icons/favicon1.ico"/>
<!--===============================================================================================-->


</head>

<body class="dark-mode">
  <div>
    <section id="sidebar">
      <a href="#" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text">SIT</span>
      </a>
      <ul class="side-menu top">
        <li>
          <a href="Dashboard.php">
            <i class='bx bxs-dashboard'></i>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li class="active">
          <a href="Task.php">
            <!-- <box-icon name='bxs-shopping-bags' type='solid' ></box-icon> -->
            <i class='bx bx-task'></i>
            <span class="text">Task</span>
          </a>
        </li>

        <li>
          <a href="Report.php">
            <i class='bx bxs-report'></i>
            <span class="text">Report</span>
          </a>
        </li>
        <li>
          <a href="Document.php">
            <i class='bx bxs-paper-plane'></i>
            <span class="text">Document</span>
          </a>
        </li>
        <li>
          <a href="Customer.php">
            <i class='bx bxs-user-rectangle'></i>
            <span class="text">Customer</span>
          </a>
        </li>
        <li>
          <a href="Project.php">
            <i class='bx bx-paper-plane'></i>
            <span class="text">Project</span>
          </a>
        </li>

      </ul>
      <ul class="side-menu">
        <li>
          <a href="Edit_Profile.php">
            <i class='bx bxs-cog'></i>
            <span class="text">Edit Profile</span>
          </a>
        </li>
        <li>
          <a href="index.php" class="logout">
            <i class='bx bxs-log-out-circle'></i>
            <span class="text">Logout</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- SIDEBAR -->

    <section class="home">
      <div class="form_container">
        <i class="uil uil-times form_close" onclick="closeForm()"></i>

        <div class="form">
        <form method="post" action="Task.php" enctype="multipart/form-data">
    <h2>Add Task</h2>

    <div class="input_box">
        <input name="task_name" type="text" placeholder="งาน" required />
        <i class="uil uil-work"></i>
    </div>

    <div class="input_box">
        <input name="task_detail" type="text" placeholder="รายละเอียด" required />
        <i class="uil uil-info-circle"></i>
    </div>

    <div class="input_box">
        <select name="pro_customer" required>
            <?php
            
            // แสดงรายการลูกค้าใน list menu
            $sql = "SELECT cus_ID, cus_name FROM customer";
            $result = $assign->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['cus_ID'] . "'>" . $row['cus_name'] . "</option>";
                }
            } else {
                echo "<option value=''>ไม่พบลูกค้า</option>";
            }

           
            ?>
        </select>
        <i class="uil uil-user"></i>
    </div>
    <div class="input_box">
        <select name="task_mem" required>
            <?php
            
            // แสดงรายการลูกค้าใน list menu
            $sql = "SELECT mem_ID, mem_name FROM member";
            $result = $assign->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['mem_ID'] . "'>" . $row['mem_name'] . "</option>";
                }
            } else {
                echo "<option value=''>ไม่พบลูกค้า</option>";
            }

           
            ?>
        </select>
        <i class="uil uil-user"></i>
    </div>

    

    <button class="button" type="submit">Add task</button>
</form>

 
        </div>

      </div>
    </section>

    <!-- CONTENT -->
    <section id="content">
      <!-- NAVBAR -->
      <nav>
        <i class='bx bx-menu'></i>
        <a href="#" class="nav-link">Categories</a>
        <form action="#">
          <div class="form-input">
            <input type="search" placeholder="Search...">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
          </div>
        </form>


        <a href="#" class="profile">
          <img src="./img_web/logo.png">
        </a>
      </nav>
      <!-- NAVBAR -->

      <!-- MAIN -->
      <main>
        <div class="head-title">
          <div class="left">
            <h1>Task</h1>
            <ul class="breadcrumb">
              <li>
                <a href="#">Dashboard</a>
              </li>
              <li><i class='bx bx-chevron-right'></i></li>
              <li>
                <a class="active" href="#">Task</a>
              </li>
            </ul>

          </div>
          <?php echo $row_profile['mem_name']; ?>
          <button class="button" id="form-open" onclick="openForm()">
            <a class="btn-download">
              <i class='bx bxs-book-add'></i>
              <span class="text">Add Task</span>
            </a></button>
        </div>

        <div class="table-data">
          <div class="order">
            <div class="head">

              <i class='bx bx-search'></i>
              <i class='bx bx-filter'></i>
            </div>
            <table>
              <thead>
                <tr>
                  <th>งาน</th>
                  <th>วันที่</th>
                  <th>สถานะ</th>
                  <th>แก้ไขสถานะ</th>
                </tr>
              </thead>
              <tbody>
                <?php
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["task_id"], $_POST["task_status"])) {
                $task_id = $_POST["task_id"];
                $task_status = $_POST["task_status"];

                // Update the task status in the database
                $sql = "UPDATE task SET task_status = '$task_status' WHERE task_ID = $task_id";

                if (mysqli_query($assign, $sql)) {
                    echo "Task status updated successfully";
                } else {
                    echo "Failed to update task status: " . mysqli_error($assign);
                }
            }
        }

        // ส่งคำสั่ง SQL ในการเลือกข้อมูลงาน
        $sql = "SELECT task.*, customer.cus_name FROM task INNER JOIN customer ON task.task_customer = customer.cus_ID ORDER BY CASE WHEN task_status = 'C' THEN 3 WHEN task_status = 'R' THEN 2 ELSE 1 END";

        $result = mysqli_query($assign, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                  <td><?php echo $row['task_name']; ?></td>

                  <td><?php echo $row['created_at']; ?></td>
                  <td>
                    <?php if ($row['task_status'] == 'P'): ?>
                    <span class="status pending">
                      <?php elseif ($row['task_status'] == 'R'): ?>
                      <span class="status process">
                        <?php elseif ($row['task_status'] == 'C'): ?>
                        <span class="status completed">
                          <?php endif; ?>
                          <?php echo $row['task_status']; ?>
                        </span>
                  </td>
                  <td>
                  <form method="post" action="Task.php">
  <input type="hidden" name="task_id" value="<?php echo $row['task_ID']; ?>" />
  <select name="task_status" onchange="this.form.submit()">
    <option value="P" <?php echo ($row['task_status'] == 'P') ? 'selected' : ''; ?>>Pending</option>
    <option value="R" <?php echo ($row['task_status'] == 'R') ? 'selected' : ''; ?>>Process</option>
    <option value="C" <?php echo ($row['task_status'] == 'C') ? 'selected' : ''; ?>>Completed</option>
  </select>
</form>


                  </td>
                  <td>
                    <button
                      onclick="showDetails('<?php echo $row['task_name']; ?>', '<?php echo $row['task_detail']; ?>', '<?php echo $row['cus_name']; ?>')">แสดงรายละเอียด</button>
                  </td>
                  <td>
                    <button
                      onclick="toggleDetails('<?php echo $row['task_name']; ?>', '<?php echo $row['task_detail']; ?>', '<?php echo $row['cus_name']; ?>')">เช็คอิน</button>
                  </td>



                  <div id="popup" class="paper popup">
  <div class="paper-dialog">
    <div class="paper-dialog-container">
      <div class="paper-dialog-content">
        <h2 id="taskName"></h2>
        <p id="taskDetail"></p>
        <p id="cusName"></p>
      </div>
      <div class="paper-dialog-buttons">
        <button class="button button-primary" onclick="closePopup()">ปิด</button>
      </div>
    </div>
  </div>
</div>

<script>
  function showDetails(taskName, taskDetail, cusName) {
    document.getElementById("taskName").innerText = "รายละเอียดงาน: " + taskName;
    document.getElementById("taskDetail").innerText = "รายละเอียดเพิ่มเติม: " + taskDetail;
    document.getElementById("cusName").innerText = "ชื่อลูกค้า: " + cusName;
    document.getElementById("popup").classList.add("active");
  }

  function closePopup() {
    document.getElementById("popup").classList.remove("active");
  }
</script>



                <?php
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

?>