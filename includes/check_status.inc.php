<?php require_once 'class-autoload.inc.php'; ?>
<?php
	@SESSION_START();
	

if (isset($_GET['status'])) {

	$users = new usersview();
	$user = $users->show($_SESSION['cus_id']);
	echo $user['cus_status'];
}


if (isset($_GET['online'])) {

	$users = new usersview();
	$user = $users->show($_GET['online']);
	echo $user['cus_login'];
}
?>