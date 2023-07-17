<?php
require_once('Connections/assign.php');
session_start();


if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($assign, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = $assign->real_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

// Validate request to login to this site.


$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Username'])) {
    $loginUsername = $_POST['Username'];
    $password = $_POST['Password'];
    $MM_fldUserAuthorization = "mem_level";
    $MM_redirectLoginSuccess = "admin/dashboard_admin.php";
    $MM_redirectLoginFailed = "Index.php";
    $MM_redirecttoReferrer = true;

    $assign = mysqli_connect("localhost", "root", "", "assign");
    $query = "SELECT * FROM assign";
    $result = mysqli_query($assign, $query);

    $LoginRS__query = sprintf("SELECT mem_ID, mem_password, mem_level FROM member WHERE mem_ID=%s AND mem_password=%s",
        GetSQLValueString($assign, $loginUsername, "int"), GetSQLValueString($assign, $password, "text"));

    $LoginRS = mysqli_query($assign, $LoginRS__query);
    $loginFoundUser = mysqli_num_rows($LoginRS);

    if ($loginFoundUser) {
        $loginStrGroup = mysqli_fetch_assoc($LoginRS)['mem_level'];

        if (PHP_VERSION >= 5.1) {
            session_regenerate_id(true);
        } else {
            session_regenerate_id();
        }
        // Declare two session variables and assign them
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;

        if (isset($_SESSION['PrevUrl']) && $MM_redirecttoReferrer) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }
        
        header("Location: " . $MM_redirectLoginSuccess);
        exit;
    } else {
        header("Location: " . $MM_redirectLoginFailed);
        exit;
    }
}

?>


<?php



// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
    //to fully log out a visitor we need to clear the session variables
    $_SESSION['MM_Username'] = NULL;
    $_SESSION['MM_UserGroup'] = NULL;
    $_SESSION['PrevUrl'] = NULL;
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['PrevUrl']);

    $logoutGoTo = "Index.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo");
        exit;
    }
}



$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page ***
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;

    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = explode(",", $strUsers);
        $arrGroups = explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}

$MM_restrictGoTo = "Index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit;
}



// ...

$query_Name = "SELECT * FROM member WHERE mem_ID = ?";
$stmt = $assign->prepare($query_Name);
$stmt->bind_param("i", $colname_Name);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row_Name = $result->fetch_assoc();
        $totalRows_Name = $result->num_rows;

        // Perform other operations you want to do

    } else {
        // No user found in the database
    }
} else {
    // Error executing SQL query
    echo "Error executing SQL: " . $stmt->errno . " - " . $stmt->error;
}

$stmt->close();




// Perform the query to count the total number of tasks
$query = "SELECT COUNT(*) AS totalTasks FROM task";
$result = mysqli_query($assign, $query);

// Fetch the result
$row = mysqli_fetch_assoc($result);
$totalTasks = $row['totalTasks'];

// Free the result set
mysqli_free_result($result);

// Perform the query to count the total number of members
$query = "SELECT COUNT(*) AS totalMembers FROM member";
$result = mysqli_query($assign, $query);

// Fetch the result
$row = mysqli_fetch_assoc($result);
$totalMembers = $row['totalMembers'];

// Free the result set
mysqli_free_result($result);
// Perform the query to fetch all report names
$query = "SELECT COUNT(*) AS total_reports FROM report";
$result = mysqli_query($assign, $query);

// Fetch the total number of reports
$row = mysqli_fetch_assoc($result);
$totalReports = $row['total_reports'];
// ...

// ...

// Generate the report list item


// Free the result set
mysqli_free_result($result);
?>



<?php


$colname_profile = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_profile = $_SESSION['MM_Username'];
}

$query_profile = sprintf("SELECT * FROM member WHERE mem_ID = %s", GetSQLValueString($assign, $colname_profile, "int"));
$profile = $assign->query($query_profile) or die($assign->error);
$row_profile = $profile->fetch_assoc();
$totalRows_profile = $profile->num_rows;
?>



<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["MM_update"]) && $_POST["MM_update"] == "form1") {
  $updateSQL = "UPDATE member SET mem_name = ?, mem_img = ?, mem_password = ? WHERE mem_ID = ?";
  $stmt = $assign->prepare($updateSQL);
  $stmt->bind_param("sssi", $_POST['mem_name'], $_POST['mem_img'], $_POST['mem_pass'], $_POST['ID']);
  $stmt->execute();
  $stmt->close();

  $updateGoTo = "Edit_Profile.php";

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }

  header("Location: $updateGoTo");
  exit;
}


?>

<?php



// ตรวจสอบว่ามีการส่งค่าฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // ตรวจสอบว่ามีการส่งค่าฟอร์มหรือไม่
  if (isset($_POST["task_name"], $_POST["task_detail"], $_POST["task_customer"])) {
      // รับค่าที่ส่งมาจากฟอร์ม
      $task_name = $_POST["task_name"];
      $task_detail = $_POST["task_detail"];
      $task_customer = $_POST["task_customer"];

      // ตรวจสอบว่ามีการส่งค่าสถานะงานมาหรือไม่
      if (isset($_POST["task_status"])) {
        $task_status = $_POST["task_status"];

      } else {
        $task_status = "P"; // สถานะเริ่มต้นเป็น "Pending"
      }

      // เตรียมคำสั่ง SQL ในการเพิ่มข้อมูลงาน
      $sql = "INSERT INTO task (task_name, task_detail, task_customer, task_status) VALUES ('$task_name', '$task_detail', '$task_customer', '$task_status')";

      // ส่งคำสั่ง SQL ไปประมวลผล
      if (mysqli_query($assign, $sql)) {
          echo "เพิ่มงานเรียบร้อยแล้ว";
      } else {
          echo "การเพิ่มงานล้มเหลว: " . mysqli_error($assign);
      }
    }
    if (isset($_POST['task_status'])) {
      // ดำเนินการเปลี่ยนสถานะของงานตามค่าที่ส่งมาใน $_POST['task_status']
      $newStatus = $_POST['task_status'];
      // อัปเดตฐานข้อมูลด้วยค่าใหม่
      $updateQuery = "UPDATE task SET task_status = ? WHERE task_ID = ?";
      $stmt = $assign->prepare($updateQuery);
      $stmt->bind_param("si", $newStatus, $_POST['task_id']);
      if ($stmt->execute()) {
        // ดำเนินการอัปเดตสถานะสำเร็จ
        // ทำอะไรก็ตามที่คุณต้องการหลังจากอัปเดตสถานะ
        // เช่น การเปลี่ยนเส้นทางหรือโหลดหน้าเว็บใหม่
        header("Location: Task.php");
        exit;
      } else {
        // เกิดข้อผิดพลาดในการอัปเดตฐานข้อมูล
        echo "Error updating task status: " . $stmt->error;
      }
      $stmt->close();
    }
    
}

ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  date_default_timezone_set("Asia/Bangkok");

  // เชื่อมต่อกับฐานข้อมูล (หรืออื่นๆ ตามที่คุณต้องการ)
  // ...

  // ตรวจสอบว่ามีการส่งแบบ POST มาหรือไม่
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลที่ส่งมาจากแบบฟอร์ม
    $taskName = $_POST['task_name'];
    $taskDetail = $_POST['task_detail'];
    $taskCustomer = $_POST['task_customer'];
    $taskStatus = $_POST['task_status'];
    // ส่งข้อความไปยัง LINE (โดยแปลงข้อมูลตามที่คุณต้องการ)
    // $sToken = "hJ5XvUfQXEoMXLBOAapNAs1qZ16b5sFLPO7tof0C7T0"; //SIT
    $sToken = "gIrNhXW3uyxRhcVWvrkQLBrJWysBVdP8B6n5VgI56FF"; //SIT
    $sMessage = "งาน: $taskName\nรายละเอียดงาน: $taskDetail\nลูกค้า: $taskCustomer";

    $chOne = curl_init(); 
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt($chOne, CURLOPT_POST, 1); 
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
    $headers = array(
      'Content-type: application/x-www-form-urlencoded',
      'Authorization: Bearer '.$sToken.'',
    );
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec($chOne); 

    // ปิดการเชื่อมต่อ CURL
    curl_close($chOne);   

    // เมื่อส่งข้อมูลเสร็จแล้ว ให้เปลี่ยนเส้นทางเพื่อหลีกเลี่ยงการส่งข้อมูลอีกครั้ง
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
  }

?>