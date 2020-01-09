<?php

abstract class type extends Dbh {

	protected function SELECT($id) {
		$sql = "SELECT * FROM `type_food` WHERE `type_id` = ? AND `cus_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id, $_SESSION['cus_id']]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function SELECT_SESSION() {
		$sql = "SELECT * FROM `type_food` WHERE `cus_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		
		try {
			$stmt->execute([$_SESSION['cus_id']]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function SELECT_ALL() {
		$sql = "SELECT * FROM `type_food` WHERE `cus_id` = ? AND `type_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		
		try {
			$stmt->execute([$_SESSION['cus_id'], '1']);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function SELECT_ORDER($cus_id) {
		
		$sql = "SELECT * FROM `type_food` WHERE `cus_id` = ? AND `type_status` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, '1']);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function SELECT_ORDER_TYPE($cus_id, $type_id) {

		$sql = "SELECT * FROM `type_food` WHERE `cus_id` = ? AND `type_status` = ? AND `type_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$cus_id, '1', $type_id]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	protected function SELECT_NAME($search) {

		$sql = "SELECT * FROM `type_food` WHERE (`type_name` like ?) AND `cus_id` = ? AND `type_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $_SESSION['cus_id'], '1']);
		return $stmt;
	}

	protected function SELECT_LIMIT($search, $start, $row) {
		
		$sql = "SELECT * FROM `type_food` WHERE (`type_name` like ?) AND `cus_id` = ? AND `type_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $_SESSION['cus_id'], '1']);
		return $stmt;
	}

	protected function INSERT($id, $name) {
		
		$sql = "INSERT INTO `type_food` VALUES(?, ?, ?, ?)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$id, $_SESSION['cus_id'], $name, '1']);
			$result = $db->lastInsertId();
			return $result;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
	}

	protected function UPDATE($id, $where, $value) {

		$sql = "UPDATE `type_food` SET ".$where." = ? WHERE `cus_id` = ? AND `type_id` = ?";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$value, $_SESSION['cus_id'], $id]);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
		
	}
}

?>