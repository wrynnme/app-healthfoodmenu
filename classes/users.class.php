<?php

class Users extends Dbh {

	protected function getUser($id) {
		
		$sql = "SELECT * FROM `customers` WHERE `cus_id` = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$id]);

		$result = $stmt->fetchAll();
		return $result;

	}

	protected function addUser($fname, $lname, $rname, $email, $pass, $tel) {
		$sql = "INSERT INTO `customers` VALUES(?, ?, ?, ?, DEFAULT, ?, ?, ?, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT)";
		$stmt = $this->connect()->prepare($sql);
		$id = date("Ymd").substr(str_shuffle('1234567890'),0,5);
		$newpass = password_hash("$pass", PASSWORD_DEFAULT);
		$stmt->execute([$id, $fname, $lname, $rname, $email, $newpass, $tel]);
	}

}

?>