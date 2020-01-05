<?php require_once 'class-autoload.inc.php'; ?>
<?php
if (isset($_POST['ing_id'])) {
	$ings = new ingredientscontr();
	$ing_name = $_POST['ing_name'];
	$ing_kcal = $_POST['ing_kcal'];
	$file = $_FILES['ing_img'];
	$fileName = $_FILES['ing_img']['name'];
	$fileTmpName = $_FILES['ing_img']['tmp_name'];
	$fileSize = $_FILES['ing_img']['size'];
	$fileError = $_FILES['ing_img']['error'];
	$fileType = $_FILES['ing_img']['type'];
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'png', 'pdf');
	$ing_type = $_POST['ing_type'];
	$ing_status = $_POST['ing_status'];
	$cus_id = $_SESSION['cus_id'];
	$ing_id = $_POST['ing_id'];
	$old_pic = $_POST['old_pic'];
	if ($fileError === 0) {
		$fileNameNew = uniqid('', true).".".$fileActualExt;
		$fileDestination = '../dist/img/ingredients/'.$fileNameNew;
		move_uploaded_file($fileTmpName, $fileDestination);
		if ($old_pic != '404-img.png') {
			@unlink('../dist/img/ingredients/'.$old_pic);
		}
		echo ($ings->edit('ing_name', $ing_name, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_kcal', $ing_kcal, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_type', $ing_type, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_status', $ing_status, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_time', 'DEFAULT', $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_img', $fileNameNew, $ing_id))? NULL : 'error';
	}else{
		echo ($ings->edit('ing_name', $ing_name, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_kcal', $ing_kcal, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_type', $ing_type, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_status', $ing_status, $ing_id))? NULL : 'error';
		echo ($ings->edit('ing_time', 'DEFAULT', $ing_id))? NULL : 'error';
	}
}
?>