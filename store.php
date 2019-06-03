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
        <?php 

         
                        require_once('config.php');
                        date_default_timezone_set('Asia/Singapore');

                        $ora = wms_uat();


                          $secondQuery = " SELECT code || ' - ' || facility_id whname,  substr(code,1,5) code4 from whsloc where facility_id in ('LB','PB','SI','LT','BD')
          union all
          select TO_CHAR(store)  || ' - ' || store_name stname , substr(store,1,4) code4 from store@mgrmsp where store not in ('1333','1110','2003','1111','2014','2015','2017','3008','3011','3013','5002','5003','5004','5005','5006','5007','5008','5009','5010','6007','6008','6015','7006','7007','7008','7173','7176','7300','7400','9001','9002','9003','9004','9006','9007','9009','9100','9101','9102','9103','9104','9105','9106','9107','9108','9109','9999')
                            ";

                              $secondQueryRes=$ora->prepare($secondQuery); 
                              $secondQueryRes->execute();


                            while ($row=$secondQueryRes->fetch(PDO::FETCH_ASSOC)) {
                                $codes=$row['CODE4'];
                                $names = $row['WHNAME'];

                                if($_SESSION['location'] == $row['CODE4']) {
                                    $_SESSION['test'] = $row['WHNAME'];
                                }
                                
                            }
                        
        echo "".$_SESSION['test']; ?>
        <br>
        
        <br>
        <a href="storeArrival.php" class="btn btn-primary" style="display: inline-block; padding: 13px;">ARRIVAL</a>
        &nbsp; &nbsp;
       <a href="storeDispatch.php" style="display: inline-block; padding: 13px;" class="btn btn-primary">DISPATCH</a>
   </center>
</div>

<!-- 
    Bootstrap js
-->
<script src="assets/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap.min.js"></script>



</body>
</html>