<?php 
	session_start();


	if(isset($_POST['back'])) {
		session_destroy();
		header('Location: ../index.php');
	}

	if(isset($_POST['whABack'])) {
		unset($_SESSION['po_checker']);
		unset($_SESSION['error_plateNumber']);
		unset($_SESSION['no_input']);
		unset($_SESSION['po_checker_error']);
		unset($_SESSION['autoFillPlate']);
		unset($_SESSION['autoFillPO']);
		unset($_SESSION['supp_plate_no']);
		unset($_SESSION['po_checker_duplicate']);
		unset($_SESSION['resendPO']);
		unset($_SESSION['resendPlateNumber']);

		header('Location: ../warehouse.php');
	}

	if(isset($_POST['stABack'])) {
		unset($_SESSION['po_checker']);
		unset($_SESSION['error_plateNumber']);
		unset($_SESSION['no_input']);
		unset($_SESSION['po_checker_error']);
		unset($_SESSION['autoFillPlate']);
		unset($_SESSION['autoFillPO']);
		unset($_SESSION['wh_plate_no']);
		unset($_SESSION['resendPO']);
		
		unset($_SESSION['resendPlateNumber']);
		header('Location: ../store.php');
	}

?>