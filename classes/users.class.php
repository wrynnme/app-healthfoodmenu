<?php

class users extends Dbh {

	protected function SELECT($id) {
		$sql = "SELECT * FROM `customers` WHERE `cus_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		return $stmt;
	}

	protected function SELECT_TEL($tel) {
		$sql = "SELECT * FROM `customers` WHERE `cus_tel` = ?";
		if (!$stmt = $this->connect()->prepare($sql)) {
			echo 'Can\'t prepare';
			return false;
		} else {
			$stmt->execute([$tel]);
			return $stmt;
		}
	}

	protected function SELECT_ALL() {
		$sql = "SELECT * FROM `customers` WHERE `cus_id` = ? AND `cus_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$_SESSION['cus_id'], '1']);
		return $stmt;
	}

	protected function SELECT_EMAIL($email) {

		$sql = "SELECT * FROM `customers` WHERE `cus_email` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$email]);
		return $stmt;
	}

	protected function SELECT_NAME($search) {

		$sql = "SELECT * FROM `customers` WHERE (`cus_fname` like ?) OR (`cus_lname` like ?) AND `cus_id` = ? AND `cus_status` = ?";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $newSearch, $_SESSION['cus_id'], '1']);
		return $stmt;
	}

	protected function SELECT_LIMIT($search, $start, $row) {
		
		$sql = "SELECT * FROM `customers` WHERE (`cus_fname` like ?) OR (`cus_lname` like ?) AND `cus_id` = ? AND `cus_status` = ? LIMIT $start, $row";
		$stmt = $this->connect()->prepare($sql);
		$newSearch = '%'.$search.'%';
		$stmt->execute([$newSearch, $newSearch, $_SESSION['cus_id'], '1']);
		return $stmt;
	}

	protected function INSERT($fname, $lname, $rname, $email, $pass, $tel) {
		$sql = "INSERT INTO `customers` VALUES(?, ?, ?, ?, DEFAULT, ?, ?, ?, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT)";
		$stmt = $this->connect()->prepare($sql);
		$id = date("Ymd").substr(str_shuffle('1234567890'),0,5);
		$newpass = password_hash("$pass", PASSWORD_DEFAULT);
		$stmt->execute([$id, $fname, $lname, $rname, $email, $newpass, $tel]);
		$stmt->close();
	}

	protected function UPDATE($attr, $value, $id) {
		$sql = "UPDATE `customers` SET `".$attr."` = ? WHERE `cus_id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$value, $id]);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
	}

	protected function UPDATE_EMAIL($attr, $value, $email) {
		$sql = "UPDATE `customers` SET `".$attr."` = ? WHERE `cus_email` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$value, $email]);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}

	}

	protected function checkLogin($email) {
		$sql = "SELECT * FROM `customers` WHERE `cus_email` = ? AND `cus_status` = '1'";
		if (!$stmt = $this->connect()->prepare($sql)) {
			echo 'Can\'t prepare';
			return false;
		} else {
			$stmt->execute([$email]);
			$rows = $stmt->fetch();
			if (empty($rows)) {
				return false;
			} else {
				return $rows;
			}
		}
	}

	protected function SELECT_PWD($selector, $expries) {

		$sql = "SELECT * FROM `pwdreset` WHERE `pwd_selector` = ? AND `pwd_expires` >= ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$selector, $expries]);
			return $stmt;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	protected function INSERT_PWD($pwd_email, $pwd_selector, $pwd_token, $pwd_expires) {

		$sql = "INSERT INTO `pwdreset` VALUES(NULL, ?, ?, ?, ?)";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$pwd_email, $pwd_selector, $pwd_token, $pwd_expires]);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
	}

	protected function DELETE_PWD($email) {

		$sql = "DELETE FROM `pwdreset` WHERE `pwd_email` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$email]);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
		
	}


}

?>