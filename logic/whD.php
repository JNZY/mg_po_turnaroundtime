<?php 
require_once('../config.php');
date_default_timezone_set('Asia/Singapore');
session_start();
$ora_conn = wms_uat();

 if (isset($_POST['dispatch'])) {

        $po_nbr = $_POST['po_number'];
		$plateNumber = $_POST['plateNumber'];
        $number_characters = strlen($plateNumber);
        $_SESSION['resendPO'] = "$po_nbr";
        $_SESSION['resendPlateNumber'] = "$plateNumber";

        if(empty($po_nbr && $plateNumber) ) {
        	$_SESSION['message'] = "Invalid Input";
        	header('Location: ../whDispatch.php');
        } else {
                    if($number_characters > 9) {
                        $_SESSION['message'] = "Plate number exceeds";
                        header('Location: ../whDispatch.php');
                    } else {
                    $Other_Data = "SELECT PO_NBR, SUPP_PLATE_NO, WH_DISPATCH_DATE from mg_po_turnaroundtime where PO_NBR in (".$po_nbr.")";
                    $Other_DataRes=$ora_conn->prepare($Other_Data); 
                    $Other_DataRes->execute();
                    $number_of_rows = $Other_DataRes->fetchColumn(); 

                    $noDispatch = " SELECT * FROM mg_po_turnaroundtime WHERE PO_NBR = '".$po_nbr."' ";
                    $noDispatchRes=$ora_conn->prepare($noDispatch); 
                    $noDispatchRes->execute();
                    while ($row=$noDispatchRes->fetch(PDO::FETCH_ASSOC)) {
                        $wh_dispatch_date = $row['WH_DISPATCH_DATE'];
                    } 
                    
                    if(empty($wh_dispatch_date)) {
                        if($number_of_rows > 0) {


                                $defaultData ="UPDATE mg_po_turnaroundtime SET WH_DISPATCH_DATE=SYSDATE, STATUS='WD' WHERE PO_NBR= '".$po_nbr."'";
                                $defaultDataRes=$ora_conn->prepare($defaultData); 
                                $defaultDataRes->execute();
                                $_SESSION['message'] = "Truck Successfully Dispatched";
                                header("location: ../whDispatch.php");  
                        } else {
                            $_SESSION['message'] = "PO not yet arrived";
                            header("location: ../whDispatch.php");

                        }
                    } else {
                        $_SESSION['message'] = "PO already dispatched";
                        header('Location: ../whDispatch.php');

                    }
                  
                  
            }
        }




        
    }
    
 ?>