<?php 
	//author kaleab
	require_once "../sys/config/database.php";
	class RDH{
		private $vendor_tbl = "registered_vendor";
		private $purchaser_tbl = "registered_purchaser";
		
		public function vendor_exists($phonenum){
			$query = mysqli_query($this->conn, "SELECT * FROM $this->vendor_tbl WHERE phone_num='$phonenum'");
			if(mysqli_num_rows($query)>0){
				return true;
			}else{
				return false;
			}
		}
		public function get_new_vendor_id($vendorname){
			$new_id;
			while(true){
				$rand_num = rand(1000,6000);
				$new_id = "$vendorname"."$rand_num";
				$query = mysqli_query($this->conn, "SELECT * FROM $this->vendor_tbl WHERE id='$new_id'");
				if(mysqli_num_rows($query)>0){
					continue;
				}else{
					break;
				}
			}
			return $new_id;
		}
		public function get_new_purchaser_id($vendorname,$purchasername){
			while(true){
				$rand_num = rand(1000,6000);
				$new_id = "$rand_num@"."$vendorname";
				$query = mysqli_query($this->conn, "SELECT * FROM $this->purchaser_tbl WHERE id='$new_id'");
				if(mysqli_num_rows($query)==0){
					return $new_id;
				}
			}
		}
		public function get_vendorname_by_id($vendorid){
			$query = mysqli_query($this->conn, "SELECT * FROM $this->vendor_tbl WHERE id='$vendorid'");
			
			if(mysqli_num_rows($query)>0){
				$row=mysqli_fetch_array($query);
				return $row['name'];
			}else{
				return null;
			}
			
		}

		public function get_vendor_phonenum_by_id($vendorid){
			$query = mysqli_query($this->conn, "SELECT * FROM $this->vendor_tbl WHERE id='$vendorid'");
			
			if(mysqli_num_rows($query)>0){
				$row=mysqli_fetch_array($query);
				return $row['phone_num'];
			}else{
				return null;
			}
		}

		public function vendor_id_exist($vendorid){
			if($this->get_vendor_phonenum_by_id($vendorid)!= null){// if a phone# assossiated with this id is found then the vendor exists.
				return true;
			}else{
				return false;
			}
		}
	}
?>