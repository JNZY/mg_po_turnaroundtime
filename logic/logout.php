<?php

	if(isset($_SESSION['fac_id'])) {

		session_destroy();
		unset ($_SESSION["username"]);

		header("Location: ../index.php");

	}



	


?>