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
        $number_characters = strlen($plateNo);
        $status = 'SA';

        if($number_characters > 9) {
            $_SESSION['error_plateNumber'] = "Plate number exceeds";
            header('Location: ../storeArrival.php');
        } else {
          if(!empty($_POST['plate_no'] && $_POST['po_no'])) {
              
              $checkExist = "SELECT PO_NBR FROM mg_po_turnaroundtime WHERE PO_NBR = '".$poNo."' ";
              $checkExistRes=$conn_wms->prepare($checkExist); 
              $checkExistRes->execute();
              $number_of_rows = $checkExistRes->fetchColumn(); 


              
              $user = $_SESSION['username'];
              $loc_id = $_SESSION['location'];

              if($number_of_rows>0) {


                  $Other_Data = "SELECT PO_NBR, PO_LOCATION, ORIG_APPROVAL_DATE, SUPP_PLATE_NO, WH_ARRRIVAL_DATE, WH_DISPATCH_DATE from mg_po_turnaroundtime where PO_NBR in (".$poNo.")";
                  $Other_DataRes=$conn_wms->prepare($Other_Data); 
                  $Other_DataRes->execute();

                  while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
                      $orig_approv_date = $row['ORIG_APPROVAL_DATE'];
                      $po_location = $row['PO_LOCATION']; 
                      $po_number = $row['PO_NBR'];  
                      $supp_plate_no = $row['SUPP_PLATE_NO'];
                      $wh_arrival_date = $row['WH_ARRRIVAL_DATE'];
                      $wh_dispatch_date = $row['WH_DISPATCH_DATE'];
                  } 
                      $query = "INSERT INTO mg_po_turnaroundtime(PO_NBR, PO_LOCATION, ORIG_APPROVAL_DATE, SUPP_PLATE_NO, WH_ARRRIVAL_DATE, WH_DISPATCH_DATE, STORE_ARRRIVAL_DATE, STATUS, ST_USER, ST_LOC, WH_PLATE_NO) VALUES('$po_number', '$po_location', '$orig_approv_date', '$supp_plate_no', '$wh_arrival_date', '$wh_dispatch_date', SYSDATE, '$status', '$user', '$loc_id', '$plateNo')";
                      $facresult=$conn_wms->prepare($query); 
                      $facresult->execute();

                  $_SESSION['po_checker'] = "Truck Successfully Arrive";
                  header("location: ../storeArrival.php");

                  } else {
                      $AtestData = "SELECT COUNT(*) from ordhead@mgrmst where order_no IN 
                      (".$poNo.")";
                      $AtestDataRes=$conn_wms->prepare($AtestData);
                      $AtestDataRes->execute();
                      $checker_rows = $AtestDataRes->fetchColumn(); 

                  if($checker_rows == 0 ) {
                      $_SESSION['po_checker_error'] = "PO doesn't exist";
                      header("location: ../storeArrival.php");

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

                      $_SESSION['po_checker'] = "Truck Successfully Arrive";
                      header("location: ../storeArrival.php");
                  }
                  
                  }

          } else {
              $_SESSION['no_input'] = "Invalid Input";
              header('Location: ../storeArrival.php');

          }  
        }

        
    }

?>

