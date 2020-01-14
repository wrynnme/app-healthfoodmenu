<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php $uri_name = substr(stristr(strrchr($_SERVER['REQUEST_URI'] ,'/') ,'_', true), 1); ?>
<?php 
$users = new usersview();
if (empty($_GET['id'])) {
	$edit_id = $_SESSION['cus_id'];
}else{
	$edit_id = $_GET['id'];
	$row_user = $users->checkId($edit_id);

	if ($row_user == 1) {
		$edit_id = $_GET['id'];
	}else{
		$edit_id = $_SESSION['cus_id'];
	}
}
if ($edit_id != $_SESSION['cus_id']) {
	if ($_SESSION['cus_permission'] != 0) {
		header('Location:index.php');
	}
}
$pro = $users->show($edit_id);
$hash = password_hash('edit_password', PASSWORD_DEFAULT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php require_once 'includes/head.inc.php'; ?>
</head>
<body>
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<div class="container">
		<div class="g1 h2 text-center">แก้ไขข้อมูลส่วนตัว</div>
		<form class="needs-validation" novalidate method="post" id="myForm">
			<div class="form-row">
				<div class="col-md-4 mb-3">
					<label for="fname">ชื่อ</label>
					<input type="text" class="form-control" id="fname" name="fname" value="<?php echo $pro['cus_fname']; ?>" required>
					<div class="invalid-feedback">
						กรุณากรอกชื่อ
					</div>
				</div>
				<div class="col-md-4 mb-3">
					<label for="lname">นามสกุล</label>
					<input type="text" class="form-control" id="lname" name="lname" value="<?php echo $pro['cus_lname']; ?>" required>
					<div class="invalid-feedback">
						กรุณากรอกนามสกุล
					</div>
				</div>
				<div class="col-md-4 mb-3">
					<label for="rname">ชื่อร้านอาหาร</label>
					<input type="text" class="form-control" id="rname" name="rname" value="<?php echo $pro['cus_res_name']; ?>" required>
					<div class="invalid-feedback">
						กรุณากรอกนามสกุล
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md mb-3">
					<label for="email">อีเมล์</label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo $pro['cus_email']; ?>" required disabled>
					<div class="invalid-feedback">
						กรุณากรอกอีเมล์
					</div>
				</div>
				<div class="col-md mb-3">
					<label for="tel">เบอร์โทร</label>
					<input type="number" class="form-control" id="tel" name="tel" value="<?php echo $pro['cus_tel']; ?>" minlength="4" maxlength="10" required>
					<div class="invalid-feedback">
						กรุณากรอกเบอร์โทร หรือ เบอร์โทรนี้ถูกใช้ไปแล้ว
					</div>
				</div>
				<div class="col-md mb-3">
					<label for="rtable">จำนวนโต๊ะ ของร้าน</label>
					<input type="number" class="form-control" id="rtable" name="rtable" value="<?php echo $pro['cus_rtable']; ?>" min="1" max="99" maxlength="2" required>
					<div class="invalid-feedback">
						กรุณากรอกจำนวนโต๊ะของร้าน
					</div>
				</div>
				<?php if((string)$_SESSION['cus_permission'] == '0'){ ?>
					<?php $per = array('ผู้ดูแลระบบ', 'ผู้ใช้งาน'); ?>
					<div class="col-md mb-3">
						<label for="permission">สิทธิ์การใช้งาน</label>
						<select class="custom-select" id="permission" name="permission" required>
							<option selected value="<?php echo $pro['cus_permission']; ?>"><?php echo $per[$pro['cus_permission']]; ?></option>
							<option disabled >เลือก...</option>
							<option value="0"><?php echo $per[0]; ?></option>
							<option value="1"><?php echo $per[1]; ?></option>
						</select>
						<div class="invalid-feedback">
							กรุณาเลือกสิทธิ์การใช้งาน
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col">
					<button class="btn btn-block btn-success" type="submit">แก้ไขข้อมูล</button>
				</div>
				<div class="col">
					<button class="btn btn-block btn-outline-danger" type="reset">ตั้งค่าใหม่</button>
				</div>
			</div>
		</form>
		<hr>
		<div class="h6 text-center">
			<?php
			if ((string)$_SESSION['cus_id'] == (string)$edit_id) { ?>
				<a class="text-dark" href="users_edit_password.php?d=<?php echo $edit_id;?>&h=<?php echo $hash;?>">เปลี่ยนรหัส</a>
			<?php }else{ ?>
				<a class="text-dark" href="#" id="resetpwd">รีเซ็ตรหัสผ่าน</a>
			<?php } ?>
		</div>
	</div>
	<script src="dist/js/be.js"></script>
	<script>
		$('#resetpwd').click(function() {
			var email = $('#email').val();
			$.ajax({
				url: 'includes/reset_request.inc.php',
				type: 'POST',
				data: {email: email},
				success: function(data, response) {
					console.log(data);
				}
			});
			
		});
		'use strict';
		window.addEventListener('load', function() {
			var forms = document.getElementsByClassName('needs-validation');
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					}else{
						event.preventDefault();
						var myForm = document.getElementById('myForm');
						var data = new FormData(myForm);
						var id = <?php echo $edit_id; ?>;
						data.append('id', id);
						/*for(var pair of data.entries()) {
							console.log(pair[0]+ ', '+ pair[1]); 
						}*/
						$.ajax({
							url: 'includes/users_edit.inc.php',
							type: 'POST',
							data: data,
							processData: false,
							contentType: false,
							success: function(data, response) {
								if (data == '') {
									Swal.fire("สำเร็จ !", "<b>แก้ไขข้อมูลสำเร็จ !!</b>", "success").then(function(){
										window.location.reload();
									})
								}else if (data == 'error tel') {
									event.stopPropagation();
									$('#tel').removeClass('is-valid');
									$('#tel').addClass('is-invalid');
									form.classList.remove('was-validated');
									Swal.fire("ไม่สำเร็จ !", "<b>ข้อมูล <u>เบอร์โทร</u> ที่กรอกซ้ำกัน !!</b>", "error");
								}else{
									Swal.fire("ไม่สำเร็จ !", "<b>กรุณาตรวจสอบข้อมูลที่กรอก !!</b>", "error")
								}
							}

						});
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	</script>
</body>
</html>