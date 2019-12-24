<?php

class UsersContr extends Users {

	public function createUser($fname, $lname, $rname, $email, $pass, $tel) {

		$this->addUser($fname, $lname, $rname, $email, $pass, $tel);
		

	}

}

?>