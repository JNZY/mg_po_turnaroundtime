<?php 

	require_once('../config.php');
	session_start();
	$conn_wms = wms_uat();

	$username = $_POST['username'];
	$password = $_POST['password'];
	$location = $_POST['locations'];
	$location_type = $_POST['location_type'];
	$user_type = $_POST['user_type'];



	if(isset($_POST['submit'])) {

		$connection = mysql_connect("localhost","root"); 
		if(!$connection) { 
		   die("Database connection failed: " . mysql_error()); 
		} else {
		   	$db_select = mysql_select_db("users_turnaroundtime",$connection); 
		  	if (!$db_select) { 
		      die("Database serialize(value)lection failed:: " . mysql_error()); 
		   	} 
		}

		$checkDupe = mysql_query("SELECT * from employers WHERE user_id = '".$username."' ");
		$row = mysql_fetch_array($checkDupe);

		if($row > 0) {
			echo "cannot create username already exist";
		} else {
			$sql = mysql_query("INSERT INTO employers (user_id, password, location, loc_type, user_type) VALUES ('$username', '$password', '$location', '$location_type', '$user_type')");
			if($sql) {
				echo "success";
			} else {
				echo "failed";
			}
		}

		
	}


?>