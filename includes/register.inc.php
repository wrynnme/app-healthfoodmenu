<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_POST['action']) && ($_POST['action']) == 1) {
	$i = $_POST['i'];
	$_SESSION['new_user'][$i] = $_POST['txt'];
	// print_r($_SESSION['new_user']);
}
if (isset($_POST['action']) && ($_POST['action']) == 2) {
	$users = new userscontr();
	/*print_r($_SESSION['new_user']);
	echo $_POST['action'];*/
	$length = 5;
	$n  = '1234567890';
	$sn = substr(str_shuffle($n),0,$length);
	$cid = date("Ymd").$sn; #Customer ID Date with function gnum -> 5 number
	$fn = $_SESSION['new_user']['0'];
	$ln = $_SESSION['new_user']['1'];
	$rn = $_SESSION['new_user']['2'];
	$em = $_SESSION['new_user']['3'];
	$ps = $_SESSION['new_user']['4'];
	$tl = $_SESSION['new_user']['6'];

	$query = $users->create($fn, $ln, $rn, $em, $ps, $tl);
	if ($query) {
		unset($_SESSION['new_user']);
		echo "successful";
		require_once 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";

		$mail->Host = "mail.wrynn.me";
		$mail->Port = 587;
		$mail->isHTML();
		$mail->CharSet = "utf-8";
		$mail->Username = "no-reply@wrynn.me";
		$mail->Password = "8kfgfkpkd";
		$mail->From = 'no-reply@wrynn.me';

		$mail->FromName = "WRYNNME DEVELOPMENT ";
		$mail->Subject = "รีเซ็ตรหัสผ่านสำหรับ https://hfm.wrynn.me";

		$mail->Body = "<body><p>เราได้อนุมัติการสมัครสมาชิกของคุณ ".$fn." ".$ln." ร้าน : ".$rn."</p></body>";
		$mail->AddAddress($em,'สมัครสมาชิกสำเร็จ!');

		if ($mail->Send()){
			echo 'success';
		}else{
			echo "error mail";
		}
	}else{
		echo "unsuccessful";
	}
}
?>