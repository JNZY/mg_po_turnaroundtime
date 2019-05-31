<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location: index.php');
    exit;
}
    session_start();
?>
<!DOCTYPE html>
<html>

<!-- 
    Local
-->
     <link rel="stylesheet" type="text/css" href="testing.css">
     <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">

<title> Transport Turnaround Time </title>
<body>
        <div class="page-layout">
        <form action="logic/back.php" method="post" class="m-0">
            <input type="submit" class="m-0" name="whABack" value="BACK">
        </form>

    <form action="logic/whA.php" method="post" class="m-0">
        <center><img src="assets/logo.jpg" height="45" width="65" class=""></center>
        <center>
        <label style="font-weight:  bold; font-size: 10px;">Transport Turnaround Time</label>
        <br>
        <label style="font-weight:  bold; font-size: 9px;" class="ml-2 mb-3">ARRIVAL</label>
        <br>
        <label class="ml-2 mb-0 mt-2" style="font-size: 8px">PO#</label><br>
        <input name='purchaseOrderNumber' class="ml-2 mb-0" type="text" name="" width="150px" value="<?php           
                                     if (isset($_SESSION['resendPO']))
                                     {
                                         echo $_SESSION['resendPO'];
                                     } ?>"><br>
        <label class="ml-2 mb-0" style="font-size: 8px">SUPP PLATE#</label><br>
        <input name='plateNumber' class="ml-2 mb-0" type="text" name="" width="150px" value="<?php           
                                     if (isset($_SESSION['resendPlateNumber']))
                                     {
                                         echo $_SESSION['resendPlateNumber'];
                                     } ?>"><br>
              <small>
                
               <?php
                 if (isset($_SESSION['message'])) {
                 echo "<p class=".(in_array($_SESSION['message'], ['Invalid Input', 'Enter Plate Number < 9', 'PO Doesnt Exist', 'PO already arrived'])  ? 'text-danger' : 'text-success').">".$_SESSION['message']."</p>";
                 unset($_SESSION['message']);
                }
               ?>     
            </small>
        <input type="submit" name="submit" value="ARRIVED" class="btn btn-primary mt-1">

              
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

