<?php
//header("connect-type:application/json");
require_once "../sys/core/vendor.php";
require_once "../sys/config/constants.php";
if(isset($_GET['vendor_id']) && isset($_GET['pass']) && isset($_GET['name']) && isset($_GET['price']) && isset($_GET['desc'])){

	$vendor = new Vendor($_GET['vendor_id']);
	$product_id = $vendor->addproduct($_GET['name'], $_GET['price'], $_GET['desc']);
	if($product_id!=null){
		$result = array('id'=>$product_id,'status'=>Constants::$SUCCESS);
		echo json_encode($result);
	}else{
		$result = array('status'=>Constants::$UNKNOWN_ERROR);
		echo json_encode($result);
	}

}else{
		echo Constants::$MISSING_ARGS;
	}
?>