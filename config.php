<?php

	function wms_uat(){
		$db_host1 = "10.128.4.24";
		$db_user1 = "rwms";
		$db_pass1 = "vicsal123";
		$db_name1 = "MGWMST";

		$tns = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$db_host1.")(PORT = 1521)))(CONNECT_DATA=(SID=".$db_name1.")))";

		try{
			$conn = new PDO("oci:dbname=".$tns,$db_user1,$db_pass1);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>