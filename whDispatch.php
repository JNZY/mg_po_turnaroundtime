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
  <form action="logic/whD.php" method="post" class="m-0">

      <center>
            <img src="assets/logo.jpg" height="45" width="65" class=""><br>
            <label style="font-weight:  bold; font-size: 10px;">Transport Turnaround Time</label>
            <br>
            <label style="font-weight:  bold; font-size: 9px;" class="ml-2">DISPATCH</label>
            <br>
            <label class="ml-2 mb-0 mt-2" style="font-size: 8px">PO#</label><br>
            <input class="ml-2 mb-0" type="text" value="<?php           
                                     if (isset($_SESSION['resendPO']))
                                     {
                                         echo $_SESSION['resendPO'];
                                     } ?>" id="po_number" name="peo_number" width="150px"><br>
            <label class="ml-2 mb-0" style="font-size: 8px">SUPP PLATE#</label><br>
            <input class="ml-2 mb-0" type="text" name= "plateNumber" id="plateNumber" readonly width="150px">
            <small>
            <?php
              if (isset($_SESSION['message'])) {
              echo "<p class=".(in_array($_SESSION['message'], ['PO not yet arrived', 'Invalid Input', 'PO already dispatched'])  ? 'text-danger' : 'text-success').">".$_SESSION['message']."</p>";
              unset($_SESSION['message']);
             }
            ?>   
            </small>     
            <p class="m-0" id="message"></p>
            <input type="submit" name="dispatch" value="DISPATCHED" class="btn btn-primary mt-1">
       </center>
    </div>
    </form>
</div>


<!-- 
    Bootstrap js
-->
<script src="assets/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/jquery.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
</body>
</html>

