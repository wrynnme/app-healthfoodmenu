<?php

class foodcontr extends food {

	public $food_name;
	public $food_price;
	public $food_kcal;
	public $food_type;

	public function newFood() {

		$ingtDB = array('1' => 'oils', '2' => 'eggs', '3' => 'seas', '4' => 'meats', '5' => 'vegetables', '6' => 'ran', '7' => 'nas', '8' => 'milks', '9' => 'fruits', '10' => 'garnishs');
		$result = $this->INSERTMF($this->food_name, $this->food_price, $this->food_kcal, $this->food_type);

		for ($i = 0; $i <= (int)$_SESSION["intLine"]; $i++) {
			$dbt = $this->SELECTINGRE($_SESSION['pro_id'][$i]);
			// echo $ingtDB[$dbt['ing_type']]." ".$result." ".$dbt['ing_id']." ".$_SESSION['gram'][$i]." ".$_SESSION['gram'][$i]."<br>";
			$result2 = $this->INSERTINGRET($ingtDB[$dbt['ing_type']], $result, $dbt['ing_id'], $_SESSION['gram'][$i], $_SESSION['gram'][$i]);
		}
		unset($_SESSION['intLine']);
		unset($_SESSION['currentSize']);
		unset($_SESSION['pro_id']);
		unset($_SESSION['gram']);
		unset($_SESSION['allcal']);
		unset($_SESSION['food_name']);
		unset($_SESSION['food_price']);
		unset($_SESSION['type_id']);
		unset($_SESSION['new_menu']);
		unset($_SESSION['edit_food']);
	}
}

?>