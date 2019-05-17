<?php 
	require_once('../config.php');
	date_default_timezone_set('Asia/Singapore');
	session_start();
	$ora_conn = wms_uat();


if(isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$locations = $_POST['locations'];


	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);


	$connection = mysql_connect("localhost","root"); 
	if(!$connection) { 
	   die("Database connection failed: " . mysql_error()); 
	}else{
	   $db_select = mysql_select_db("users_turnaroundtime",$connection); 
	   if (!$db_select) { 
	       die("Database serialize(value)lection failed:: " . mysql_error()); 
	   } 
	}


	$result = mysql_query("SELECT * from employers where user_id = '$username' and password = '$password'") or die("failed to query db".mysql_error() );
	$row = mysql_fetch_array($result);

	if($row == 0 ) {
		echo "account doesn't exist";
	}

	if($row['user_id'] == $username && $row['password' == $password] && $row['location'] == $locations) { 

		$_SESSION['username'] = $username;
		$_SESSION['location'] = $locations;

		if($row['user_type'] == 'user') {
			if($row['loc_type'] == 'WH') {

				header('Location: ../warehouse.php');
			} else if($row['loc_type'] == 'ST') {
				header('Location: ../store.php');
			} else {
				echo "account not identified";
			}
		} else if($row['user_type' == 'admin']) {
			header('Location: ../admin.php');
		}


	}
	else {
		$error = "Invalid Input";

	}


}

?>