<?php 
require_once('config.php');
date_default_timezone_set('Asia/Singapore');

$conn_wms = wms_uat();

    if (isset($_POST['submit'])) {
    ?>
        <script type="text/javascript">
            alert("Supplier Truck Arrived!");   
        </script>
    <?php
        $purchaseOrderNumber = $_POST['purchaseOrderNumber'];
        $plateNumber = $_POST['plateNumber'];

        if(!empty($_POST['plateNumber'] && $_POST['purchaseOrderNumber'])) {
                    $date_clicked = date('Y-m-d H:i:s');

                    //Check if PO_NBR input by user already exist in mg_po_turnaroundtime table
                    //
                    
                    // $testData = "SELECT ORDER_NO from mg_po_turnaroundtime where ORDER_NO IN (".$purchaseOrderNumber.")";
                    // $testDataRes=$conn_wms->prepare($testData);
                    // $testDataRes->execute();

                    // while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) { 
                    //     $check_po_number = $row['ORDER_NO'];
                    // }

                    // if($check_po_number == $purchaseOrderNumber) {
                    //    header('location: error.php');
                    // } else {
                    // perform all
                    // }


                    $Other_Data = "SELECT ORDER_NO, LOCATION, ORIG_APPROVAL_DATE from ordhead@mgrmst where order_no in (".$purchaseOrderNumber.")";

                    $Other_DataRes=$conn_wms->prepare($Other_Data); 
                    $Other_DataRes->execute();

                   

                    while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
                        $orig_approv_date = $row['ORIG_APPROVAL_DATE'];
                        $po_location = $row['LOCATION']; 
                        $po_number = $row['ORDER_NO'];
                    }

                        $query = "INSERT INTO mg_po_turnaroundtime(PO_NBR, SUPP_PLATE_NO, WH_ARRRIVAL_DATE, ORIG_APPROVAL_DATE, PO_LOCATION) VALUES('$po_number', '$plateNumber', TO_DATE('$date_clicked', 'yyyy/mm/dd hh24:mi:ss'), '$orig_approv_date', '$po_location')";

                        $facresult=$conn_wms->prepare($query); 
                        $facresult->execute();

                        $queryUpdate = "UPDATE mg_po_turnaroundtime set STATUS='WA' WHERE PO_NBR='".$purchaseOrderNumber."' ";

                        $queryUpdateResult = $conn_wms->prepare($queryUpdate);
                        $queryUpdateResult->execute();

        } else {
            header('Location: errors/noINPUT.php');
        }
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
	<form action="logic/whD.php" method="post" class="container">
         <h2 class="text-center head">Warehouse Dispatch</h2>
    	<div class="form-group">
            <label class="text-center">PO Number</label>
    		<input type="text" value="<?php echo "$po_number"?>" name="peo_number" readonly>
        </div>
    		 <div class="form-group">
            <label class="text-center">Supplier Number</label>
    		<input type="text" value="<?php echo "$plateNumber"?>" name= "plateNumber" readonly>
            </div>
    		<input class="btn btn-primary log-button" type="submit" name="dispatch" value="DISPATCHED">
    	</div>  
    </form>
</div>


<!-- 
    Bootstrap js
-->
<script src="assets/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap.min.js"></script>
</body>
</html>

