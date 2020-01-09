<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_SESSION['order'])) {
	// echo count($_SESSION['order_submit']);
	if ($_SESSION['order_table'] != '' || $_SESSION['order_res_id'] != '') {
		$or_table = $_SESSION['order_table'];
		$cus_id = $_SESSION['order_res_id'];
		$or_kcal = $_SESSION['all_kcal'];
		$or_price = $_SESSION['all_price'];
		$or_phpsessid = session_id();
		$orders = new orderscontr();
		if (!isset($_SESSION['order_bill'])) {
			$order = $orders->add($cus_id, $or_table, $or_phpsessid);
			$_SESSION['order_bill'] = $order;
		}
		if (isset($_SESSION['order_bill'])) {
			for($d3=0; $d3 <= (int)@$_SESSION["order_line"][$_SESSION['order']]; $d3++) {
				@$mf_id = $_SESSION['order_id'][$_SESSION['order']][$d3];
				@$qty = $_SESSION['order_qty'][$_SESSION['order']][$d3];
				@$price = $_SESSION['order_price'][$_SESSION['order']][$d3];
				@$kcal = $_SESSION['order_kcal'][$_SESSION['order']][$d3];
				$or_id = $_SESSION['order_bill'];
				$detail = $orders->add_detail($or_id, $mf_id, $qty, $price, $kcal);
				if ($detail) {
					$_SESSION['order_submit'][$_SESSION['order']][$d3] = 1;
				}
			}
			$_SESSION['order']++;
			echo 'success';
		}else{
			echo 'f2';
			exit;
		}
	}else{
		echo 'error table or res_id';
		exit;
	}
}
?>