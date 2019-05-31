<?php 
require_once('../config.php');
date_default_timezone_set('Asia/Singapore');
session_start();
$ora_conn = wms_uat();

$po_nbr = $_POST['peo_number'];

$plate_number = getPlateNumber($po_nbr);

echo json_encode([
    'message' => 'Truck Successfully Dispatch',
    'plate_number' => $plate_number
]);

function getPlateNumber($po_number) {

    $q = wms_uat()->prepare('SELECT * 
        from mg_po_turnaroundtime where PO_NBR= :po_nbr and ST_LOC= :st_loc');
    $q->execute(['po_nbr' => $po_number, 'st_loc' => $_SESSION['location']]);
    $result = $q->fetch(PDO::FETCH_ASSOC);
    //return $result;
   
    if(empty($result['WH_PLATE_NO'])) {
        return $result['SUPP_PLATE_NO'];
    }

    return $result['WH_PLATE_NO'];
}

function truckArrived ($po_number) {

    $query = wms_uat()->prepare("SELECT PO_NBR, SUPP_PLATE_NO, WH_DISPATCH_DATE from mg_po_turnaroundtime where PO_NBR = :po_nbr");
    $query->execute(['po_nbr' => $po_number]);

    return !empty($query->fetchAll());
}
?>