<?php 

require_once('config.php');
date_default_timezone_set('Asia/Singapore');

$ora_conn = wms_uat();

 if (isset($_POST['dispatchSTORE'])) {

        $po_nbr = $_POST['peo_number'];
        $date_clicked = date('Y-m-d H:i:s');

        $defaultData ="UPDATE mg_po_turnaroundtime SET STORE_DISPATCH_DATE=SYSDATE, STATUS='SD' WHERE PO_NBR= '".$po_nbr."'";
        $defaultDataRes=$ora_conn->prepare($defaultData);
        $defaultDataRes->execute();


    }

 ?>
 	
 Congrats! Done!


<?php 
        echo "<b>Dispatched :</b> " . $date_clicked . "<br>";

?>