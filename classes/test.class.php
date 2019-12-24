<?php

class Test extends Dbh {

	public function getUsers() {
		$sql = "SELECT * FROM `customers`";
		$stmt = $this->connect()->query($sql);
		while($row = $stmt->fetch()) {
			echo $row['cus_id'].' '.$row['cus_fname'].' '.$row['cus_lname'].'</br>';
		}
	}

	public function getUsersStmt($fname, $lname) {
		$sql = "SELECT * FROM `customers` WHERE `cus_fname` = ? AND `cus_lname` = ?";
		$stmt = $this->connect()->prepare($sql);
		// $stmt->bind_param('ss',$fname, $lname);
		$stmt->execute([$fname, $lname]);
		
		$result = $stmt->fetchAll();

		foreach ($result as $key => $value ) {
			echo $key.' '.$value['cus_id'].' '.$value['cus_fname'].' '.$value['cus_lname'].' '.'<br>';
		}
	}

	public function setUsers($fname, $lname, $rname, $email, $pass, $tel) {
		$sql = "INSERT INTO `customers` VALUES(?, ?, ?, ?, DEFAULT, ?, ?, ?, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT)";
		$stmt = $this->connect()->prepare($sql);
		$id = date("Ymd").substr(str_shuffle('1234567890'),0,5);
		$newpass = password_hash("$pass", PASSWORD_DEFAULT);
		// $stmt->execute([$id, $fname, $lname, $rname, $email, $newpass, $tel]);
		if ($stmt->execute([$id, $fname, $lname, $rname, $email, $newpass, $tel])){
			echo 'add customers success';
		}else{
			echo $sql;
		}
	}

}



?>