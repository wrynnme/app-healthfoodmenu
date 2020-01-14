<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php
if ((string)$_SESSION['cus_permission'] != '0') {
	if ($_SESSION['cus_id'] != $_GET['d']) {
		// header('Location: edit_member.php');
		exit();
	}
}
if (empty($_GET['d'])) {
	header("Location: users_list.php");
	exit();
}
$hash = $_GET['h'];
$x = password_verify('edit_password', $_GET['h']);
if (!$x) {
	header("Location: users_list.php");
	exit();
}else{
	$cus_id = $_GET['d'];
	$users = new usersview();
	$user = $users->show($cus_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once 'includes/head.inc.php'; ?>
</head>
<body>
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<div class="container">
		<center>
			<div class="g1">
				<h1 class="h1">แก้ไขรหัสผ่าน</h1>
				<br>
				<form id="edit_password" accept-charset="utf-8">
					<div class="form-group row">
						<label for="email" class="text-right col-md-2 col-form-label">อีเมล์</label>
						<div class="col-md-10">
							<input type="text" readonly class="form-control-plaintext" id="email" value="<?php echo $user['cus_email']?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="oldpass" class="text-right col-md-2 col-form-label">รหัสผ่านเก่า</label>
						<div class="col-md-10">
							<input type="password" class="form-control col-md" name="oldpass" id="oldpass" minlength="6">
						</div>
					</div>
					<div class="form-group row">
						<label for="newpass" class="text-right col-md-2 col-form-label">รหัสผ่านใหม่</label>
						<div class="col-md-10">
							<input type="password" class="form-control col-md" name="newpass" id="newpass" minlength="6">
						</div>
					</div>
					<div class="form-group row">
						<label for="conpass" class="text-right col-md-2 col-form-label">ยืนยัน รหัสผ่านใหม่</label>
						<div class="col-md-10">
							<input type="password" class="form-control col-md" name="conpass" id="conpass" minlength="6">
							<small id="conpass" class="form-text text-muted text-left">
								รหัสผ่านต้องมีอย่างน้อย 6 ตัว ขึ้นไป
							</small>
						</div>
					</div>

					<div class="row">
						<div class="col-md">
							<button type="button" name="submit" id="submit" class="btn btn-primary btn-block"> เปลี่ยนรหัสผ่าน </button>
						</div>
						<div class="col-md">
							<input type="reset" value="รีเซ็ต" class="btn btn-danger btn-block">
						</div>
					</div>
				</form>
			</div>
		</center>
	</div>
	<script src="dist/js/be.js"></script>
	<script>

		$('#submit').click(function() {
			var form_data = $('#edit_password').serializeArray();
			if (form_data[0]['value'].length < 6) {
				$('#oldpass').addClass('is-invalid').removeClass('is-valid');
			}else{
				$('#oldpass').addClass('is-valid').removeClass('is-invalid');
			}
			if (form_data[1]['value'].length < 6) {
				$('#newpass').addClass('is-invalid').removeClass('is-valid');
			}else{
				$('#newpass').addClass('is-valid').removeClass('is-invalid');
			}
			var con = form_data[1]['value'].localeCompare(form_data[2]['value']);
			if (con != 0) {
				$('#conpass').addClass('is-invalid').removeClass('is-valid');
			}else{
				if (form_data[2]['value'].length < 6) {
					$('#conpass').addClass('is-invalid').removeClass('is-valid');
				}else{
					$('#conpass').addClass('is-valid').removeClass('is-invalid');
				}
			}
			// console.log('1: '+form_data[0]['value'].length+' 2 : '+form_data[1]['value'].length+' 3 : '+form_data[2]['value'].length);
			var oldpass_valid = $('#oldpass').hasClass('is-valid');
			var newpass_valid = $('#newpass').hasClass('is-valid');
			var conpass_valid = $('#conpass').hasClass('is-valid');
			var cus_id = <?php echo $cus_id; ?>;
			if (oldpass_valid && newpass_valid && conpass_valid) {
				var valid = 1;
			}
			if (valid == 1) {
				$.post(
					'includes/users_edit_password.inc.php', {
						form_data: form_data,
						cus_id: cus_id
					}, function(result, textStatus, xhr){
						if (result == 'oldpass error') {
							Swal.fire('ไม่สำเร็จ', 'รหัสผ่านเก่าไม่ถูกต้อง !', 'error');
						}else if(result == 'success'){
							Swal.fire('สำเร็จ', 'เปลี่ยนรหัสผ่านเรียบร้อย !', 'succes').then(window.location.href="index.php");
						}else if(result == 'fail'){
							Swal.fire('ไม่สำเร็จ', 'ไม่สามารถเปลี่ยนรหัสผ่านได้ !', 'error');
						}
					}
				);
			}
		});

	</script>
</body>
</html>