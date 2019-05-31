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
<script src="jquery-3.4.1.min.js"></script>
<body>
 



<div class="page-layout">
    <form action="logic/back.php" method="post" class="m-0">
                <input type="submit" name="stABack" value="BACK" class="m-0">
    </form>
	<form action="logic/strD.php" method="post" class="m-0">
                   <center><img src="assets/logo.jpg" height="45" width="65" class="">
                  <br>
                 
                  <label style="font-weight:  bold; font-size: 10px;">Transport Turnaround Time</label>
                  <br>
                  <label style="font-weight:  bold; font-size: 9px;" class="ml-2">DISPATCH</label>
                  <br>
                  <label class="ml-2 mb-0 mt-2" style="font-size: 8px">PO#</label><br>
                  <input class="ml-2 mb-0" input type="number" name="peo_number" id="peo_number" value="<?php           
                                           if (isset($_SESSION['resendPO']))
                                           {
                                               echo $_SESSION['resendPO'];
                                           } ?>" width="150px"><br>
                  <label class="ml-2 mb-0" style="font-size: 8px">SUPP PLATE#</label><br>
                  <input class="ml-2 mb-0" type="text" id="plateNo" value="<?php           
                                           if (isset($_SESSION['resendPlateNumber']))
                                           {
                                               echo $_SESSION['resendPlateNumber'];
                                           } ?>" name="plateNumber" readonly width="150px"><br>
                                           <p id="message" class="m-0"></p>
                                                              
                                                     <small>
                                                     <?php
                                                       if (isset($_SESSION['message'])) {
                                                       echo "<p class=".(in_array($_SESSION['message'], ['PO not yet arrived', 'Invalid Input', 'PO already dispatched'])  ? 'text-danger' : 'text-success').">".$_SESSION['message']."</p>";
                                                       unset($_SESSION['message']);
                                                      }
                                                     ?>   
                                                     </small>     
                  <input type="submit" name="dispatchSTORE" value="DISPATCHED" class="btn btn-primary mt-1">
             </center>
          </div>
                        
           
    	</div>  
    </form>
</body>
<!-- 
    Bootstrap js
-->
<script src="assets/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>

 


</html>
