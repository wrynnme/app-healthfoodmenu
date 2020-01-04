<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_SESSION['food_name']) && isset($_SESSION['food_price'])) {
	if ((isset($_SESSION['intLine']) && isset($_SESSION['pro_id']) && isset($_SESSION['allcal']))  ) {
		if (sizeof($_SESSION['pro_id']) == sizeof($_SESSION['gram'])) {
			$foods = new foodcontr();
			$foods->food_name = $_SESSION['food_name'];
			$foods->food_price = $_SESSION['food_price'];
			$foods->food_kcal = array_sum($_SESSION['allcal']);
			if (empty($_SESSION['type_id'])) {
				$foods->food_type = "";
			} else {
				$foods->food_type = $_SESSION['type_id'];
			}
			try {
				$foods->newFood();
				unset($foods);
				echo 'success';
			}
			catch (Exception $e) {
				echo $e->getMessage();
			}
			catch (InvalidArgumentException $e) {
				echo $e->getMessage();
			}
		}else{
			echo 'gram';
			exit();
		}
	}else{
		echo 'ingt';
		exit();
	}
}else{
	echo 'name';
	exit();
}
?>