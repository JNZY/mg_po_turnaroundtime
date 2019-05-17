<?php 

require_once('../config.php');
date_default_timezone_set('Asia/Singapore');
session_start();

if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location: ../login.php');
    exit;
}

$conn_wms = wms_uat();

$connection = mysql_connect("localhost","root"); 
if(!$connection) { 
   die("Database connection failed: " . mysql_error()); 
}else{
   $db_select = mysql_select_db("users_turnaroundtime",$connection); 
   if (!$db_select) { 
       die("Database serialize(value)lection failed:: " . mysql_error()); 
   } 
}

    if (isset($_POST['submit'])) {

        $purchaseOrderNumber = $_POST['purchaseOrderNumber'];
        $plateNumber = $_POST['plateNumber'];


        if(!empty($_POST['plateNumber'] && $_POST['purchaseOrderNumber'])) {

                    //Check if PO_NBR input by user already exist in mg_po_turnaroundtime table
                    //
                    
                    $testData = "SELECT COUNT(*) from mg_po_turnaroundtime where PO_NBR IN 
                    (".$purchaseOrderNumber.")";
                    $testDataRes=$conn_wms->prepare($testData);
                    $testDataRes->execute();
                    $number_of_rows = $testDataRes->fetchColumn(); 

                    if($number_of_rows>0) {
                        header("Location: ../errors/duplicatePO.php");
                    } else {
                        
                        $AtestData = "SELECT COUNT(*) from ordhead@mgrmst where order_no IN 
                        (".$purchaseOrderNumber.")";
                        $AtestDataRes=$conn_wms->prepare($AtestData);
                        $AtestDataRes->execute();
                        $checker_rows = $testDataRes->fetchColumn(); 

                        if($checker_rows == 0) {
                            echo "po dont exist";
                        } else if(checker_rows > 0) {
                            $Other_Data = "SELECT ORDER_NO, LOCATION, ORIG_APPROVAL_DATE from ordhead@mgrmst where order_no in (".$purchaseOrderNumber.")";

                            $Other_DataRes=$conn_wms->prepare($Other_Data); 
                            $Other_DataRes->execute();

                            while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
                                $orig_approv_date = $row['ORIG_APPROVAL_DATE'];
                                $po_location = $row['LOCATION']; 
                                $po_number = $row['ORDER_NO'];
                            }
                                
                                $user = $_SESSION['username'];
                                $loc_id = $_SESSION['location'];


                                $query = "INSERT INTO mg_po_turnaroundtime(PO_NBR, SUPP_PLATE_NO, WH_ARRRIVAL_DATE, ORIG_APPROVAL_DATE, PO_LOCATION, WH_LOC, WH_USER) VALUES('$po_number', '$plateNumber', sysdate, '$orig_approv_date', '$po_location', '$loc_id', '$user')";

                                $facresult=$conn_wms->prepare($query); 
                                $facresult->execute();

                                $queryUpdate = "UPDATE mg_po_turnaroundtime set STATUS='WA' WHERE PO_NBR='".$purchaseOrderNumber."' ";

                                $queryUpdateResult = $conn_wms->prepare($queryUpdate);
                                $queryUpdateResult->execute();
                                header('location: ../warehouse.php');
                        }


                     
                    }

                   

        } else {
            header('Location: errors/noINPUT.php');
        }
    }

 ?>