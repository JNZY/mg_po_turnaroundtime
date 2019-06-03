<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="../assets/style.css">
		
		
		<link rel="stylesheet" type="text/css" href="../assets/bootstrap-reboot.min.css">

	</head>


</html>

<?php 
	require_once('../config.php');
	date_default_timezone_set('Asia/Singapore');
	session_start();
	$ora_conn = wms_uat();
	$testLoc;

if(isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$locations = $_POST['locations'];

	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);





	if(empty($username || $password || $locations)) {
		$_SESSION["errorLogin"] = "Invalid Input";
		header('Location: ../index.php');

		}
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
		$_SESSION['errorLogin'] = "Invalid Input";
		header('Location: ../index.php');
	}


	if($row['user_id'] == $username && $row['password' == $password]) { 

		$_SESSION['username'] = $username;
		$_SESSION['location'] = $row['location'];
		unset ($_SESSION["errorLogin"]);

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
		$_SESSION['errorLogin'] = "Invalid Input";
		header('Location: ../index.php');

	}

	$secondQuery12 = " SELECT code || ' - ' || facility_id whname,  substr(code,1,5) code4 from whsloc where facility_id in ('LB','PB','SI','LT','BD')
union all
select TO_CHAR(store)  || ' - ' || store_name stname , substr(store,1,4) code4 from store@mgrmsp where store not in ('1333','1110','2003','1111','2014','2015','2017','3008','3011','3013','5002','5003','5004','5005','5006','5007','5008','5009','5010','6007','6008','6015','7006','7007','7008','7173','7176','7300','7400','9001','9002','9003','9004','9006','9007','9009','9100','9101','9102','9103','9104','9105','9106','9107','9108','9109','9999')
                  ";

                    $secondQueryRes12=$ora_conn->prepare($secondQuery12); 
                    $secondQueryRes12->execute();


                  while ($row=$secondQueryRes12->fetch(PDO::FETCH_ASSOC)) {
                      $cooodes=$row['CODE4'];
                      $namesss = $row['WHNAME'];


                      if($row['CODE4'] == $locations) {
                      	$_SESSION['test'] = $row['WHNAME'];
                      	
                      }
  					 
                  }


}

?>