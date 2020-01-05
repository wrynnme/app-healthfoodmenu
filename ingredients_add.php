<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php
$ings = new ingredientsview();

$type = $ings->type();


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
		<div class="text-center">
			<div class="h1">เพิ่มวัตถุดิบ</div>
			<div class="h2 mb-5">Add ingredients</div>
		</div>
		<form class="needs-validation" novalidate method="post" enctype="multipart/form-data" id="myForm">
			<div class="form-row">
				<div class="col-md mb-3">
					<label for="ing_name">ชื่อวัตถุดิบ</label>
					<input type="text" class="form-control" id="ing_name" name="ing_name" placeholder="น้ำมัน" required>
					<div class="invalid-feedback">
						กรุณากรอก ชื่อวัตถุดิบ
					</div>
				</div>
				<div class="col-md mb-3">
					<label for="ing_kcal">แคลอรี่ : 100 กรัม</label>
					<input type="number" class="form-control" id="ing_kcal" name="ing_kcal" placeholder="884" required>
					<div class="invalid-feedback">
						กรุณากรอก แคลอรี่ ต่อ 100 กรัม
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md mb-3">
					<label for="ing_img">รูปของวัตถุดิบ</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="ing_img" name="ing_img" accept="image/*">
						<label class="custom-file-label" for="ing_img">เลือกรูป... </label>
						<div class="invalid-feedback">กรุณา ใส่รูปวัตถุดิบ</div>
					</div>
				</div>
				<div class="col-md-4 mb-3">
					<label for="ing_type">ประเภทของวัตถุดิบ</label>
					<select class="custom-select" id="ing_type" name="ing_type" required>
						<option selected disabled value="">เลือก...</option>
						<?php for ($i = 0; $i < sizeof($type); $i++) { ?>
							<option value="<?php echo $type[$i]['ingt_id'];?>"><?php echo $type[$i]['ingt_name'];?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						กรุณาเลือก ประเภทของวัตถุดิบ
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md">
					<button class="btn btn-success btn-block" type="submit" name="submit">เพิ่มวัตถุดิบ</button>
				</div>
				<div class="col-md">
					<button class="btn btn-outline-danger btn-block" type="reset">ยกเลิก</button>
				</div>
			</div>
		</form>
	</div>
	
	<script>
		$(document).ready(function() {
			$('.custom-file-input').change(function(event) {
				$('.custom-file-label').text($(this).val().split("\\").pop());
			});
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
							var myForm = document.getElementById('myForm');
							var data = new FormData(myForm);
							for(var pair of data.entries()) {
								console.log(pair[0]+ ', '+ pair[1]); 
							}
							$.ajax({
								url: 'includes/ingredients_add.inc.php',
								type: 'POST',
								data: data,
								processData: false,
								contentType: false,
								success: function(response) {
									if (response == '1') {
										Swal.fire("สำเร็จ !", "<b>รอการตรวจสอบจากผู้ดูแล !!</b>", "success").then(function(){
											window.location.href='index.php';
										})
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
		});
	</script>
</body>
</html>