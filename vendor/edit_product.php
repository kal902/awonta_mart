<?php
//header("connect-type:application/json");
require_once "../sys/core/vendor.php";
require_once "../sys/config/constants.php";
if(isset($_GET['vendor_id']) && isset($_GET['pass']) && isset($_GET['name']) && isset($_GET['price']) && isset($_GET['desc']) && isset($_GET['product_id'])){

	$vendor = new Vendor($_GET['vendor_id']);
	$result = $vendor->editproduct($_GET['product_id'],$_GET['name'], $_GET['price'], $_GET['desc']);
	$response = array('status'=>$result);
	echo json_encode($response);

}else{
		echo Constants::$MISSING_ARGS;
	}
?>