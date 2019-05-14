<?php 

require_once('../config.php');
date_default_timezone_set('Asia/Singapore');

$ora_conn = wms_uat();

 if (isset($_POST['dispatch'])) {

        $po_nbr = $_POST['peo_number'];
        $defaultData ="UPDATE mg_po_turnaroundtime SET WH_DISPATCH_DATE=SYSDATE, STATUS='WD' WHERE PO_NBR= '".$po_nbr."'";
        $defaultDataRes=$ora_conn->prepare($defaultData); 
        $defaultDataRes->execute();
        header("location: ../main_menu.php");
        
    }
    
 ?>