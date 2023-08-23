<?php 
session_start(); 
include "database_connect.php";

if (isset($_POST['driver_email']) && isset($_POST['driver_password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$email = validate($_POST['driver_email']);
	$pass = validate($_POST['driver_password']);

	if (empty($email)) {
		header("Location: ../motorist_login?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: ../motorist_login.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM motorist_users WHERE driver_email='$email' AND driver_password='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['driver_email'] === $email && $row['driver_password'] === $pass) {
            	$_SESSION['driver_email'] = $row['driver_email'];
            	$_SESSION['driver_name'] = $row['driver_name'];
            	$_SESSION['user_id'] = $row['user_id'];
            	header("Location: ../MotoristMain.php");
		        exit();
            }else{
				header("Location: ../motorist_login.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: ../motorist_login.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: ../motorist_login.php");
	exit();
}