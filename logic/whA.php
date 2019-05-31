<?php 

require_once('../config.php');
date_default_timezone_set('Asia/Singapore');
session_start();

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
        $number_characters = strlen($plateNumber);
        $_SESSION['resendPO'] = "$purchaseOrderNumber";
        $_SESSION['resendPlateNumber'] = "$plateNumber";

        if($number_characters > 9) {
            $_SESSION['message'] = "Enter Plate Number < 9";
            header('Location: ../whArrival.php');
        } else {
        if(!empty($_POST['plateNumber'] && $_POST['purchaseOrderNumber'])) {

                    //Check if PO_NBR input by user already exist in mg_po_turnaroundtime table
                    //
                    
                    $testData = "SELECT COUNT(*) from mg_po_turnaroundtime where PO_NBR IN 
                    (".$purchaseOrderNumber.")";
                    $testDataRes=$conn_wms->prepare($testData);
                    $testDataRes->execute();
                    $number_of_rows = $testDataRes->fetchColumn(); 

                    if($number_of_rows>0) {
                        $_SESSION['message'] = "PO already arrived";
                        header('Location: ../whArrival.php');
                    } else {
                        
                        $AtestData = "SELECT COUNT(*) from ordhead@mgrmst where order_no IN 
                        (".$purchaseOrderNumber.")";
                        $AtestDataRes=$conn_wms->prepare($AtestData);
                        $AtestDataRes->execute();
                        $checker_nrows = $AtestDataRes->fetchColumn(); 

                        if($checker_nrows == 0) {
                            $_SESSION['message'] = "PO Doesnt Exist";
                            header('Location: ../whArrival.php');
                        } else {
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
                                $_SESSION['message'] = "PO Successfully Arrived";
                                header('Location: ../whArrival.php');
                        }


                     
                    }

                   

        } else {
            $_SESSION['message'] = "Invalid Input";
            header('Location: ../whArrival.php');
        }
        }
    }

 ?>