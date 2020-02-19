<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php
if (isset($_GET['id'])) {
	$img_default = '404-img.png';
	$id = $_GET['id'];
	$foods = new foodsview();
	$special = $foods->getSpecial($_SESSION['cus_id']);
	$thismenu = $foods->getId($id);
	$mf_id = $thismenu['mf_id'];
	$_SESSION['thismenu']['id'] = $thismenu['mf_id'];
	$_SESSION['thismenu']['old_img'] = $thismenu['mf_img'];
	$c = 0;
	$intLine = 0;
	$thisingre = $foods->getDetail($mf_id);
	// echo '<pre>' , var_dump($thisingre) , '</pre>';
	for ($i = 0; $i < sizeof($thisingre); $i++) {
		$pro_id[$intLine] = $thisingre[$i]['ing_id'];
		$gram[$intLine] = $thisingre[$i]['gram'];
		$allcal[$intLine] = $thisingre[$i]['kcal'];
		$intLine++;
	}
	if ($thismenu['cus_id'] != $_SESSION['cus_id']) {
		header("Location: foods_list.php");
	}
	echo $foods->special_count;
	if ($foods->special_count < 3) {
		$sp = 0;
		for ($i = 0; $i < sizeof($special);$i++) {
			// echo $special[$i]['mf_id'].'=='.$id.'<br/>';
			if ($special[$i]['mf_id'] == $id) {
				$chk = 0;
				// echo $chk.'<br/>';
			}
		}
	} else {
		$sp = 1;
		$chk = 1;
	}
}else{
	header("Location: foods_list.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php require_once 'includes/head.inc.php'; ?>
	<style>
		.changeImg{
			height: auto;
		}
		img{
			width: 600px;
			object-fit:cover;
		}
	</style>
</head>
<body>
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<div class="container">
		<div class="text-center mb-3">
			<div class="h1"><?php echo $thismenu['mf_name']; ?></div>
			<div id="special_food">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="special" <?php if (@$chk == '0'){ echo 'checked'; }?>>
					<label class="custom-control-label" for="special">เลือกเป็นเมนูแนะนำ</label>
				</div>
			</div>
		</div>
		<div class="mx-auto text-center mb-3">
			<label for="picfood" class="figure">
				<img src="dist/img/foods/<?php echo $thismenu['mf_img'];?>" class="rounded img-thumbnail img-fluid" data-toggle="tooltip" data-placement="bottom" data-original-title="คลิกเพื่อเปลี่ยนรูป">
				<figcaption class="figure-caption text-right divPrint">ขนาดรูปต้องไม่เกิน 2048 x 2048</figcaption>
			</label>
			<form method="post" action="" enctype="multipart/form-data" id="myform">
				<input type="file" name="picfood" id="picfood" style="display: none;" accept="image/*">
			</form>
		</div>
		<div class="row">
			<div class="col text-center">
				<h2>ราคา : <?php echo $thismenu['mf_price']; ?></h2>
			</div>
			<div class="col text-center">
				<h2>แคลอรี่ : <?php echo $thismenu['mf_kcal']; ?></h2>
			</div>
		</div>
		<table class="table table-striped" border="0" style="margin: 0 auto;">
			<thead>
				<tr class="text-center">
					<td><b>ชื่อวัตถุดิบ</b></td>
					<td><b>กรัม</b></td>
					<td><b>แคลอรี่</b></td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $i < (int)$intLine; $i++) { ?>
					<?php
					$ings = new ingredientsview();
					$ing = $ings->id($pro_id[$i]);
					?>
					<tr class="text-center">
						<td><?php echo $ing['ing_name']; ?></td>
						<td><?php echo $gram[$i]; ?></td>
						<td><?php echo $allcal[$i]; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="text-center divPrint">
			<br>
			<button class="btn btn-warning btn-block" id="print"><i class="fal fa-print"></i> พิมพ์</button>
		</div>
	</div>
	<script>
		$('#print').on('click', function() {
			$('.divPrint').hide();
			$('#special_food').hide();
			window.print();
			$('.divPrint').show();
			$('#special_food').show();
		})
		$('#special').on('click', function() {
			// console.log($('#special').prop('checked'));
			var mf_id = <?php echo $mf_id; ?>;
			
			if ($('#special').prop('checked')) {
				// console.log('checked');
				$.ajax({
					url: 'includes/special_foods_contr.inc.php?add',
					type: "POST",
					data: {data:mf_id},
					success: function (response) {
						if (response == 'true') {
							Swal.fire("เมนูแนะนำ !", "<b>เพิ่มเมนูแนะนำสำเร็จ", "success");
						} else {
							Swal.fire("เมนูแนะนำ !", "<b>ไม่สามารถทำรายการได้เนื่องจากมากเกินกว่า 3 รายการ</b>", "error");
						}
					}
				});
			} else {
				// console.log('uncheck');
				$.ajax({
					url: 'includes/special_foods_contr.inc.php?del',
					type: "POST",
					data: {data:mf_id},
					success: function (response) {
						if (response == 'true') {
							Swal.fire("เมนูแนะนำ !", "<b>นำออกจากเมนูแนะนำสำเร็จ", "success");
						} else {
							Swal.fire("เมนูแนะนำ !", "<b>ไม่สามารถลบได้เนื่องจากเกิดปัญหากรุณาติดต่อผู้ดูแลระบบ</b>", "error");
						}
					}
				});
			}
		});
		$(function () {
			/*$.ajax({
				url:'http://<?php echo $_SERVER['HTTP_HOST'];?>/new_hfm/dist/img/foods/<?php echo $thismenu['mf_img'];?>',
				type:'HEAD',
				error: function(){
					$(".img-thumbnail").attr("src",'dist/img/foods/404-img.png'); 
				}
			});*/
			var _URL = window.URL || window.webkitURL;
			$('[data-toggle="tooltip"]').tooltip();
			$('#picfood').change(function(event) {
				var file, img;

				if ((file = this.files[0])) {
					var fd = new FormData();
					var files = $('#picfood')[0].files[0];
					fd.append('file', files);
					img = new Image();
					img.onload = function(e) {
						if (this.width > 2048 || this.height > 2048) {
							Swal.fire("ขัดข้อง !", "<b>ความกว้าง : " + this.width + " </b>หรือ <b>ความยาว : " + this.height + " <i><u>เกิน 2048 pixels</u></i></b>", "error").then(function(){
								$('#picfood').val('');
							});
						}else{
							
							$.ajax({
								url: 'includes/foods_ingre.inc.php',
								type: 'post',
								data: fd,
								contentType: false,
								processData: false,
								success: function(response){
									if(response != 0){
										$(".img-thumbnail").attr("src",response);
										$("img").show();
										Swal.fire("สำเร็จ !", "<b>อัพโหลดเสร็จสิ้น !!</b>", "success").then(function(){
											setTimeout(window.location.reload(), 60000 * 3);
										});
									}else{
										Swal.fire("ขัดข้อง !", "<b>อัพโหลดไม่เสร็จสิ้น</b>", "error").then(function(){
											$('#picfood').val('');
										});
									}
								},
							});
						}
					};
					img.onerror = function() {
						Swal.fire("ขัดข้อง !", "<b>ประเภทของไฟล์ไม่ถูกต้อง : " + file.type + "</b>", "error").then(function(){
							$('#picfood').val('');
						});
					};
					img.src = _URL.createObjectURL(file);
				}
			});
		});
	</script>
</body>
</html>