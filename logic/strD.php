<?php 

require_once('../config.php');
date_default_timezone_set('Asia/Singapore');
session_start();
$ora_conn = wms_uat();
$user = $_SESSION['username'];
$loc_id = $_SESSION['location'];




 if (isset($_POST['dispatchSTORE'])) {

    $po_nbr = $_POST['peo_number'];
    $plateNumber = $_POST['plateNumber'];
    $number_characters = strlen($plateNumber);
    
    $_SESSION['resendPO'] = "$po_nbr";
    $_SESSION['resendPlateNumber'] = "$plateNumber";
    
    if(empty($po_nbr && $plateNumber) ) {
        $_SESSION['message'] = "Invalid Input";
        header('Location: ../storeDispatch.php');

    } else {
            if($number_characters > 9) {
                $_SESSION['message'] = "Plate number exceeds";
                header('Location: ../storeDispatch.php');
            } else {
                
            $Other_Data = "SELECT PO_NBR, SUPP_PLATE_NO, WH_DISPATCH_DATE, WH_PLATE_NO from mg_po_turnaroundtime where PO_NBR in (".$po_nbr.")";
            $Other_DataRes=$ora_conn->prepare($Other_Data); 
            $Other_DataRes->execute();
            $number_of_rows = $Other_DataRes->fetchColumn(); 

            while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
                $check_ponumber = $row['PO_NBR'];
                $supp_plate_no = $row['SUPP_PLATE_NO']; 
                $dispatch_date = $row['WH_DISPATCH_DATE'];
                $wh_plate_no = $row['WH_PLATE_NO'];
            }   

            $noDispatch = " SELECT * FROM mg_po_turnaroundtime WHERE PO_NBR = '".$po_nbr."' AND ST_LOC = '".$loc_id."' ";
            $noDispatchRes=$ora_conn->prepare($noDispatch); 
            $noDispatchRes->execute();
            while ($row=$noDispatchRes->fetch(PDO::FETCH_ASSOC)) {
                $store_dispatch_date = $row['STORE_DISPATCH_DATE'];
            } 

            if(empty($store_dispatch_date)) {
                $_SESSION['wh_plate_no'] = $supp_plate_no;

                if($number_of_rows > 0) {
                $po_nbr = $_POST['peo_number'];
                $date_clicked = date('Y-m-d H:i:s');

                $defaultData ="UPDATE mg_po_turnaroundtime SET STORE_DISPATCH_DATE=SYSDATE, STATUS='SD' WHERE PO_NBR= '".$po_nbr."' AND ST_LOC= '".$loc_id."' ";
                $defaultDataRes=$ora_conn->prepare($defaultData);
                $defaultDataRes->execute();
                
                $_SESSION['message'] = "Truck Successfully Dispatched"; 

                header('location: ../storeDispatch.php');
                } else {
                    $_SESSION['message'] = "PO not yet arrived"; 
                    header("location: ../storeDispatch.php");

                }
            } else {
                $_SESSION['message'] = "PO already dispatched"; 
                header('Location: ../storeDispatch.php');

            }
            
        }
    }

}

   
 ?>
