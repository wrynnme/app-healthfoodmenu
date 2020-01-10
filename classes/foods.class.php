<?php

abstract class foods extends dbh {

	protected function SELECT($id) {

		$sql = "SELECT * FROM `menu_foods` WHERE `mf_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	protected function SELECT_ORDER_MFID($cus_id, $mf_id) {

		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, $mf_id]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function SELECT_TBN($tbName, $mf_id) {

		$sql = "SELECT * FROM ".$tbName." WHERE `mf_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$mf_id]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	protected function SELECT_MENU($type) {

		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ? AND `type_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], '1', $type]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage;
		}
		
	}

	protected function SELECT_ALLMENU() {
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], '1']);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage;
		}
		
	}

	protected function SELECT_ORDER($cus_id) {
		
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, '1']);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function SELECT_ORDER_TYPE($cus_id, $type) {
		
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ? AND `type_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, '1', $type]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/*protected function SELECTALL() {
		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$_SESSION['cus_id'], '1']);

		$result = $stmt->fetchAll();
		return $result;
	}*/

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
			echo $e->getMessage();
		}
		
	}

	protected function SELECT_ALLMENULIMIT($start, $row) {

		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], '1']);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
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

	protected function INSERT_INGRET($dbt ,$lastid, $ing_id, $gram, $kcal) {

		$sql = "INSERT INTO ".$dbt." VALUES(NULL, ?, ?, ?, ?)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$lastid, $ing_id, $gram, $kcal]);
			$result = $db->lastInsertId();
			return $result;
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
		catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
	}

	protected function UPDATE($attr, $value, $id) {

		$sql = "UPDATE `menu_foods` SET `".$attr."` = ? WHERE `mf_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$value, $id]);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}

?>