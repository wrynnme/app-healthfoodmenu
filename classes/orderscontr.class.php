<?php

class orderscontr extends orders {

	public function __construct() {

	}

	public function add($cus_id, $or_table, $or_phpsessid) {
		$result = $this->INSERT($cus_id, $or_table, $or_phpsessid);
		return $result;
	}

	public function add_detail($or_id, $mf_id, $qty, $price, $kcal) {
		// printf('$or_id: %s $mf_id: %s $qty: %s $price: %s $kcal: %s <br>', $or_id, $mf_id, $qty, $price, $kcal);
		$result = $this->INSERT_DETAIL($or_id, $mf_id, $qty, $price, $kcal);
		return $result;
	}

	public function set($attr, $value, $id) {
		$result = $this->UPDATE($attr, $value, $id);
		return $result;
	}


}

?>