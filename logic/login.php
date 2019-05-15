<?php 

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
	       die("Database selection failed:: " . mysql_error()); 
	   } 
	}


	$result = mysql_query("select * from users where username = '$username' and password = '$password' ") or die("failed to query db".mysql_error() );
	$row = mysql_fetch_array($result);




	if($row['username'] == $username && $row['password' == $password]) { 
		if($locations == '80181 - BD' || $locations == '80001 - LB' || $locations == '80051 - PB' || $locations == '80141 - SI' || $locations == '80151 - LT') {
			if($row['location'] == 'WH' ) {
				header("location: ../warehouse.php");
			} else {
				echo "your account is store only";
			}
		} else {
			if($row['location'] == 'ST' ) {
				header("location: ../store.php");
			} else {
				echo "your account is warehouse only";
			}
		}

	}
	else {
		echo "Wrong input";
	}
	


?>