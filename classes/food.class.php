<?php

abstract class food extends Dbh {

	protected function SELECT($id) {

		$sql = "SELECT * FROM `menu_foods` WHERE `mf_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		$result = $stmt->fetch();
		return $result;
	}

	protected function SELECTALL() {

		$sql = "SELECT * FROM `menu_foods` WHERE `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$_SESSION['cus_id'], '1']);

		$result = $stmt->fetchAll();
		return $result;
	}

	protected function SELECTNAME($search) {

		$sql = "SELECT * FROM `menu_foods` WHERE (`mf_name` like ?) AND `cus_id` = ? AND `mf_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $_SESSION['cus_id'], '1']);

		$result = $stmt->fetchAll();
		return $result;
	}

	protected function SELECTINGRE($id) {
		$sql = "SELECT * FROM `ingredients` WHERE `ing_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	protected function SELECTLIMIT($search, $start, $row) {
		
		$sql = "SELECT * FROM `menu_foods` WHERE (`mf_name` like ?) AND `cus_id` = ? AND `mf_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $_SESSION['cus_id'], '1']);

		$result = $stmt->fetchAll();
		return $result;
	}

	protected function INSERTMF($fname, $fprice, $fkcal, $type) {

		$sql = "INSERT INTO `menu_foods` VALUES(NULL, ?, ?, ?, DEFAULT, DEFAULT, ?, ?, ?)";
		$db = $this->connect();
		$stmt = $db->prepare($sql);
		
		if (is_null($type)) {
			echo $type;
			exit();
		}
		if ($stmt->execute([$fname, $fprice, $fkcal, $_SESSION['cus_id'], '1', $type])){
			$result = $db->lastInsertId();
			return $result;
		} else {
			if ($stmt->execute([$fname, $fprice, $fkcal, $_SESSION['cus_id'], '1', NULL])) {
				$result = $db->lastInsertId();
				return $result;
			} else {
				echo "type is null";
				exit();
			}
		}
	}

	protected function INSERTINGRET($dbt ,$lastid, $ing_id, $gram, $kcal) {

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
}

?>