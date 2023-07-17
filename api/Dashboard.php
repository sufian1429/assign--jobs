<?php require_once('conn.php'); ?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="./CSS/dashboard.css">
    <link rel="stylesheet" type="text/css" href="./CSS/button/buttonPro.css">
    <script src="./JS/index.js"></script>
    <script src="./JS/buttonPro.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script src="./JS/pdf.js"></script>
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
    <li class="active">
      <a href="Dashboard.php">
        <i class='bx bxs-dashboard' ></i>
        <span class="text">Dashboard</span>
      </a>
    </li>
    <li>
      <a href="Task.php">
		
        <i class='bx bx-task' ></i>
        <span class="text">Task</span>
      </a>
    </li>
    <li>
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
    
      <a href="<?php echo $logoutAction ?>" class="logout" action="conn.php">
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

  <!-- MAIN -->
  <main>
    <div class="head-title">
      <div class="left">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
          <li>
            <a href="#">Dashboard</a>
          </li>
          <li><i class='bx bx-chevron-right' ></i></li>
          <li>
            <a class="active" href="#">Home</a>
          </li>
        </ul>
      </div>

      <a href="#" class="btn-download" id="btn-download">
  <i class='bx bxs-cloud-download'></i>
  <span class="text">Download PDF</span>
</a>


    </div>

    <ul class="box-info">
      <li>
        <i class='bx bxs-bx bx-task'></i>
        <span class="text">
          <h3><?php echo $totalTasks; ?></h3>
          <p>ALL Task</p>
        </span>
      </li>
      <li>
        <i class='bx bxs-group'></i>
        <span class="text">
          <h3><?php echo $totalMembers; ?></h3>
          <p>All Member</p>
        </span>
      </li>
      <li>
        <i class='bx bxs-report' ></i>
        <span class="text">
          <h3><?php echo $totalReports ; ?></h3>
          <p>Report</p>
        </span>
      </li>
    </ul>

    <div class="table-data">
      <div class="order">
        <div class="head">
          <h3>Task</h3>
          <i class='bx bx-search' ></i>
          <i class='bx bx-filter' ></i>
        </div>
        <table>
          <thead>
            <tr>
              <th>งาน</th>            
              <th>วันที่</th>
              <th>สถานะ</th>
            </tr>
          </thead>
          <tbody>
            <?php
              

              // Perform the query to fetch data from the task table
              $query = "SELECT task_name, created_at, task_status FROM task ORDER BY CASE WHEN task_status = 'P' THEN 1 WHEN task_status = 'R' THEN 2 WHEN task_status = 'C' THEN 3 ELSE 4 END, created_at ASC LIMIT 4";
              $result = mysqli_query($assign, $query);

              // Define an array to store the order of status
              $statusOrder = ['P', 'R', 'C'];

              // Loop through the result set and output each row as a table row
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['task_name'] . "</td>";
                  echo "<td>" . $row['created_at'] . "</td>";
                  echo "<td>";

                  // Get the index of the current status in the statusOrder array
                  $statusIndex = array_search($row['task_status'], $statusOrder);

                  // Assign the appropriate CSS class based on the status index
                  $statusClass = "";
                  if ($statusIndex === 0) {
                      $statusClass = "pending";
                  } elseif ($statusIndex === 1) {
                      $statusClass = "process";
                  } elseif ($statusIndex === 2) {
                      $statusClass = "completed";
                  }

                  echo "<span class='status " . $statusClass . "'>" . $row['task_status'] . "</span>";
                  echo "</td>";
                  echo "</tr>";
              }

              // Free the result set
              mysqli_free_result($result);

              
            ?>
          </tbody>
        </table>
      </div>

      <div class="todo">
        <div class="head">
          <h3>All Member</h3>
          <i class='bx bx-plus' ></i>
          <i class='bx bx-filter' ></i>
        </div>
        <ul class="todo-list">
          <?php
           

            // Perform the query to fetch all member names
            $query = "SELECT mem_name FROM member";
            $result = mysqli_query($assign, $query);

            // Generate the list of member names
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>";
                echo "<p>" . $row['mem_name'] . "</p>";
                echo "<i class='bx bx-dots-vertical-rounded'></i>";
                echo "</li>";
            }

            // Free the result set
            mysqli_free_result($result);

            
            
          ?>
        </ul>
      </div>
    </div>
  </main>
  <!-- MAIN -->
</section>

    <!-- CONTENT -->
</div>
</body>
</html>



