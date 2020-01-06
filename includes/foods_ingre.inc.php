<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();

if (isset($_POST['allcal'])) {
	$allcal = $_POST['allcal'];
	$count = $_POST['count'];
	$_SESSION['gram'][$count] = $_POST['gram'];
	$_SESSION['allcal'][$count] = $allcal;
	echo "<h4>แคลอรี่ทั้งหมด : ".array_sum(@$_SESSION['allcal'])."</h4>";
	exit();
}
if (isset($_POST['food_name'])) {
	$_SESSION['food_name'] = $_POST['food_name'];
}
if (isset($_POST['food_price'])) {
	$_SESSION['food_price'] = $_POST['food_price'];
	// $_SESSION['food_price'] = number_format($_POST['food_price'],2); //type number can't show ',' in text filed
}
if (isset($_POST['type_id'])) {
	$_SESSION['type_id'] = $_POST['type_id'];
}
if (isset($_POST['id'])) {
	if(!isset($_SESSION["intLine"])){
		$_SESSION['new_menu'] = 1;
		$_SESSION["intLine"] = 0;
		$_SESSION['currentSize'] = 1;
		$_SESSION["pro_id"][0] = $_POST['id'];
		exit();
	}else{
		$key = array_search($_POST['id'], $_SESSION["pro_id"]);
		if((string)$key != "")	{
		}else{
			$_SESSION["intLine"]++;
			$_SESSION['currentSize']++;
			$intNewLine = $_SESSION["intLine"];
			$_SESSION["pro_id"][$intNewLine] = $_POST['id'];
		}
		exit();
	}
}



if (isset($_FILES['file']['name'])) {
	$foods = new foodscontr();
	$mf_id = $_SESSION['thismenu']['id'];
	$old_img = $_SESSION['thismenu']['old_img'];
	$default_img = "404-img.png";
	$cus_id = $_SESSION['cus_id'];
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'png');
	
	$fileNameNew = uniqid('', true).".".$fileActualExt;
	$fileDestination = '../dist/img/foods/'.$fileNameNew;

	$uploadOk = 1;
	$imageFileType = pathinfo($fileDestination,PATHINFO_EXTENSION);

	if(!in_array(strtolower($imageFileType),$allowed) ) {
		$uploadOk = 0;
	}
	if($uploadOk == 0){
		echo 0;
	}else{
		if(move_uploaded_file($fileTmpName, $fileDestination)){
			if ($foods->changeImg($fileNameNew, $mf_id)) {
				if ($default_img != $old_img) {
					if (unlink("../dist/img/foods/".$old_img)) {
						echo 'dist/img/foods/'.$fileNameNew;
						unset($_SESSION['thismenu']);
					}
				}else{
					echo 'dist/img/foods/'.$fileNameNew;
					unset($_SESSION['thismenu']);
				}
			}
		}else{
			echo 'error upload files';
		}
	}
}



?>