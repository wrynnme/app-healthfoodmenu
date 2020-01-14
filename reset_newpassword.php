<?php require_once 'includes/check_login.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="dist/css/login.css">
	<?php require_once 'includes/head.inc.php'; ?>
	<style>
		.card{
			display: flex !important;
		}
		.card img {
			width: unset;
			height: unset;
		}
		img {
			width: 100%;
		}
	</style>
</head>
<body>
	<div class="login-box">
		<div class="login-logo">
			<img src="dist/img/HFM/facebook_cover_photo_1.png" alt="">
		</div>
		<div class="card" style="width: unset;">
			<div class="card-body">
				<div class="text-center h4">เปลี่ยนรหัสผ่าน</div>
				<?php
				$selector = $_GET['s'];
				$validator = $_GET['t'];
				if (empty($selector) || empty($validator)) {
					echo 'Could not validate your request!';
				}else{
					if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) { ?>
						<form class="needs-validation" novalidate method="post" id="pwdReset">
							<input type="hidden" name="selector" value="<?php echo $selector; ?>">
							<input type="hidden" name="validator" value="<?php echo $validator; ?>">
							<div class="form-row">
								<div class="col-md mb-3">
									<label for="pwd">รหัสผ่านใหม่</label>
									<input type="password" class="form-control" name="pwd" id="pwd" placeholder="อย่างน้อย 6 ตัว" minlength="6" required>
									<div class="invalid-feedback">
										กรุณากรอกรหัสผ่านใหม่
									</div>
								</div>
								<div class="col-md mb-3">
									<label for="pwd-repeat">ยืนยัน รหัสผ่านใหม่</label>
									<input type="password" class="form-control" name="pwd-repeat" id="pwd-repeat" placeholder="ใส่รหัสผ่านใหม่อีกครั้ง" minlength="6" required>
									<div class="invalid-feedback">
										กรุณากรอกยืนยันรหัสผ่านใหม่
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md mb-3">
									<button class="btn btn-block btn-primary" type="submit" id="submit">
										<span id="text-con">ยืนยันการรีเซ็ต</span>
										<span class="load spinner-border spinner-border-sm sr-only" role="status" aria-hidden="true"></span>
										<span class="load sr-only">Loading...</span>
									</button>
								</div>
							</div>
						</form>
						<?php	
					}
				}
				?>
			</div>
		</div>
	</div>
	<script>

		'use strict';

		window.addEventListener('load', function() {
			var forms = $('.needs-validation');
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					}else{
						event.preventDefault();
						var myForm = document.getElementById('pwdReset');
						var data = new FormData(myForm);
						for(var pair of data.entries()) {
							console.log(pair[0]+ ', '+ pair[1]); 
						}
						$('#submit').attr('disabled', 'on');
						$('.load').removeClass('sr-only');
						$('#text-con').addClass('sr-only');

						$.ajax({
							url: 'includes/reset_newpassword.inc.php',
							type: 'POST',
							data: data,
							processData: false,
							contentType: false,
							success: function(response) {
								if (response == 'password has change') {
									Swal.fire("สำเร็จ !", "<b>เปลี่ยนรหัสผ่านสำเร็จ !!</b>", "success").then(function(){
										window.location.href="login.php";
									})
								}else if (response == 'password not match') {
									Swal.fire("ไม่สำเร็จ !", "<b>รหัสผ่านที่กรอกไม่ตรงกัน !!</b>", "error");
								}else if (response == 'You need to re-submit your reset request.') {
									Swal.fire("ไม่สำเร็จ !", "<b>ระยะเวลาในการเปลี่ยนรหัสผ่านใหม่หมดเวลา กรุณากรอกข้อมูลการรีเซ็ตรหัสผ่านใหม่ !!</b>", "error").then(function(){
										window.location.href="reset_password.php";
									});
								}else{
									Swal.fire("ไม่สำเร็จ !", "<b>กรุณาตรวจสอบข้อมูลที่กรอก !!</b>", "error");
								}
							}
						}).always(function() {
							$('#pwdReset').trigger("reset");
							$('#submit').removeAttr("disabled");
							$('.load').addClass('sr-only');
							$('#text-con').removeClass('sr-only');
						});
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);

	</script>
</body>
</html>