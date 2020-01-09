<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php
if (isset($_GET['id'])) {
	$img_default = '404-img.png';
	$id = $_GET['id'];
	$foods = new foodsview();
	$thismenu = $foods->getId($id);
	$mf_id = $thismenu['mf_id'];
	$_SESSION['thismenu']['id'] = $thismenu['mf_id'];
	$_SESSION['thismenu']['old_img'] = $thismenu['mf_img'];
	$ingtDB = array('1' => 'oils', '2' => 'eggs', '3' => 'seas', '4' => 'meats', '5' => 'vegetables', '6' => 'ran', '7' => 'nas', '8' => 'milks', '9' => 'fruits', '10' => 'garnishs');
	$c = 0;
	$intLine = 0;
	for ($l = 0; $l < sizeof($ingtDB); $l++) {
		$c++;
		$tableDB = $ingtDB[$c];
		$thisingre = $foods->getDetail($tableDB, $mf_id);
		for ($i = 0; $i < sizeof($thisingre); $i++) {
			$pro_id[$intLine] = $thisingre[$i][2];
			$gram[$intLine] = $thisingre[$i][3];
			$allcal[$intLine] = $thisingre[$i][4];
			$intLine++;
		}
		
	}
	if ($thismenu['cus_id'] != $_SESSION['cus_id']) {
		header("Location: foods_list.php");
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
		$('#print').on('click', function(){
			$('.divPrint').hide();
			window.print();
			$('.divPrint').show();
		})
		$(function () {
			$.ajax({
				url:'http://<?php echo $_SERVER['HTTP_HOST'];?>/new_hfm/dist/img/foods/<?php echo $thismenu['mf_img'];?>',
				type:'HEAD',
				error: function(){
					$(".img-thumbnail").attr("src",'dist/img/foods/404-img.png'); 
				}
			});
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