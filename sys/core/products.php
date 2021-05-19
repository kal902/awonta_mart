<?php
require_once "../sys/config/constants.php";

	class Products{
		public $conn;
		private $tbl_name = "products";
		public function __construct($db){
			$this->conn = $db;
		}

		protected function add_product($vendor_id, $product){
			$name = $product['product_name'];
			$price = $product['price'];
			$desc = $product['desc'];
			$new_id = $this->get_new_product_id();
			$stmt = "INSERT INTO $this->tbl_name(vendor_id, product_id, product_name, price, description)";
			$stmt .= "VALUES ('$vendor_id', '$new_id', '$name', '$price', '$desc')";
			if(mysqli_query($this->conn, $stmt)){
				return $new_id;
			}else{
				return null;
			}
		}

		public function get_products($vendor_id){
			//todo : check if the vendor exists.   jumped to reduce database conncection usage
			$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE vendor_id='$vendor_id'");
			$products = array();
			$count = 0;
			while($row=mysqli_fetch_array($query)){
				$products[$count]=$row;
				$count = $count+1;
			}
			return $products;
		}

		protected function edit_product($product_id, $new_data){
			$name = $new_data['product_name'];
			$price = $new_data['price'];
			$desc = $new_data['desc'];
			$stmt = "UPDATE $this->tbl_name SET product_name='$name',";
			$stmt .= "price='$price', description='$desc' WHERE product_id='$product_id'";
			if(mysqli_query($this->conn, $stmt)){
				return Constants::$SUCCESS;
			}else{
				return Constants::$DATABASE_ERROR;
			}
		}

		protected function remove_product($product_id){
			if(mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE product_id='$product_id'")){
				return Constants::$SUCCESS;
			}else{
				return Constants::$DATABASE_ERROR;
			}
		}

		public function get_product_info($product_id){
			//todo : check if the product exists.   jumped to reduce database conncection usage
			$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE product_id='$product_id'");
			if(mysqli_num_rows($query)>0){
				return $row = mysqli_fetch_array($query);
			}else{
				return null; // product doesnt exist
			}
		}

		public function product_exists($product_id){
			$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE product_id='$product_id'");
			if(mysqli_num_rows($query)>0){
				return true;
			}else{
				return false;
			}
		}

		protected function get_new_product_id(){
			$new_id;
			while(true){
				$new_id = rand(1000,6000); 
				if($this->product_exists($new_id)!=true){
					break;
				}
			}
			return $new_id;
		}
	}
?>