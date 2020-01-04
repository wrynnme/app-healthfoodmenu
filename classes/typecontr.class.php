<?php

class typecontr extends type {

	public function add($name) {
		$s = $this->S();
		$id = $s->rowCount();
		$newId = $id +1;
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

	public function mod($id, $value) {
		
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