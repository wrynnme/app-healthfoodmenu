<?php require_once 'class-autoload.inc.php'; ?>
<?php
if($_GET["obj"] == "delete_account_cookie"){

	$key = $_POST["key"];
	setcookie("login[$key]", "", time() - 3600, '/');
	echo "success";
	exit();

}
if($_GET["obj"] == "check_login"){
	$login = new UsersContr();
	if (!$user = $login->Login($_POST['email'], $_POST['password'])) {
		echo 'error!';
		exit();
	} else {
		if (isset($_POST['remember'])) {
			$cookie_value = $user['cus_email'];
			if (isset($_COOKIE['login'])) {
				foreach($_COOKIE["login"] as $value){
					if($value != $cookie_value){
						setcookie("login[$cookie_value]", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
					}
				}
			}else{
				setcookie("login[$cookie_value]", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			}
		}
		unset($login);
		echo 'success';
	}
}
?>