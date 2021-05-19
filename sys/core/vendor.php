<?php
	include_once "../sys/core/products.php";
	include_once "../sys/core/registrar.php";
	include_once "../sys/config/database.php";
	include_once "../sys/config/constants.php";
	class Vendor extends Products{

		function __construct($vendorid){
			$this->vendor_id=$vendorid;
			$db  = new Database();
			$this->conn = $db->get_connection();
			$this->reg = new Registrar();
			if($this->reg->vendor_id_exist($vendorid)){ // check if vendor exists
				$this->vendorexists = true;
			}else{
				$this->vendorexists = false;
			}
		}

		public function addproduct($name, $price, $desc){
			if($this->vendorexists){
				$product['product_name'] = $name;
				$product['price'] = $price;
				$product['desc'] = $desc;
				return $this->add_product($this->vendor_id, $product); // product id
			}else{
				return null; // vendor doesnt exist.
			}
		}
		// modify a product
		public function editproduct($product_id, $name, $price, $desc){
				if($this->vendorexists){
					if($this->product_exists($product_id)){
						$product['product_name'] = $name;
						$product['price'] = $price;
						$product['desc'] = $desc;
						return $this->edit_product($product_id,$product);
					}else{
						return Constants::$PRODUCT_NOT_FOUND;}
				}else{
					return Constants::$VENDOR_DOESNT_EXIST;}
		}

		public function removeproduct($product_id){
			if($this->vendorexists){
				if($this->product_exists($product_id)){
					return $this->remove_product($product_id);
				}else{
					return Constants::$PRODUCT_NOT_FOUND;}
			}else{
				return Constants::$VENDOR_DOESNT_EXIST;}
		}

		public function members(){
			if($this->vendorexists){
				$query = mysqli_query($this->conn,"SELECT * FROM registered_purchaser WHERE inviter_id='$this->vendor_id'");
				$count=0;
				$members = array();
				while($row=mysqli_fetch_array($query)){
					$member['id']=$row['id'];
					$member['name']=$row['name'];
					$member['phone_num']=$row['phone_num'];
					$member['location']=$row['location'];
					$members[$count]=$member;
					$count = $count+1;
				}
				return $members;
			}else{
				return null;
			}
		}

	}
?>