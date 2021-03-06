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

        $_SESSION['resendPO'] = "$poNo";
        $_SESSION['resendPlateNumber'] = "$plateNo";

   

        if($number_characters > 9) {
            $_SESSION['message'] = "Enter Plate Number < 9";
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

                 $checkD = " SELECT * FROM mg_po_turnaroundtime WHERE PO_NBR = '".$poNo."' and ST_LOC = '".$loc_id."' ";
                 $checkDRes = $conn_wms->prepare($checkD);
                 $checkDRes->execute();
                 $number_of_rows_D = $checkDRes->fetchColumn(); 

                 if($number_of_rows_D > 0) {
                   $_SESSION['message'] = "Duplicate PO on Store";
                   header('Location: ../storeArrival.php');

                 } else {



                  $Other_Data = "SELECT PO_NBR, PO_LOCATION, ORIG_APPROVAL_DATE, SUPP_PLATE_NO, WH_ARRRIVAL_DATE, WH_DISPATCH_DATE, WH_LOC, WH_USER from mg_po_turnaroundtime where PO_NBR in (".$poNo.")";
                  $Other_DataRes=$conn_wms->prepare($Other_Data); 
                  $Other_DataRes->execute();

                  while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
                      $orig_approv_date = $row['ORIG_APPROVAL_DATE'];
                      $po_location = $row['PO_LOCATION']; 
                      $po_number = $row['PO_NBR'];  
                      $supp_plate_no = $row['SUPP_PLATE_NO'];
                      $wh_arrival_date = $row['WH_ARRRIVAL_DATE'];
                      $wh_dispatch_date = $row['WH_DISPATCH_DATE'];
                      $wh_loc = $row['WH_LOC'];
                      $wh_user = $row['WH_USER'];
                  } 

                  if(empty($wh_dispatch_date)) {
                    $_SESSION['message'] = "PO Not Dispatched from WH";
                    header("location: ../storeArrival.php");
                  } else {

                       $arrivalSQL = " INSERT into mg_po_turnaroundtime (select
                                      PO_NBR,
                                      PO_LOCATION,
                                      ORIG_APPROVAL_DATE,
                                      SUPP_PLATE_NO,
                                      WH_ARRRIVAL_DATE,
                                      WH_DISPATCH_DATE,
                                      SYSDATE,
                                      null,
                                      'SA',
                                      '".$plateNo."',
                                      WH_LOC,
                                      WH_USER,
                                      '".$loc_id."',
                                      '".$user."'
                                      FROM mg_po_turnaroundtime where po_nbr = '".$poNo."' and rownum = 1
                                    ) ";
                                    $arrivalSQLRes=$conn_wms->prepare($arrivalSQL); 
                                    $arrivalSQLRes->execute();

                        // DISABLED FOR NOW...
                        $removeFirstEntry = " DELETE FROM mg_po_turnaroundtime WHERE PO_NBR = '".$poNo."' and STORE_ARRRIVAL_DATE is null ";
                        $removeFirstEntryRes=$conn_wms->prepare($removeFirstEntry); 
                        $removeFirstEntryRes->execute();


                    $_SESSION['message'] = "Truck Successfully Arrive";
                    header("location: ../storeArrival.php");
                  }
                     
                 }
                  } else {
                      $AtestData = "SELECT COUNT(*) from ordhead@mgrmst where order_no IN 
                      (".$poNo.")";
                      $AtestDataRes=$conn_wms->prepare($AtestData);
                      $AtestDataRes->execute();
                      $checker_rows = $AtestDataRes->fetchColumn(); 

                  if($checker_rows == 0 ) {
                      $_SESSION['message'] = "PO Doesnt Exist";
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

                      $_SESSION['message'] = "Truck Successfully Arrived";
                      header("location: ../storeArrival.php");
                  }
                  
                  }

          } else {
              $_SESSION['message'] = "Invalid Input";
              header('Location: ../storeArrival.php');

          }  
        }

        
    }

?>

