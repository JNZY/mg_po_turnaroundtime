<?php 


	$uname = $_POST['username'];
	$locations = $_POST['locations'];
	session_start();

	


	if(isset($_POST['submit'])) {
	$connection = mysql_connect("localhost","root"); 

	if(!$connection) { 
	   die("Database connection failed: " . mysql_error()); 
	}else {
	   $db_select = mysql_select_db("users_turnaroundtime",$connection); 
	   if (!$db_select) { 
	       die("Database serialize(value)lection failed:: " . mysql_error()); 
	   } 
	}

	if(empty($uname || $locations)) {
		$_SESSION['message'] = "Invalid Input";
		header("Location: forgetPassword.php");
	}

	$result = mysql_query("SELECT * from employers where user_id = '$uname' ") or die("failed to query db".mysql_error() );
	$row = mysql_fetch_array($result);

	if($row == 0 ) {
		$_SESSION['message'] = "Invalid Input";
		header('Location: ../forgetPassword.php');
	} else {
		$host = "localhost";
		$user = "root";
		$password ="";
		$database = "users_turnaroundtime";

		$id = "";
		$fname = "";
		$lname = "";
		$age = "";

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "users_turnaroundtime";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		$sql = "UPDATE `employers` SET `password` = '123' WHERE `user_id` = '".$uname."' ";
		if ($conn->query($sql) === TRUE) {
			$_SESSION['message'] = "Password Change";
			header('Location: ../forgetPassword.php');

		} else {
		    echo "Error updating record: " . $conn->error;
		}
	}
}

	
	// $row['user_id'];
	// $check_loc = $row['loc_type'];
	// $check_user = $row['username'];

	// echo "$check_loc";
	// echo "$check_user";

	// if($username == $check_user && $locations == $check_loc) {
	// 	$sql = mysql_query(" UPDATE employers
	// 			 SET password = '123' ");
	// 	echo "password change";
	// } else {
	// 	echo "data not found";
	// }


?>