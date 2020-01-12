<?php

class userscontr extends users {

	public function reset_password($email) {
		$stmt = $this->SELECT_EMAIL($email);
		$row = $stmt->rowCount();
		if ((int)$row != 1) {
			echo 'error mail not match';
			exit();
		}
		$selector = bin2hex(random_bytes(32));
		$token = random_bytes(8);
		$url = "reset_newpassword.php?s=".$selector."&t=".bin2hex($token);
		$expires = date("U") + 1800;

		$del = $this->DELETE_PWD($email);
		
		if (!$del) {
			echo 'error delete pwd_reset';
			exit();
		} else {
			$del = true;
		}
		$hashedToken = password_hash($token, PASSWORD_DEFAULT);
		$ins = $this->INSERT_PWD($email, $selector, $hashedToken, $expires);

		if (!$ins) {
			echo 'error delete pwd_reset';
			exit();
		} else {
			$ins = true;
			return $url;
		}
	}

	public function reset_newpassword($selector, $validator, $currentDate, $pwd) {

		$stmt = $this->SELECT_PWD($selector, $currentDate);
		if (!$row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo 'You need to re-submit your reset request.';
			exit();
		} else {
			$tokenBinary = hex2bin($validator);
			$tokenCheck = password_verify($tokenBinary, $row['pwd_token']);
			if ($tokenCheck === false) {
				echo 'You need to re-submit your reset request.';
				exit();
			} elseif ($tokenCheck === true) {
				$tokenEmail  = $row['pwd_email'];
				$stmt_mail = $this->SELECT_EMAIL($tokenEmail);
				if (!$row = $stmt_mail->fetch(PDO::FETCH_ASSOC)) {
					echo 'There was an error!';
					exit();
				} else {
					$newpwd = password_hash($pwd, PASSWORD_DEFAULT); 
					$update = $this->UPDATE_EMAIL('cus_pass', $newpwd, $tokenEmail);

					if (!$update) {
						echo 'Can\'t update new password!';
						exit();
					} else {
						$del = $this->DELETE_PWD($tokenEmail);
						if ($del) {
							echo 'password has change';
							exit();
						}
					}
				}
			}
		}
		
	}

	public function create($fname, $lname, $rname, $email, $pass, $tel) {
		$result = $this->INSERT($fname, $lname, $rname, $email, $pass, $tel);
		return $result;
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