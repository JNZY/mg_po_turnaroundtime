<?php 

require_once('config.php');
date_default_timezone_set('Asia/Singapore');

$conn_wms = wms_uat();

    if(isset($_POST['submit'])) {
        ?>
            <script type="text/javascript">
                alert("Store Truck Arrived!");   
            </script>

        <?php
        $plateNo = $_POST['plate_no']; 
        $poNo = $_POST['po_no'];
        $date_clicked = date('Y-m-d H:i:s');

        if(!empty($_POST['plate_no'] && $_POST['po_no'])) {

        $Other_Data = "SELECT ORDER_NO, LOCATION from ordhead@mgrmst where order_no in (".$poNo.")";

        $Other_DataRes=$conn_wms->prepare($Other_Data); 
        $Other_DataRes->execute();

        while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
            $po_number = $row['ORDER_NO'];
        }

        $query = "UPDATE mg_po_turnaroundtime SET STORE_ARRRIVAL_DATE=SYSDATE, STATUS='SA', WH_PLATE_NO='".$plateNo."' WHERE PO_NBR= '".$poNo."'";

        $facresult=$conn_wms->prepare($query); 
        $facresult->execute();

        } else {
            header('Location: errors/noINPUTSTORE.php');
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

	<form action="end.php" method="post" class="container">
        <h2 class="text-center head">Store Dispatch</h2>
    	<div class="form-group">
            <label class="text-center">PO Number</label>
    		<input type="text" value="<?php echo "$po_number" ?>" name="peo_number" readonly>
    	</div>


    	<div class="form-group">
            <label class="text-center">Store Truck Plate Number</label>
    		<input type="text" value="<?php echo "$plateNo"?>" name= "plateNumber" readonly>
    	</div>

    		<input class="btn btn-primary log-button" type="submit" name="dispatchSTORE" value="DISPATCHED">
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

<?php 

    echo "<b>Arrival :</b> " . $date_clicked . "<br>";


?>