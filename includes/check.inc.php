<?php require_once 'class-autoload.inc.php'; ?>
<?php

if (isset($_GET['m'])) {
	if ($_GET['m'] == 'tel') {
		$users = new usersview();
		if (isset($_POST['cus_id'])) {
			$cus_id = $_POST['cus_id'];
			$tel = $_POST['tel'];
			$data = $users->getTel($tel);
			$row = $users->num_rows;
			if ($data['cus_id'] == $cus_id) {
				echo true;
				return true;
			}else{
				if ($row == 0) {
					echo true;
					return true;
				}else{
					echo false;
					return false;
				}
			}
		}else{
			$tel = $_POST['tel'];
			$data = $users->getTel($tel);
			$row = $users->num_rows;
			if ($row == 0) {
				echo true;
				return true;
			}else{
				echo false;
				return false;
			}
		}
	}

	if ($_GET['m'] == 'email') {
		$email = $_POST['email'];
		$users = new usersview();
		$data = $users->getEmail($email);
		echo $row = $users->num_rows;
	}
}

?>