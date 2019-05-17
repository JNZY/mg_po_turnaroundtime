<?php 

if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location: main_menu.php');
    exit;
}

require_once('../config.php');
session_start();
date_default_timezone_set('Asia/Singapore');

$conn_wms = wms_uat();

    if(isset($_POST['submit'])) {
        
        $plateNo = $_POST['plate_no']; 
        $poNo = $_POST['po_no'];

        if(!empty($_POST['plate_no'] && $_POST['po_no'])) {
            
            $checkExist = "SELECT PO_NBR FROM mg_po_turnaroundtime WHERE PO_NBR = '".$poNo."' ";
            $checkExistRes=$conn_wms->prepare($checkExist); 
            $checkExistRes->execute();
            $number_of_rows = $checkExistRes->fetchColumn(); 


            
            $user = $_SESSION['username'];
            $loc_id = $_SESSION['location'];

            if($number_of_rows>0) {
                $Other_Data = "SELECT ORDER_NO, LOCATION, ORIG_APPROVAL_DATE from ordhead@mgrmst where order_no in (".$poNo.")";
                $Other_DataRes=$conn_wms->prepare($Other_Data); 
                $Other_DataRes->execute();

                while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
                    $orig_approv_date = $row['ORIG_APPROVAL_DATE'];
                    $po_location = $row['LOCATION']; 
                    $po_number = $row['ORDER_NO'];  $query = "UPDATE mg_po_turnaroundtime SET STORE_ARRRIVAL_DATE=SYSDATE, STATUS='SA', WH_PLATE_NO='".$plateNo."', ST_lOC='".$loc_id."', ST_USER='".$user."' WHERE PO_NBR= '".$poNo."'";

                $facresult=$conn_wms->prepare($query); 
                $facresult->execute();

                header("location: ../store.php");

                } 
                } else {
                    $AtestData = "SELECT COUNT(*) from ordhead@mgrmst where order_no IN 
                    (".$poNo.")";
                    $AtestDataRes=$conn_wms->prepare($AtestData);
                    $AtestDataRes->execute();
                    $checker_rows = $AtestDataRes->fetchColumn(); 

                if($checker_rows == 0 ) {
                    echo "po dont exist";
                    } else {
                    $AnOther_Data = "SELECT ORDER_NO, LOCATION, ORIG_APPROVAL_DATE from ordhead@mgrmst where order_no in (".$poNo.")";
                    $AnOther_DataRes=$conn_wms->prepare($AnOther_Data); 
                    $AnOther_DataRes->execute();

                    while ($row=$AnOther_DataRes->fetch(PDO::FETCH_ASSOC)) {
                        $orig_approv_date = $row['ORIG_APPROVAL_DATE'];
                        $po_location = $row['LOCATION']; 
                        $po_number = $row['ORDER_NO'];
                    } 

                    $query1 = "INSERT INTO mg_po_turnaroundtime(PO_NBR, SUPP_PLATE_NO, STORE_ARRRIVAL_DATE, ORIG_APPROVAL_DATE, PO_LOCATION, ST_USER, ST_LOC) VALUES('$po_number', '$plateNo', sysdate, '$orig_approv_date', '$po_location', '$user', '$loc_id')";
                    $facresult1=$conn_wms->prepare($query1); 
                    $facresult1->execute();

                    $queryUpdate = "UPDATE mg_po_turnaroundtime set STATUS='SA' WHERE PO_NBR='".$poNo."' ";

                    $queryUpdateResult = $conn_wms->prepare($queryUpdate);
                    $queryUpdateResult->execute();

                    header("location: ../store.php");
                }
                
                }

        } else {
            header('Location: errors/noINPUTSTORE.php');
        }
    }

?>

