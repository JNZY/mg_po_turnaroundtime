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
    
        <a href="index.php" style="font-size: 10px;" class="m-0">Log-out</a>
        <center><img src="assets/logo.jpg" height="70" width="90" class=""></center>
        <br>
        <center>
        <label style="font-weight:  bold; font-size: 12px;">Transport Turnaround Time</label><br>
        <?php echo "".$_SESSION['test'];?>
        <br>
        
            <br>
        <a href="whArrival.php" class="btn btn-primary" style="display: inline-block; padding: 13px;">ARRIVAL</a>
        &nbsp; &nbsp;
       <a href="whDispatch.php" style="display: inline-block; padding: 13px;" class="btn btn-primary">DISPATCH</a>
   </center>
</div>

<!-- 
    Bootstrap js
-->
<script src="assets/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap.min.js"></script>



</body>
</html>