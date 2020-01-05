<?php require_once 'class-autoload.inc.php'; ?>
<?php
if (isset($_POST['ing_name']) && isset($_POST['ing_kcal']) && isset($_POST['ing_type'])) {
	@SESSION_START();
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
	$cus_id = $_SESSION['cus_id'];
	$ings = new ingredientscontr();
	if ($fileError === 0) {
		$fileNameNew = uniqid('', true).".".$fileActualExt;
		$fileDestination = '../dist/img/ingredients/'.$fileNameNew;
		move_uploaded_file($fileTmpName, $fileDestination);

		$ing = $ings->add($ing_name, $ing_kcal, $ing_type);
		echo $ings->edit('ing_img', $fileNameNew, $ing);

	}else{
		echo ($ings->add($ing_name, $ing_kcal, $ing_type))?'1':'error!';
	}
}
?>