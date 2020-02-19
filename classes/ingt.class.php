<?php

abstract class ingt extends dbh {

	public function __construct() {

	}

	protected function INSERT($name) {
		$sql = "INSERT INTO `ingredients_type` VALUES(NULL, ?)";
		$stmt = $this->connect()->prepare($sql);
		
		try {
			$stmt->execute([$name]);
			$result = $db->lastInsertId();
			return $result;
		} catch (Exception $e) {
			return $e->getMessage();
		} catch (InvalidArgumentException $e) {
			return $e->getMessage();
		}
	}

	protected function UPDATE($id, $value) {
		$sql = "UPDATE `ingredients_type` SET `ingt_name` = ? WHERE `ingt_id` = ?";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$value, $id]);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		} catch (InvalidArgumentException $e) {
			return $e->getMessage();
		}
	}

	protected function DELETE($id) {
		$sql = "DELETE FROM `ingredients_type` WHERE `ingt_id` = ?";
		$db = $this->connect();
		$stmt = $db->prepare($sql);

		try {
			$stmt->execute([$id]);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		} catch (InvalidArgumentException $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT() {
		$sql = "SELECT * FROM `ingredients_type`";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		} catch (InvalidArgumentException $e) {
			return $e->getMessage();
		}
	}

	protected function SELECT_ID($id) {
		$sql = "SELECT * FROM `ingredients_type` WHERE `ingt_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		} catch (InvalidArgumentException $e) {
			return $e->getMessage();
		}
	}

	
}

?>