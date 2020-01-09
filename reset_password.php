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
				<div class="text-center h4">รีเซ็ตรหัสผ่าน</div>
				<form class="needs-validation" novalidate method="post" id="pwdReset">
					<div class="form-row">
						<div class="col-md mb-3">
							<label for="email">อีเมล์ของผู้ใช้</label>
							<input type="email" class="form-control" name="email" id="email" required>
							<div class="invalid-feedback">
								กรุณากรอกอีเมล์
							</div>
							<div class="valid-feedback">
								ระบบจะส่งลิงค์รีเซ็ตรหัสผ่านไปที่อีเมล์
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
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
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
							/*for(var pair of data.entries()) {
								console.log(pair[0]+ ', '+ pair[1]); 
							}*/
							$('#submit').attr('disabled', 'on');
							$('.load').removeClass('sr-only');
							$('#text-con').addClass('sr-only');

							$.ajax({
								url: 'includes/reset_request.inc.php',
								type: 'POST',
								data: data,
								processData: false,
								contentType: false,
								success: function(response) {
									if (response == 'success') {
										Swal.fire("สำเร็จ !", "<b>กรุณาเช็คที่อีเมล์ หากไม่พบกรุณาดูที่อีเมล์ขยะ หรือ Junk !!</b>", "success").then(function(){
											window.location.href="login.php";
										})
									}else if (response == 'error mail not match') {
										Swal.fire("ไม่สำเร็จ !", "<b>อีเมล์ที่กรอกไม่พบอยู่ในระบบ !!</b>", "error");
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
		});
	</script>
</body>
</html>