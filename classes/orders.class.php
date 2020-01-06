<?php

abstract class orders extends Dbh {

	protected function SELECT($id) {
		$sql = "SELECT * FROM `orders` WHERE `or_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	protected function SELECT_ATTR($attr, $value) {
		$sql = "SELECT * FROM `orders` WHERE `cus_id` = ? AND ".$attr." = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], $value]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function SELECT_LIMIT($attr, $value, $start, $row) {
		$sql = "SELECT * FROM `orders` WHERE `cus_id` = ? AND ".$attr." = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$_SESSION['cus_id'], $value]);
			return $stmt;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

}

?>