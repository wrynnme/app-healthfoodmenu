<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_POST['action']) && ($_POST['action']) == 1) {
	$i = $_POST['i'];
	$_SESSION['new_user'][$i] = $_POST['txt'];
	// print_r($_SESSION['new_user']);
}
if (isset($_POST['action']) && ($_POST['action']) == 2) {
	$users = new userscontr();
	/*print_r($_SESSION['new_user']);
	echo $_POST['action'];*/
	$length = 5;
	$n  = '1234567890';
	$sn = substr(str_shuffle($n),0,$length);
	$cid = date("Ymd").$sn; #Customer ID Date with function gnum -> 5 number
	$fn = $_SESSION['new_user']['0'];
	$ln = $_SESSION['new_user']['1'];
	$rn = $_SESSION['new_user']['2'];
	$em = $_SESSION['new_user']['3'];
	$ps = $_SESSION['new_user']['4'];
	$tl = $_SESSION['new_user']['6'];

	$query = $users->create($fn, $ln, $rn, $em, $ps, $tl);
	if ($query) {
		unset($_SESSION['new_user']);
		echo "successful";
	}else{
		echo "unsuccessful";
	}
}
?>