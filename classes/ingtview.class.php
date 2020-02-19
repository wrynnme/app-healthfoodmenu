<?php

class ingtview extends ingt {

	public function list()	{
		$stmt = $this->SELECT();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
		
}

?>