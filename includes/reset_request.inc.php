<?php require_once 'class-autoload.inc.php'; ?>
<?php
if (isset($_POST['email'])) {
	$users = new userscontr();
	$url = $users->reset_password($_POST['email']);
	if (!empty($url)) {
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

		$mail->Body = "<body><p>เราได้รับการร้องขอการรีเซ็ตรหัสผ่าน ลิงค์ที่จะรีเซ็ตรหัสผ่านอยู่ด้านล่าง หากคุณไม่ได้ต้องการรีเซ็ตรหัสผ่าน กรุณาปล่อยผ่านอีเมล์นี้ไป</p>";
		$mail->Body .= "<p>ลิงค์รีเซ็ตรหัสผ่าน : ";
		$mail->Body .= "<a href='https://hfm.wrynn.me/".$url."'>คลิ๊กที่นี่</a></p></body>";
		$mail->AddAddress($_POST['email'],'ผู้ร้องขอการรีเซ็ตรหัสผ่าน!');

		if ($mail->Send()){
			echo 'success';
		}else{
			echo "error mail";
		}
	}
}else{
	header('Location: login.php');
}
?>