<?php 

class ingredientscontr extends ingredients {

	public function add($name, $kcal, $type) {
		$result = $this->INSERT($name, $kcal, $type);
		return $result;
	}

	public function edit($attr, $value, $id) {
		$result = $this->UPDATE($attr, $value, $id);
		return $result;
	}

}

?>