<?php
@SESSION_START();
require_once 'class-autoload.inc.php';
if (@$_GET['s']) {
	if ($_GET['s'] == 'edit_food') {
		unset($_SESSION['intLine']);
		unset($_SESSION['pro_id']);
		unset($_SESSION['gram']);
		unset($_SESSION['allcal']);
		unset($_SESSION['food_name']);
		unset($_SESSION['food_price']);
		unset($_SESSION['type_id']);
		unset($_SESSION['edit_food']);
		unset($_SESSION['currentSize']);
		unset($_SESSION['old_ingt']);
		unset($_SESSION['old_gram']);
		unset($_SESSION['old_allcal']);
		unset($_SESSION['thismenu']);
		unset($_SESSION['old_img']);
	} elseif($_GET['s'] == 'menu') {
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

	} else {
		unset($_SESSION[$_GET['s']]);
	}
	header("Location: ../index.php");
	// echo "<script>window.history.back();</script>";
}

if (@$_GET['cancelfood']) {
	$id = $_GET['cancelfood'];
	$cus_id = $_SESSION['cus_id'];
	$foods = new foodsview();
	$food = $foods->myOrder($cus_id, $id);
	$chk = $foods->num_row;
	if ((int)$chk > 0) {
		$foodCon = new foodscontr();
		$x = $food = $foodCon->edit("mf_status", "0", $id);
		if ($x) {
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
			header("Location: ../index.php");
		}
	}
}