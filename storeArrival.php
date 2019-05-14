<?php 

require_once('config.php');
date_default_timezone_set('Asia/Singapore');

$ora_conn = wms_uat();

 if (isset($_POST['dispatch'])) {

        $po_nbr = $_POST['peo_number'];
        $date_clicked = date('Y-m-d H:i:s');

        $defaultData ="UPDATE mg_po_turnaroundtime SET WH_DISPATCH_DATE=SYSDATE, STATUS='WD' WHERE PO_NBR= '".$po_nbr."'";
        $defaultDataRes=$ora_conn->prepare($defaultData); 
        $defaultDataRes->execute();
    }
    
 ?>

<!DOCTYPE html>
<html>

<!-- 
    Local
-->
<link rel="stylesheet" type="text/css" href="assets/style.css">
<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/bootstrap-grid.min.css">
<link rel="stylesheet" type="text/css" href="assets/bootstrap-reboot.min.css">

<title> supplier_po_kpi </title>
<body>



<div class="page-layout">
	<form action="storeDispatch.php" method="post" class="container">
        <h2 class="text-center head">Store <br>Arrival</h2>
        <div class="form-group">
            <label class="text-center">PO Number</label>
    		<input type="text" name="po_no">
        </div>

        <div class="form-group">
            <label class="text-center">Store Truck Plate Number</label>
    		<input type="text" name="plate_no">
        </div>

    		<input type="submit" class="btn btn-primary log-button" name="submit" value="ARRIVED">

    </form>
</div>
<!-- 
    Bootstrap js
-->
<script src="assets/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap.min.js"></script>

</body>
</html>

<?php 
        echo "<b>Dispatched :</b> " . $date_clicked . "<br>";

?>