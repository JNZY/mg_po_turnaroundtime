<?php
require_once('../config.php');

date_default_timezone_set('Asia/Singapore');
session_start();

$username = $_POST['username'];

$location = getLocation($username);

echo json_encode([
    'username' => $username
]);


function getLocation($user_id) {
	$connect = mysql_connect("localhost", "root", "") or die (mysql_error());

	mysql_select_db("users_turnaroundtime", $connect);

	$sql = " SELECT location FROM employers WHERE user_id = '".$user_id."' ";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	
	return $row['location'];
}

function checkLocation($location) {

}


?>