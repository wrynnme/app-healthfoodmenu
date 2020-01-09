<?php require_once 'class-autoload.inc.php'; ?>
<?php
if (isset($_POST['form_data'])) {
	$form_data = $_POST['form_data'];
	$oldpass = $form_data[0]['value'];
	$newpass = $form_data[1]['value'];
	$conpass = $form_data[2]['value'];
	$cus_id = $_POST['cus_id'];
	$users = new usersview();
	$user = $users->show($cus_id);
	$oldpass_verify = password_verify($oldpass, $user['cus_pass']);
	if ($oldpass_verify == 0) {
		echo "oldpass error";
		exit;
	}else{
		$password = password_hash($conpass, PASSWORD_DEFAULT);
		$users = new userscontr();
		$user = $users->change('cus_pass', $password, $cus_id);
		if ($user) {
			echo "success";
		}else{
			echo "fail";
		}
	}
}

?>