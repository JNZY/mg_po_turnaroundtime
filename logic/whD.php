<?php 

require_once('../config.php');
date_default_timezone_set('Asia/Singapore');

$ora_conn = wms_uat();

 if (isset($_POST['dispatch'])) {


        $po_nbr = $_POST['peo_number'];


 		$Other_Data = "SELECT PO_NBR, SUPP_PLATE_NO, WH_DISPATCH_DATE from mg_po_turnaroundtime where PO_NBR in (".$po_nbr.")";
 		$Other_DataRes=$ora_conn->prepare($Other_Data); 
 		$Other_DataRes->execute();
 		$number_of_rows = $Other_DataRes->fetchColumn(); 

 		while ($row=$Other_DataRes->fetch(PDO::FETCH_ASSOC)) {
 		    $check_ponumber = $row['PO_NBR'];
 		    $supp_plate_no = $row['SUPP_PLATE_NO']; 
 		    $dispatch_date = $row['WH_DISPATCH_DATE'];
 		}	

 		
 		if($number_of_rows > 0) {
-
 				$defaultData ="UPDATE mg_po_turnaroundtime SET WH_DISPATCH_DATE=SYSDATE, STATUS='WD' WHERE PO_NBR= '".$po_nbr."'";
 				$defaultDataRes=$ora_conn->prepare($defaultData); 
 				$defaultDataRes->execute();
 				header("location: ../warehouse.php");	
 		} else {
 			echo "po number, not yet arrived";
 		}
      



        
    }
    
 ?>