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
    <script type="text/javascript"> 
 
//create a function that accepts an input variable (which key was key pressed) 
function disableEnterKey(e){ 
 
//create a variable to hold the number of the key that was pressed      
var key; 
 
    //if the users browser is internet explorer 
    if(window.event){ 
      
    //store the key code (Key number) of the pressed key 
    key = window.event.keyCode; 
      
    //otherwise, it is firefox 
    } else { 
      
    //store the key code (Key number) of the pressed key 
    key = e.which;      
    } 
      
    //if key 13 is pressed (the enter key) 
    if(key == 13){ 
      
    //do nothing 
    return false; 
      
    //otherwise 
    } else { 
      
    //continue as normal (allow the key press for keys other than "enter") 
    return true; 
    } 
      
//and don't forget to close the function     
} 
</script> 
<body>


<div class="page-layout">
    <form action="logic/back.php" method="post" class="m-0">
                <input type="submit" style="background:none;
     color:inherit;
     border:none; 
     padding:0!important;
     font: inherit; 
     cursor: pointer;
     color: blue;
     font-size: 12px;" class="m-0" name="whABack" value="Back">
                
            </form>
  <form action="logic/whD.php" method="post" class="m-0">

      <center>
            <img src="assets/logo.jpg" height="45" width="65" class=""><br>
            <label style="font-weight:  bold; font-size: 10px;">Transport Turnaround Time</label>
            <br>
            <label style="font-weight:  bold; font-size: 9px;" class="ml-2">DISPATCH</label>
            <br>
            <label class="ml-2 mb-0 mt-2" style="font-size: 8px">PO#</label><br>
            <input class="ml-2 mb-0" onKeyPress="return disableEnterKey(event)" type="text" value="<?php           
                                     if (isset($_SESSION['resendPO']))
                                     {
                                         echo $_SESSION['resendPO'];
                                     } ?>" id="po_number" name="po_number" width="150px"><br>
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
<script type="text/javascript" src="assets/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
</body>
</html>