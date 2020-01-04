<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_POST['id'])) {
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$rname = $_POST['rname'];
	$tel = $_POST['tel'];
	$rtable = $_POST['rtable'];

	$id = $_POST['id'];
	// printf("ID: %s, FN: %s, LN: %s, RN: %s, TEL: %s, RT: %s", $id, $fname, $lname, $rname, $tel, $rtable);
	$users = new userscontr();

	if (($users->checkTel($tel)) > 0) {
		$me = new usersview();
		$m = $me->getTel($tel);
		if ((string)$m['cus_id'] != (string)$id) {
			echo 'error tel';
			exit();
		} else {
			if (isset($_POST['permission'])) {
				$permission = $_POST['permission'];
				echo ($users->change('cus_permission', $permission, $id))? NULL: 'error';
				$_SESSION['cus_permission'] = $permission;
			}
			echo ($users->change('cus_fname', $fname, $id))? NULL: 'error';
			echo ($users->change('cus_lname', $lname, $id))? NULL: 'error';
			echo ($users->change('cus_res_name', $rname, $id))? NULL: 'error';
			echo ($users->change('cus_rtable', $rtable, $id))? NULL: 'error';
		}
	} else {
		if (isset($_POST['permission'])) {
			$permission = $_POST['permission'];
			echo ($users->change('cus_permission', $permission, $id))? NULL: 'error';
			$_SESSION['cus_permission'] = $permission;
		}
		echo ($users->change('cus_fname', $fname, $id))? NULL: 'error';
		echo ($users->change('cus_lname', $lname, $id))? NULL: 'error';
		echo ($users->change('cus_res_name', $rname, $id))? NULL: 'error';
		echo ($users->change('cus_tel', $tel, $id))? NULL: 'error';
		echo ($users->change('cus_rtable', $rtable, $id))? NULL: 'error';
	}

	/*$numberTel = $con->query("SELECT * FROM `customers` WHERE `cus_tel` = '$tel'");
	if (nr($numberTel) != 0) {
		$number_error = fa($numberTel);
		if ((string)$number_error['cus_id'] == (string)$id) {
			if (isset($_POST['permission'])) {
				$permission = $_POST['permission'];
				if ($con->query("UPDATE `customers` SET `cus_fname` = '$fname', `cus_lname` = '$lname', `cus_res_name` = '$rname', `cus_rtable` = '$rtable', `cus_permission` = '$permission' WHERE `cus_id` = '$id'")) {
					echo 'success';
					exit;
				}
				$_SESSION['cus_permission'] = $permission;

			}else{
				if ($con->query("UPDATE `customers` SET `cus_fname` = '$fname', `cus_lname` = '$lname', `cus_res_name` = '$rname', `cus_rtable` = '$rtable' WHERE `cus_id` = '$id'")) {
					echo 'success';
					exit;
				}
			}
		}
		echo 'error tel';
		exit;
	}else{
		if (isset($_POST['permission'])) {
			$permission = $_POST['permission'];
			if ($con->query("UPDATE `customers` SET `cus_fname` = '$fname', `cus_lname` = '$lname', `cus_res_name` = '$rname', `cus_tel` = '$tel', `cus_rtable` = '$rtable', `cus_permission` = '$permission' WHERE `cus_id` = '$id'")) {
				echo 'success';
				exit;
			}
			$_SESSION['cus_permission'] = $permission;
		}else{
			if ($con->query("UPDATE `customers` SET `cus_fname` = '$fname', `cus_lname` = '$lname', `cus_res_name` = '$rname', `cus_tel` = '$tel', `cus_rtable` = '$rtable' WHERE `cus_id` = '$id'")) {
				echo 'success';
				exit;
			}
		}
	}*/
	$_SESSION['cus_fname'] = $fname;
	$_SESSION['cus_lname'] = $lname;
	$_SESSION['cus_rname'] = $rname;
	$_SESSION['cus_rtable'] = $rtable;
}
?>