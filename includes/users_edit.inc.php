<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_POST['id'])) {
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$rname = $_POST['rname'];
	$tel = $_POST['tel'];
	$rtable = $_POST['rtable'];
	$file = $_FILES['logo'];
	$fileName = $_FILES['logo']['name'];
	$fileTmpName = $_FILES['logo']['tmp_name'];
	$fileSize = $_FILES['logo']['size'];
	$fileError = $_FILES['logo']['error'];
	$fileType = $_FILES['logo']['type'];
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'png');
	$oldfile = $_POST['old_logo'];
	$id = $_POST['id'];

	$users = new userscontr();
	if ($fileError === 0) {
		if (in_array($fileActualExt, $allowed) === true) {
			
			$fileNameNew = uniqid('', true).".".$fileActualExt;
			$fileDestination = '../dist/img/logos/'.$fileNameNew;
			if (move_uploaded_file($fileTmpName, $fileDestination)) {
				@unlink('../dist/img/logos/'.$oldfile);
				echo ($users->change('cus_logo', $fileNameNew, $id))? NULL: 'error';
				$_SESSION['cus_logo'] = $fileNameNew;
			}
		} else {
			echo 'error_logo';
		}
	}

	// printf("ID: %s, FN: %s, LN: %s, RN: %s, TEL: %s, RT: %s", $id, $fname, $lname, $rname, $tel, $rtable);

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
				if ($_SESSION['cus_id'] == $id) {
					$_SESSION['cus_permission'] = $permission;
				}

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
			if ($_SESSION['cus_id'] == $id) {
				$_SESSION['cus_permission'] = $permission;
			}

		}
		echo ($users->change('cus_fname', $fname, $id))? NULL: 'error';
		echo ($users->change('cus_lname', $lname, $id))? NULL: 'error';
		echo ($users->change('cus_res_name', $rname, $id))? NULL: 'error';
		echo ($users->change('cus_tel', $tel, $id))? NULL: 'error';
		echo ($users->change('cus_rtable', $rtable, $id))? NULL: 'error';
	}
	
	if ($_SESSION['cus_id'] == $id) {
		$_SESSION['cus_fname'] = $fname;
		$_SESSION['cus_lname'] = $lname;
		$_SESSION['cus_res_name'] = $rname;
		$_SESSION['cus_rtable'] = $rtable;
	}
	
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

if (isset($_GET['ac'])) {
	$cus_id = $_GET['ac'];
	$users = new userscontr();
	$query = $users->change('cus_status', '1', $cus_id);
	if ($query) {
		header("Location: ../users_list.php");
		exit();
	}else{
		echo "fail";
		exit();
	}
}

if (isset($_GET['rm_logo'])) {
	$cus_id = $_POST['cus_id'];
	$users = new userscontr();
	@unlink('../dist/img/logos/'.$_POST['old_logo']);
	echo ($users->change('cus_logo', NULL, $cus_id))?'success':'error';
}
?>