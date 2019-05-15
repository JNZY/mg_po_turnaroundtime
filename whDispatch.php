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
    <a href="warehouse.php" class="btn btn-primary ml-0">Back</a>

	<form action="logic/whD.php" method="post" class="container">
         <h2 class="text-center head">Dispatch</h2>
    	<div class="form-group">
            <label class="text-center">PO Number</label>
    		<input type="text" value="" name="peo_number">
        </div>
    		 <div class="form-group">
            <label class="text-center">Supplier Number</label>
    		<input type="text" value="" name= "plateNumber">
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

