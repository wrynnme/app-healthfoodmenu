<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_login.inc.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>REGISTER</title>
	<link rel="stylesheet" href="dist/css/login.css">
	<?php require_once 'includes/head.inc.php'; ?>
	<style>
		.card{
			min-width: unset;
			width: 100% !important;
		}
		p {
			color: white;
		}
	</style>
</head>
<body>
	<div class="login-box">
		
		<div class="login-logo">
			<img src="dist/img/HFM/facebook_cover_photo_1.png">
		</div>
		<div class="card">
			<div class="card-body">
				<div class="text-center h4">สมัครสมาชิก</div>
				<form action="" method="post" accept-charset="utf-8" class="needs-validation" id="regis">
					<div class="form-row align-items-center">
						<div class="col">
							<!-- First name -->
							<div class="form-group">
								<label for="fname">ชื่อ</label>
								<input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" autofocus pattern="[a-zA-Z0-9]+" maxlength="100" required autocomplete="off">
							</div>
						</div>
						<div class="col">
							<!-- Last name -->
							<div class="form-group">
								<label for="lname">นามสกุล</label>
								<input type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล" pattern="[a-zA-Z0-9]+" maxlength="100" required autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-row align-items-center">
						<div class="col">
							<div class="form-group">
								<label for="rname">ชื่อร้านอาหาร</label>
								<input type="text" class="form-control" name="rname" id="rname" placeholder="ชื่อร้านอาหาร" maxlength="200" required autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-row align-items-center">
						<div class="col">
							<div class="form-group">
								<label for="email">อีเมล์</label>
								<input type="email" class="form-control" name="email" id="email" placeholder="example@example.com" maxlength="100" required autocomplete="off"><font id="chk_email" size="2px" ></font>
							</div>
						</div>
					</div>
					<div class="form-row align-items-center">
						<div class="col">
							<div class="form-group">
								<label for="pass">รหัสผ่าน</label>
								<input type="password" class="form-control" name="pass" id="pass" placeholder="รหัสผ่าน" minlength="6" maxlength="60" required autocomplete="off">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="con-pass">ยืนยันรหัสผ่าน</label>
								<input type="password" class="form-control" name="con-pass" id="con-pass" placeholder="ยืนยันรหัสผ่าน" minlength="6" maxlength="60" required autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-row align-items-center">
						<div class="col">
							<div class="form-group">
								<label for="tel">เบอร์โทรศัพท์</label>
								<input type="number" class="form-control" name="tel" id="tel" pattern="[0-9]{10}" maxlength="10" id="tel" required autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-row align-items-center">
						<div class="col">
							<!-- <input type="submit" class="btn btn-primary btn-block" name="submit" id="submit" value="ยืนยัน"> -->
							<button type="submit" class="btn btn-primary btn-block btn-regis" name="submit" id="submit">สมัครสมาชิก</button>
							<button class="btn btn-primary btn-block d-none btn-loading" type="button" disabled>
								<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								กรุณารอสักครู่...
							</button>
						</div>
						<div class="col">
							<input type="reset" class="btn btn-outline-danger btn-block" name="reset" id="reset" value="รีเซ็ต">
						</div>
					</div>
					<hr>
					<div class="row text-center">
						<div class="col">
							<a href="login.php" class="small">ฉันมีบัญชีอยู่แล้ว ?</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>

		var forms = $('.needs-validation');
		var validation = Array.prototype.filter.call(forms, function(form) {
			$("#submit").on('click', function(event) {
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);


			$('#fname').on('input', function(){
				var input = $(this);
				var is_name = input.val();
				if (is_name) {
					input.removeClass('is-invalid').addClass('is-valid');
				}else{
					input.removeClass('is-valid').addClass('is-invalid');
				}
			});

			$('#lname').on('input', function(){
				var input = $(this);
				var is_name = input.val();
				if (is_name) {
					input.removeClass('is-invalid').addClass('is-valid');
				}else{
					input.removeClass('is-valid').addClass('is-invalid');
				}
			});

			$('#rname').on('input', function(){
				var input = $(this);
				var is_name = input.val();
				if (is_name) {
					input.removeClass('is-invalid').addClass('is-valid');
				}else{
					input.removeClass('is-valid').addClass('is-invalid');
				}
			});

			$('#email').on('input', function(){
				var input = $(this);
				var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
				var is_email = re.test(input.val());
				if (is_email) {
					var email = input[0].value;
					$.ajax({
						type: 'POST',
						url: 'includes/check.inc.php?m=email',
						data: {email: email},
						cache: false,
						success: function(response){
							if(response == 0){
								input.removeClass('is-invalid').addClass('is-valid');
								return e=1;
							}else {
								input.removeClass('is-valid').addClass('is-invalid');
							}
						}
					});
				}else{
					input.removeClass('is-valid').addClass('is-invalid');
				}
			});

			$('#pass, #con-pass').on('input', function(){
				if ($("#pass").val().length >= 6) {
					$("#pass").removeClass("is-invalid").addClass("is-valid");
				}else{
					$("#pass").removeClass("is-valid").addClass("is-invalid");
				}
				if ($('#pass').val() === $('#con-pass').val()) {
					$("#con-pass").removeClass("is-invalid").addClass("is-valid");
				}else{
					$("#con-pass").removeClass("is-valid").addClass("is-invalid");
				}
			});

			$('#tel').on('keyup keydown blur keypress', function(){
				var input = $(this);
				var is_tel = input.val();
				if (is_tel) {
					if (is_tel.length >= 9) {
						var tel = input[0].value;
						$.ajax({
							type: 'POST',
							url: 'includes/check.inc.php?m=tel',
							data: {tel: tel},
							cache: false,
							success: function(response){
								if(response){
									$('#tel').removeClass('is-invalid').addClass('is-valid');
								}else {
									$('#tel').removeClass('is-valid').addClass('is-invalid');
								}
							}
						});
					}else{
						input.removeClass('is-valid').addClass('is-invalid');
					}
				}else{
					input.removeClass('is-valid').addClass('is-invalid');
				}
			});

			$('#submit').click(function(event) {
				var form_data = $('#regis').serializeArray();
				var error_free = true;
				for (var input in form_data){
					var element = $("#"+form_data[input]['name']);
					var value = element.val();
					var valid = element.hasClass('is-valid');
					if (valid) {
						$.post("includes/register.inc.php", {
							i: input,
							txt: value,
							action: 1
						});
					} else {
						error_free = false;
						Swal.fire({type: 'error', title: 'ไม่สำเร็จ', text: 'กรุณากรอกข้อมูลให้ถูกต้อง หรือ ข้อมูลซ้ำกันอยู่ในระบบ'})
						$(element).removeClass('is-valid').addClass('is-invalid');
					}
				}
				if (!error_free) {
					event.preventDefault();
				} else {
					$.ajax({
						url: 'includes/register.inc.php',
						type: 'POST',
						data: {action: 2},
						beforeSend: function() {
							$('.btn-regis').css("display","none");
							$('.btn-loading').removeClass("d-none");
						},
						success: function(data, textStatus, xhr) {
							if (data == 'success') {
								Swal.fire("สำเร็จ !", "<b>สมัครสมาชิกสำเร็จ !!</b>", "success").then(function(){
									window.location.href='login';
								});
							} else if (data == 'can\'t sent mail') {
								Swal.fire("สำเร็จ !", "<b>สมัครสมาชิกสำเร็จ แต่ไม่สามารถยืนยันอีเมล์ได้ !!</b>", "warning").then(function(){
									window.location.href='login';
								});
							}else{
								Swal.fire("ไม่สำเร็จ !", "<b>กรุณาตรวจสอบข้อมูลที่กรอก !!</b>", "error").then(function(){
									$('.btn-regis').css("display","unset");
									$('.btn-loading').addClass("d-none");
								});
							}
						}
					});
				}
			});
		});
	</script>
	<script src="dist/js/be.js"></script>
</body>
</html>
