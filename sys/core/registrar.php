<?php
require_once "../sys/config/database.php";
require_once "../sys/config/constants.php";
require_once "../sys/helper/registrar_data_helper.php";
	class Registrar extends RDH{
		private $vendor_tbl = "registered_vendor";
		private $purchaser_tbl = "registered_purchaser";
		public $conn = null;

		public function __construct(){
			
			if($this->conn==null){
				$database = new Database();
				$this->conn=$database->get_connection();
			}else{
				echo "error";
			}
		}

		public function register_vendor($name, $password, $phonenum, $location){
			if($this->vendor_exists($phonenum)==false){ // check if the phone number already exists, continue if not.
				$new_id = $this->get_new_vendor_id($name);
				$stmt = "INSERT INTO $this->vendor_tbl(id, name, password, phone_num, location)";
				$stmt .= "VALUES ('$new_id', '$name', '$password', '$phonenum', '$location')";
				if(mysqli_query($this->conn, $stmt)){
					return array("status"=>Constants::$SUCCESS,"id"=>$new_id);
				}else{
					return array("status"=>Constants::$DATABASE_ERROR);
				}
			}else{
				return array("status"=>Constants::$VENDOR_ALREADY_EXISTS);
			}
		}

		public function register_purchaser($inviter_id, $name, $password, $phonenum, $location){
			$phone_num = $this->get_vendor_phonenum_by_id($inviter_id);

			if($phone_num!=null){ // if null: vendor doesnt exist
				$vendor_name = $this->get_vendorname_by_id($inviter_id);
				$new_id = $this->get_new_purchaser_id($vendor_name, $name);
				$stmt = "INSERT INTO $this->purchaser_tbl(id, inviter_id, name, password, phone_num, location)";
				$stmt .= "VALUES('$new_id', '$inviter_id', '$name', '$password', '$phonenum', '$location')";
				if(mysqli_query($this->conn, $stmt)){
					return array("status"=>Constants::$SUCCESS,"id"=>$new_id,"vendor_phonenum"=>$phone_num);
				}else{
					return array("status"=>Constants::$DATABASE_ERROR);
				}
			}else{
				return array("status"=>Constants::$VENDOR_DOESNT_EXISTS);
			}

		}
	}
?>