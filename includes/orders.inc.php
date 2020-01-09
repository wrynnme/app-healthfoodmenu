<?php require_once 'class-autoload.inc.php'; ?>
<?php
@$res_id = $_POST['res_id'];
@SESSION_START();
if (isset($_POST['order'])) {
	$res_id = $_POST['res_id'];
	$order_id = $_POST['order'];
	$foods = new foodsview();
	$x = $foods->myOrder($res_id, $order_id);
	$kcal = $x['mf_kcal'];
	$price = $x['mf_price'];
	if (!isset($_SESSION['order'])) {
		$_SESSION['order'] = 0;
	}
	if (!isset($_SESSION['order_line'][$_SESSION['order']])) {
		$_SESSION['order_size'] = 1;
		$_SESSION['order_line'][$_SESSION['order']] = 0;
		$_SESSION['order_id'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = $order_id;
		$_SESSION['order_qty'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = 1;
		$_SESSION['order_kcal'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = $kcal * $_SESSION['order_qty'][$_SESSION['order']][0];
		$_SESSION['order_price'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = $price * $_SESSION['order_qty'][$_SESSION['order']][0];
		$_SESSION['order_submit'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = 0;
		$_SESSION['total_kcal'][$_SESSION['order']] = array_sum($_SESSION['order_kcal'][$_SESSION['order']]);
		$_SESSION['total_price'][$_SESSION['order']] = array_sum($_SESSION['order_price'][$_SESSION['order']]);
	}else{
		$key = array_search($order_id, $_SESSION['order_id'][$_SESSION['order']]);
		if ((string)$key != '') {
			if ((string)$_SESSION['order_submit'][$_SESSION['order']][$key] == '0') {
				$_SESSION['order_qty'][$_SESSION['order']][$key]++;
				$_SESSION['order_kcal'][$_SESSION['order']][$key] = $kcal * $_SESSION['order_qty'][$_SESSION['order']][$key];
				$_SESSION['order_price'][$_SESSION['order']][$key] = $price * $_SESSION['order_qty'][$_SESSION['order']][$key];
				$_SESSION['total_kcal'][$_SESSION['order']] = array_sum($_SESSION['order_kcal'][$_SESSION['order']]);
				$_SESSION['total_price'][$_SESSION['order']] = array_sum($_SESSION['order_price'][$_SESSION['order']]);
			}else{
				echo 'Oops';
				exit();
			}
		}else{
			$_SESSION['order_size']++;
			$_SESSION['order_line'][$_SESSION['order']]++; // ตัวชี้ตำแหน่ง Array
			$_SESSION['order_id'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = $order_id;
			$_SESSION['order_qty'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = 1;
			$_SESSION['order_kcal'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = $kcal * $_SESSION['order_qty'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]];
			$_SESSION['order_price'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = $price * $_SESSION['order_qty'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]];
			$_SESSION['order_submit'][$_SESSION['order']][$_SESSION['order_line'][$_SESSION['order']]] = 0;
			$_SESSION['total_kcal'][$_SESSION['order']] = array_sum($_SESSION['order_kcal'][$_SESSION['order']]);
			$_SESSION['total_price'][$_SESSION['order']] = array_sum($_SESSION['order_price'][$_SESSION['order']]);
		}
	}
	$_SESSION['all_kcal'] = array_sum($_SESSION['total_kcal']);
	$_SESSION['all_price'] = array_sum($_SESSION['total_price']);
	exit(0376);
}

if (isset($_GET['del']) && isset($_GET['r'])) {
	$del_id = $_GET['del'];
	$res_id = $_GET['r'];
	$foods = new foodsview();
	$x = $foods->myOrder($res_id, $del_id);
	$n = count($x);
	$kcal = $x['mf_kcal'];
	$price = $x['mf_price'];
	if ($n == 9) {
		$del_key = array_search($del_id, $_SESSION['order_id'][$_SESSION['order']]);
		if ((string)$del_key != "") {
			$_SESSION['order_qty'][$_SESSION['order']][$del_key]--;
			$_SESSION['order_kcal'][$_SESSION['order']][$del_key] = $kcal * $_SESSION['order_qty'][$_SESSION['order']][$del_key];
			$_SESSION['order_price'][$_SESSION['order']][$del_key] = $price * $_SESSION['order_qty'][$_SESSION['order']][$del_key];
			$_SESSION['total_kcal'][$_SESSION['order']] = array_sum($_SESSION['order_kcal'][$_SESSION['order']]);
			$_SESSION['total_price'][$_SESSION['order']] = array_sum($_SESSION['order_price'][$_SESSION['order']]);
			if ($_SESSION['order_qty'][$_SESSION['order']][$del_key] <= 0) {
				$_SESSION['order_size']--;
				$_SESSION['order_id'][$_SESSION['order']][$del_key] = "";
				$_SESSION['order_qty'][$_SESSION['order']][$del_key] = "";
				$_SESSION['order_kcal'][$_SESSION['order']][$del_key] = "";
				$_SESSION['order_price'][$_SESSION['order']][$del_key] = "";
				$_SESSION['total_kcal'][$_SESSION['order']] = array_sum($_SESSION['order_kcal'][$_SESSION['order']]);
				$_SESSION['total_price'][$_SESSION['order']] = array_sum($_SESSION['order_price'][$_SESSION['order']]);
			}
		}
	}else{
		echo 'Error Res ID';
		exit;	
	}
	$_SESSION['all_kcal'] = array_sum($_SESSION['total_kcal']);
	$_SESSION['all_price'] = array_sum($_SESSION['total_price']);
	echo "<script>window.history.back();</script>";
	exit(0376);
}
if (isset($_POST['pay_status'])) {
	if ($_POST['pay_status'] == '0') {
		$id = $_POST['id'];
		$cus_id = $_SESSION['cus_id'];
		$pay_status = $_POST['pay_status'];
		$orders = new orderscontr();
		$order = $orders->set('or_pay_status', $pay_status, $id);
		$order = $orders->set('or_time_newStatus', 'DEFAULT', $id);
		if ($order) {
			echo 'success';
			unset($orders);
		}
	}
	if ($_POST['pay_status'] == '1') {
		$cus_id = $_POST['cus_id'];
		$id = $_SESSION['order_bill'];
		$pay_status = $_POST['pay_status'];
		$orders = new orderscontr();
		$order = $orders->set('or_pay_status', $pay_status, $id);
		$order = $orders->set('or_time_newStatus', 'DEFAULT', $id);
		if ($order) {
			unset($_SESSION['order']);
			unset($_SESSION['order_size']);
			unset($_SESSION['order_table']);
			unset($_SESSION['order_res_id']);
			unset($_SESSION['order_line']);
			unset($_SESSION['order_id']);
			unset($_SESSION['order_qty']);
			unset($_SESSION['order_kcal']);
			unset($_SESSION['order_price']);
			unset($_SESSION['order_submit']);
			unset($_SESSION['order_bill']);
			unset($_SESSION['total_kcal']);
			unset($_SESSION['total_price']);
			unset($_SESSION['all_kcal']);
			unset($_SESSION['all_price']);
			echo 'success';
			unset($orders);
		}
	}
	if ($_POST['pay_status'] == '2') {
		$id = $_POST['id'];
		$kcal = $_POST['kcal'];
		$price = $_POST['price'];
		$cus_id = $_SESSION['cus_id'];
		$pay_status = $_POST['pay_status'];
		$orders = new orderscontr();
		$order = $orders->set('or_kcal', $kcal, $id);
		$order = $orders->set('or_price', $price, $id);
		$order = $orders->set('or_pay_status', $pay_status, $id);
		$order = $orders->set('or_time_newStatus', 'DEFAULT', $id);
		if ($order) {
			echo 'success';
			unset($orders);
		}
	}
}
if (isset($_POST['status'])) {
	if ($_POST['status'] == '0') {
		$id = $_POST['id'];
		$cus_id = $_SESSION['cus_id'];
		$status = $_POST['status'];
		$orders = new orderscontr();
		$order = $orders->set('or_status', $status, $id);
		$order = $orders->set('or_time_newStatus', 'DEFAULT', $id);
		if ($order) {
			echo 'success';
			unset($orders);
		}
	}
	if ($_POST['status'] == '1') {
		$id = $_POST['id'];
		$orders = new orderscontr();
		$order = $orders->set('or_pay_status', '0', $id);
		$order = $orders->set('or_status', '1', $id);
		$order = $orders->set('or_time_newStatus', 'DEFAULT', $id);
		if ($order) {
			echo 'success';
			unset($orders);
		}
	}
}
?>