<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_GET['Line'])) {
	$Line = $_GET['Line'];
	$_SESSION["pro_id"][$Line] = "";
	$_SESSION["gram"][$Line] = "";
	$_SESSION["allcal"][$Line] = "";
	$_SESSION["currentSize"]--;
	if ($_GET['from'] == 'edit') {
		$link = "foods_edit/id/".$_SESSION['edit_food'];
		header("Location: ../$link");
	}elseif ($_GET['from'] == 'add') {
		header("Location: ../foods_add");
	}
}

if (isset($_GET['cancelfood'])) {
	$id = $_GET['cancelfood'];
	$cus_id = $_SESSION['cus_id'];
	$foodsv = new foodsview();
	$chk1 = $foodsv->myOrder($cus_id, $id);
	$chk2 = $foodsv->num_row;

	if ((int)$chk2 > 0) {
		$foodsc = new foodscontr();
		$x = $foodsc->edit('mf_status', '0', $id);
		if ($x) {
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
			header('Location: ../foods_list');
		}
	}
}
?>