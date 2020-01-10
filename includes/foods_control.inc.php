<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_GET['dcus'])) {
	/*$cus_id = $_GET['dcus'];
	$query = $con->query("UPDATE `customers` SET `cus_status` = '0' WHERE `cus_id` = '$cus_id'");
	if ($query) {
		sc("ลบสำเร็จ !!!");
	}else{
		sc("ไม่สามารถลบได้กรุณาติดต่อผู้ดูแล !!");
	}*/
}
if (isset($_GET['Line'])) {
	$Line = $_GET['Line'];
	$_SESSION["pro_id"][$Line] = "";
	$_SESSION["gram"][$Line] = "";
	$_SESSION["allcal"][$Line] = "";
	$_SESSION["currentSize"]--;
	if ($_GET['from'] == 'edit') {
		$link = "foods_edit.php?id=".$_SESSION['edit_food'];
		header("Location: ../$link");
	}elseif ($_GET['from'] == 'add') {
		header("Lcaotion: ../foods_add.php");
	}
}
if (isset($_GET['cancelmenu'])) {
	uns('menu');
	hd('product.php');
}
if (isset($_GET['cancelfood'])) {
	/*$id = $_GET['cancelfood'];
	$cus_id = $_SESSION['cus_id'];	
	$chk1 = $con->query("SELECT * FROM `menu_foods` WHERE `mf_id` = '$id' AND `cus_id` = '$cus_id' ");
	$chk2 = nr($chk1);
	if ((int)$chk2 > 0) {
		$x = $con->query("UPDATE `menu_foods` SET `mf_status` = '0' WHERE `mf_id` = '$id' AND `cus_id` = '$cus_id' ");
		if ($x) {
			uns('menu');
			hd('index.php');
		}
	}*/
}
?>