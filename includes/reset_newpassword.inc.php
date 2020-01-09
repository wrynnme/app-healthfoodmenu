<?php require_once 'class-autoload.inc.php'; ?>
<?php
if (isset($_POST['pwd'])) {
	$selector = $_POST['selector'];
	$validator = $_POST['validator'];
	$pwd = $_POST['pwd'];
	$pwd_repeat = $_POST['pwd-repeat'];

	if (empty($selector) || empty($validator)) {
		echo 'empty';
		exit();
	}elseif ($pwd != $pwd_repeat) {
		echo 'password not match';
		exit();
	}
	$currentDate = date("U");
	$users = new userscontr();
	echo $user = $users->reset_newpassword($selector, $validator, $currentDate, $pwd);

}else{
	header('Location: login.php');
}
?>