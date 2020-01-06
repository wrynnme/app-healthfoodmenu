<?php

class userscontr extends users {

	public function create($fname, $lname, $rname, $email, $pass, $tel) {
		$this->INSERT($fname, $lname, $rname, $email, $pass, $tel);
	}

	public function change($attr, $value, $id) {
		// printf("attr: %s, value: %s, id: %s", $attr, $value, $id);
		$result = $this->UPDATE($attr, $value, $id);
		return $result;
	}

	public function Login($email, $password) {
		$user = $this->checkLogin($email);
		if (empty($user)) {
			return false;
		} else {
			if (password_verify($password, $user['cus_pass'])) {
				self::setSessionLogin($user);
				self::change('cus_login', '1', $user['cus_id']); 
				return $user;
			}else{
				return false;
			}
		}
	}

	public function setSessionLogin($data_array) {
		foreach ($data_array as $key => $value) {
			if (strstr($key, 'cus')) {
				$_SESSION[$key] = $value;
			}
		}
		return true;
	}

	public function genHashPassword($value)	{
		$hash = $hash = password_hash($value, PASSWORD_DEFAULT);
		return $hash;
	}

	public function checkTel($tel) {
		$stmt = $this->SELECT_TEL($tel);
		$count = $stmt->rowCount();
		return $count;
	}
}

?>