<?php require_once 'config.inc.php'; ?>
<?php
if($_GET["obj"] == "delete_account_cookie"){
	$key = $_POST["key"];
	setcookie("cus_id[$key]", "", time() - 3600, '/');
	echo "success";
}
if($_GET["obj"] == "check_login"){
	$em = $con->real_escape_string($_POST["email"]);
	$ps = $con->real_escape_string($_POST["password"]);
	if(isset($_POST["remember"])){
		$rm = $_POST["remember"];
	}
	$ck = $con->query("SELECT * FROM `customers` WHERE cus_email = '$em'");
	$hp = fa($ck);
	$vr = HPVerify($ps,$hp['cus_pass']);
	if($vr){
		$_SESSION['cus_id'] = $hp['cus_id'];
		$_SESSION['cus_fname'] = $hp['cus_fname'];
		$_SESSION['cus_lname'] = $hp['cus_lname'];
		$_SESSION['cus_rname'] = $hp['cus_res_name'];
		$_SESSION['cus_rtable'] = $hp['cus_rtable'];
		$_SESSION['cus_permission'] = $hp['cus_permission'];
		$_SESSION['cus_email'] = $hp['cus_email'];
		$cus_id = $hp['cus_id'];

		if(isset($rm)){
			$cookie_value = $hp['cus_rname']; //Name on history login
			if(isset($_COOKIE["cus_id"])){
				foreach($_COOKIE["cus_id"] as $v){
					if($v != $hp["cus_id"]){
						setcookie("cus_id[$cookie_value]", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
					}
				}
			}else{
				setcookie("cus_id[$cookie_value]", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			}
		}
		$con->query("UPDATE `customers` SET `cus_login` = '1', `cus_login_time` = DEFAULT WHERE `customers`.`cus_id` = '$cus_id'");
		echo "success";
	}else{
		echo "false";
	}
}
?>