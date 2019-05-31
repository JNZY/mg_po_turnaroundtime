<?php 

if(isset($_POST['submit'])) {

	$username = $_POST['username'];
	$x = strlen($username);
	echo $x;
}


?>






<form action="" method="post">
	
	<input type="text" name="username" Label="ajsodjsaodjo">
	<input type="submit" name="submit">
</form>