<?php

class ingredients extends dbh {

	protected function SELECT($id) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		return $stmt;
	}

	protected function SELECT_TYPE($id) {
		$sql = "SELECT * FROM `ingredients_type` WHERE `ingt_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		return $stmt;
	}

	protected function SELECT_ALLOF($numberOfType) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_type` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$numberOfType]);

		return $stmt;
	}

	protected function SELECT_TYPEALL() {
		$sql = "SELECT * FROM `ingredients_type`";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	public function SELECT_FORWAIT($search) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_status` = '1' AND (`ing_name` like ?) ORDER BY `ing_time` DESC";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch]);

		return $stmt;
	}

	protected function SELECT_ALLTYPE($status, $numberOfType) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_status` = ? AND `ing_type` = ? ORDER BY `ing_type` ASC";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$status, $numberOfType]);

		return $stmt;
	}

	protected function SELECT_WITHTEXT($numberOfType, $search) {
		$sql = "SELECT * FROM `ingredients` WHERE (`ing_name` like ?) AND `ing_type` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $numberOfType]);

		return $stmt;
	}

	protected function SELECT_NAME($search) {

		$sql = "SELECT * FROM `ingredients` WHERE (`ing_name` like ?) AND `ing_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, '2']);

		return $stmt;
	}

	protected function SELECT_LIMIT($search, $start, $row) {
		
		$sql = "SELECT * FROM `ingredients` WHERE (`ing_name` like ?) AND `ing_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, '2']);

		return $stmt;
	}

	protected function INSERT($name, $kcal, $type) {
		$sql = "INSERT INTO `ingredients` VALUES(NULL, ?, '100', ?, DEFAULT, ?, DEFAULT, ?, '1')";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$name, $kcal, $type, $_SESSION['cus_id']]);
			$result = $db->lastInsertId();
			return $result;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function UPDATE($attr, $value, $id) {
		
		$sql = "UPDATE `ingredients` SET `".$attr."` = ? WHERE `ing_id` = ?";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$value, $id]);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
	}
}

?>