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
	
	$_SESSION['cus_fname'] = $fname;
	$_SESSION['cus_lname'] = $lname;
	$_SESSION['cus_rname'] = $rname;
	$_SESSION['cus_rtable'] = $rtable;
}

if (isset($_GET['del'])) {
	$cus_id = $_GET['del'];
	$users = new userscontr();
	$query = $users->change('cus_status', '0', $cus_id);
	if ($query) {
		header("Location: ../users_list.php");
		exit();
	}else{
		echo "fail";
		exit();
	}
}
?>