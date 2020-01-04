<?php 

class ingredientscontr extends ingredients {

	public function edit($attr, $value, $id) {
		$result = $this->UPDATE($attr, $value, $id);
		return $result;
	}	

}

?>