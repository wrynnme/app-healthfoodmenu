<?php

class typecontr extends type {

	public function add($name) {
		$stmt = $this->SELECT_ADD();
		$data = $stmt->fetch(PDO::FETCH_NUM);
		$newId = $data[0] +1;
		$result = $this->INSERT($newId, $name);
		return true;
	}

	public function del($id) {
		
		try {
			$this->UPDATE($id, 'type_status', '0');
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
	}

	public function edit($id, $value) {
		
		try {
			$this->UPDATE($id, 'type_name', $value);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
		} catch (InvalidArgumentException $e) {
			echo $e->getMessage();
		}
	}

}

?>