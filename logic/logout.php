<?php

	if(isset($_SESSION['fac_id'])) {

		session_destroy();

		header("Location: ../login.php");

	}


?>