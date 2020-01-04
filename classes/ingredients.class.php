<?php

class ingredients extends Dbh {

	protected function SELECT($id) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	protected function SELECTT($id) {
		$sql = "SELECT * FROM `ingredients_type` WHERE `ingt_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	protected function ALLOF($numberOfType) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_type` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$numberOfType]);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	protected function ALLTYPE() {
		$sql = "SELECT * FROM `ingredients_type`";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function SELECTFORWAIT($search) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_status` = '1' AND (`ing_name` like ?) ORDER BY `ing_time` DESC";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch]);

		$result = $stmt->fetchAll();
		return $result;
	}

	protected function SELECTALLTYPE($status, $numberOfType) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_status` = ? AND `ing_type` = ? ORDER BY `ing_type` ASC";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$status, $numberOfType]);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	protected function SELECTWITHTEXT($numberOfType, $search) {
		$sql = "SELECT * FROM `ingredients` WHERE (`ing_name` like ?) AND `ing_type` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $numberOfType]);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	protected function SELECTNAME($search) {

		$sql = "SELECT * FROM `ingredients` WHERE (`ing_name` like ?) AND `ing_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, '2']);

		$result = $stmt->fetchAll();
		return $result;
	}

	protected function SELECTLIMIT($search, $start, $row) {
		
		$sql = "SELECT * FROM `ingredients` WHERE (`ing_name` like ?) AND `ing_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, '2']);

		$result = $stmt->fetchAll();
		return $result;
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