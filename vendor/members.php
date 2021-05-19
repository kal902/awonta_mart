<?php
//header("connect-type:application/json");
require_once "../sys/core/vendor.php";
require_once "../sys/config/constants.php";
if(isset($_GET['vendor_id']) && isset($_GET['pass'])){
	$vendor = new Vendor($_GET['vendor_id']);
	$members = $vendor->members();
	if($members!=null){
		$result = array('members'=>$members,'count'=>count($members),'status'=>Constants::$SUCCESS);
		echo json_encode($result);
	}else{
		$result = array('status'=>Constants::$UNKNOWN_ERROR);
		echo json_encode($result);
	}
}else{
		echo Constants::$MISSING_ARGS;
	}
?>