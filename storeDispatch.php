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

	<form action="logic/strD.php" method="post" class="container">
        <h2 class="text-center head">Dispatch</h2>
    	<div class="form-group">
            <label class="text-center">PO Number</label>
    		<input type="text" value="" name="peo_number">
    	</div>


    	<div class="form-group">
            <label class="text-center">Store Plate Number</label>
    		<input type="text" value="" name= "plateNumber">
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
