<?php

class UsersView extends Users {

	public function showUser($id) {
		
		return $results = $this->getUser($id);

	}

}

?>