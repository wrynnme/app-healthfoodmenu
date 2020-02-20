<?php

abstract class foods extends dbh {

	protected function SELECT($id) {

		$sql = "SELECT * FROM `menu_foods` WHERE `mf_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}

	protected function SELECT_RECENT($cus_id, $status) {
		
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ? ORDER BY `mf_time` DESC LIMIT 0,5";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, $status]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_ORDER_MFID($cus_id, $mf_id) {

		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, $mf_id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_DETAIL($mf_id) {

		$sql = "SELECT * FROM `food_detail` WHERE `mf_id` = ? ORDER BY `ing_id` ASC";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$mf_id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}

	protected function SELECT_MENU($type) {

		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ? AND `type_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], '1', $type]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage;
		}
		
	}

	protected function SELECT_ALLMENU() {
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], '1']);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage;
		}
		
	}

	protected function SELECT_ORDER($cus_id) {
		
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, '1']);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_ORDER_TYPE($cus_id, $type) {
		
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ? AND `type_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, '1', $type]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_NAME($search) {

		$sql = "SELECT * FROM `menu_foods` WHERE (`mf_name` like ?) AND `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $_SESSION['cus_id'], '1']);

		return $stmt;
	}

	protected function SELECT_INGRET($id) {

		$sql = "SELECT * FROM `ingredients` WHERE `ing_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		return $stmt;
	}

	protected function SELECT_MENULIMIT($type, $start, $row) {

		$sql = "SELECT * FROM `menu_foods` WHERE `type_id` = ? AND `cus_id` = ? AND `mf_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$type, $_SESSION['cus_id'], '1']);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}

	protected function SELECT_ALLMENULIMIT($start, $row) {

		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], '1']);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
		
	}

	protected function SELECT_LIMIT($search, $start, $row) {
		
		$sql = "SELECT * FROM `menu_foods` WHERE (`mf_name` like ?) AND `cus_id` = ? AND `mf_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $_SESSION['cus_id'], '1']);

		return $stmt;
	}

	protected function INSERT_MF($fname, $fprice, $fkcal, $type) {

		$sql = "INSERT INTO `menu_foods` VALUES(NULL, ?, ?, ?, DEFAULT, DEFAULT, ?, ?, ?)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);
		if (empty($type)) {
			if ($stmt->execute([$fname, $fprice, $fkcal, $_SESSION['cus_id'], '1', NULL])) {
				$result = $db->lastInsertId();
				return $result;
			}
		} else {
			if ($stmt->execute([$fname, $fprice, $fkcal, $_SESSION['cus_id'], '1', $type])){
				$result = $db->lastInsertId();
				return $result;
			} else {
				echo "type is null";
				exit();
			}
		}
		
	}

	protected function UPDATE($attr, $value, $id) {

		if ($attr == 'type_id') {
			if ($value == '0') {
				$sql = "UPDATE `menu_foods` SET `".$attr."` = NULL WHERE `mf_id` = ?";
			} else {
				$sql = "UPDATE `menu_foods` SET `".$attr."` = ? WHERE `mf_id` = ?";
			}
		} else {
			$sql = "UPDATE `menu_foods` SET `".$attr."` = ? WHERE `mf_id` = ?";
		}

		
		$stmt = $this->connect()->prepare($sql);

		try {
			if ($attr == 'type_id') {
				if ($value == '0') {
					$stmt->execute([$id]);
				} else {
					$stmt->execute([$value, $id]);
				}
			} else {
				$stmt->execute([$value, $id]);
			}
			
			return true;

		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function DELETE($mf_id, $ing_id) {
		
		$sql = "DELETE FROM `food_detail` WHERE `mf_id` = ? AND ing_id = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$mf_id, $ing_id]);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function INSERT_INGRET($lastid, $ing_id, $gram, $kcal) {

		$sql = "INSERT INTO `food_detail` VALUES(?, ?, ?, ?)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$lastid, $ing_id, $gram, $kcal]);
			$result = $db->lastInsertId();
			return $result;
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
		catch (InvalidArgumentException $e) {
			return $e->getMessage();
		}
	}

	protected function UPDATE_INGRET($attr, $value, $mf_id, $ing_id) {
		
		$sql = "UPDATE `food_detail` SET `".$attr."` = ? WHERE `mf_id` = ? AND `ing_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$value, $mf_id, $ing_id]);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_SPECIAL($cus_id) {

		$sql = "SELECT * FROM `special_menu` WHERE `cus_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function INSERT_SPECIAL($cus_id, $mf_id) {
		$sql = "INSERT INTO `special_menu` VALUES(?, ?, DEFAULT, DEFAULT, DEFAULT)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$cus_id, $mf_id]);
			$result = $db->lastInsertId();
			return $result;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function DELETE_SPECIAL($cus_id, $mf_id) {
		// DELETE FROM `special_menu` WHERE `special_menu`.`cus_id` = ? AND `special_menu`.`mf_id` = ?
		$sql = "DELETE FROM `special_menu` WHERE `cus_id` = ? AND `mf_id` = ?";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$cus_id, $mf_id]);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

}
?>