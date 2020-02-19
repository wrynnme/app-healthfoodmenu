<?php

abstract class orders extends dbh {

	protected function SELECT($id, $cus_id) {
		$sql = "SELECT * FROM `orders` WHERE `or_id` = ? AND `cus_id` = ? ORDER BY `or_time_newStatus` DESC";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id, $cus_id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}

	protected function SELECT_DETAIL($id) {
		$sql = "SELECT * FROM `orders_detail` WHERE `or_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}

	protected function SELECT_MODE($mode) {
		
		$sql = "SELECT * FROM `orders` WHERE `cus_id` = ? AND `or_pay_status` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], $mode]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_ATTR($attr, $value) {
		$sql = "SELECT * FROM `orders` WHERE ".$attr." = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$value]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_RECENT($cus_id, $pay_status, $status) {
		
		$sql = "SELECT * FROM `orders` WHERE `cus_id` = ? AND `or_pay_status` = ? AND `or_status` = ? ORDER BY `or_time` DESC LIMIT 0,5";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, $pay_status, $status]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_LIMIT($attr, $value, $start, $row) {
		$sql = "SELECT * FROM `orders` WHERE ".$attr." = ? AND `cus_id` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$value, $_SESSION['cus_id']]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_LIMIT2($cus_id, $attr, $value, $start, $row) {
		$sql = "SELECT * FROM `orders` WHERE ".$attr." = ? AND `cus_id` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$value, $cus_id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	protected function INSERT($cus_id, $or_table, $or_phpsessid) {

		$sql = "INSERT INTO `orders` VALUES(NULL, ?, ?, DEFAULT, NULL, NULL, ?, DEFAULT, NULL, DEFAULT)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$cus_id, $or_table, $or_phpsessid]);
			$result = $db->lastInsertId();
			return $result;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function INSERT_DETAIL($or_id, $mf_id, $qty, $price, $kcal) {
		
		$sql = "INSERT INTO `orders_detail` VALUES(?, ?, DEFAULT, ?, ?, ?)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$or_id, $mf_id, $qty, $price, $kcal]);
			$result = $db->lastInsertId();
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function UPDATE($attr, $value, $id) {
		
		if ($value == "DEFAULT") {
			$sql = "UPDATE `orders` SET `".$attr."` = DEFAULT WHERE `or_id` = ?";
		} elseif ($value == "NULL") {
			$sql = "UPDATE `orders` SET `".$attr."` = NULL WHERE `or_id` = ?";
		} else {
			$sql = "UPDATE `orders` SET `".$attr."` = ? WHERE `or_id` = ?";
		}
		$stmt = $this->connect()->prepare($sql);

		try {
			if ($value == "DEFAULT") {
				$stmt->execute([$id]);
			} elseif ($value == "NULL") {
				$stmt->execute([$id]);
			} else {
				$stmt->execute([$value, $id]);
			}
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();			
		}
	}

}

?>