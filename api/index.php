<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="images/icons/favicon1.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
	<script src="js/main.js"></script>

    <title>Login</title>
    
    <link rel="stylesheet" type="text/css" href="./CSS/index.css">
    <script src="./JS/button.js"></script>
    		
<!--===============================================================================================-->


</head>

<body>
    <header class="header">
        <nav class="nav">
            <div>
                <img src="./img_web/logo.png" alt="" width="50px" height="50px" />
                <router-link to="/" class="nav_logo">SIT</router-link>
            </div>

            <button class="button" id="form-open" onclick="openForm()">Login</button>
        </nav>
    </header>

    <section class="home">
        <div class="form_container">
            <i class="uil uil-times form_close" onclick="closeForm()"></i>

            <div class="form">
               

				<form  method="post" action="conn.php">
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" name="Username" type="text" placeholder="Enter your ID" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="uil uil-envelope-alt email" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" name="Password" type="password" placeholder="Enter your password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="uil uil-lock password" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button  class="login100-form-btn" class="button" type="submit">
							Login
						</button>
					</div>

					

					
				</form>
		
            </div>
            
        </div>
        
        
    </section>
    

    
</body>

</html>