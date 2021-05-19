<?php
//header("connect-type:application/json");
require_once "../sys/core/registrar.php";
require_once "../sys/config/constants.php";
if(isset($_GET['name']) && isset($_GET['pass']) && isset($_GET['phonenum']) && isset($_GET['location'])){
	$registrar = new Registrar();
	$status = $registrar->register_vendor($_GET['name'],$_GET['pass'], $_GET['phonenum'], $_GET['location']);
	// $status = array containing status, and new id if available.
	echo json_encode($status);
}else{
		echo Constants::$MISSING_ARGS;
	}
?>