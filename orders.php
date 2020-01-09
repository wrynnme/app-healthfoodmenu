<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php
@SESSION_START();
if (isset($_GET['s'])) {
	$_SESSION['order_encode'] = $_GET['s'];
	$decode = base64_decode(base64_decode($_GET['s']));
	$split = '&';
	$_SESSION['order_res_id'] = substr($decode, 0 ,strpos($decode, $split));
	$_SESSION['order_table'] = substr($decode,strpos($decode, $split)+1);
	$res_id = $_SESSION['order_res_id'];
	$users = new usersview();
	$user = $users->show($res_id);
	$_SESSION['res_name'] = $user['cus_res_name']; 
} else {
	if (isset($_SESSION['order_encode'])) {
		$decode = base64_decode(base64_decode($_SESSION['order_encode']));
		$split = '&';
		$_SESSION['order_res_id'] = substr($decode, 0 ,strpos($decode, $split));
		$_SESSION['order_table'] = substr($decode,strpos($decode, $split)+1);
		$res_id = $_SESSION['order_res_id'];
	} else {
		exit();
	}
}
if (isset($_SESSION['order_res_id']) || isset($_SESSION['order_table'])) {
	if (($_SESSION['order_res_id'] == '') || ($_SESSION['order_table'] == '')) {
		echo 'error qrcode';
		exit();
	}
} else {
	exit();
}

$foods = new foodsview();
$types = new typeview();

$food = $foods->getOrder($res_id);
$type = $types->getOrder($res_id, NULL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php require_once 'includes/head.inc.php'; ?>
	<style>
		.col{
			padding: 0px;
			margin: 0px 10px;
		}
		hr{
			margin-top: unset;
		}
	</style>
</head>
<body>
	<?php require_once 'includes/nav_clients.php'; ?>
	<div class="container">
		<div class="g1">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active text-dark" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">ทั้งหมด</a>
				</li>
				<?php for ($i = 0; $i < sizeof($type); $i++) { ?>
					<li class="nav-item">
						<a class="nav-link text-dark" id="type-<?php echo $type[$i]['type_id']?>-tab" data-toggle="tab" href="#type-<?php echo $type[$i]['type_id']?>" role="tab" aria-controls="type-<?php echo $type[$i]['type_id']?>" aria-selected="false"><?php echo $type[$i]['type_name']?></a>
					</li>
				<?php } ?>
				<li class="nav-item">
					<a class="nav-link bg-info text-light" id="order-tab" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false" onclick="mymenu();">รายการสั่งอาหาร</a>
				</li>
			</ul>

			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
					<div class="text-center">
						<?php for ($i = 0; $i < sizeof($food); $i++) { ?>
							<div class="card my-2 h-100">
								<img src="dist/img/foods/<?php echo $food[$i]['mf_img'];?>" class="card-img-top mx-auto" alt="...">
								<div class="card-body text-center ">
									<h5 class="card-title"><?php echo $food[$i]['mf_name'];?></h5>
									<p class="card-text"><?php echo $food[$i]['mf_kcal']." แคลอรี่ ";?> : <?php echo $food[$i]['mf_price']." บาท ";?></p>
									<button type="button" name="<?php echo $food[$i]['mf_id']?>" id="add" class="btn btn-outline-success" onclick="return order_this(this.name);"><i class="fa fa-cart-plus"></i></button>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php for ($i = 0; $i < sizeof($type); $i++) { ?>
					<?php $food_type = $foods->getOrder_Type($res_id, $type[$i]['type_id']); ?>
					<div class="tab-pane fade" id="type-<?php echo $type[$i]['type_id']?>" role="tabpanel" aria-labelledby="type-<?php echo $type[$i]['type_id']?>-tab">
						<?php for ($l = 0; $l < sizeof($food_type); $l++) { ?>
							<div class="card my-2 h-100">
								<img src="dist/img/foods/<?php echo $food_type[$l]['mf_img'];?>" class="card-img-top" alt="...">
								<hr>
								<div class="card-body text-center ">
									<h5 class="card-title"><?php echo $food_type[$l]['mf_name'];?></h5>
									<p class="card-text"><?php echo $food_type[$l]['mf_kcal']." แคลอรี่ ";?> : <?php echo $food_type[$l]['mf_price']." บาท ";?></p>
									<button type="button" name="<?php echo $food_type[$l]['mf_id']?>" class="btn btn-outline-success" onclick="return order_this(this.name);"><i class="fa fa-cart-plus"></i></button>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
					<div id="my-menu"></div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function order_this(value){
			var res_id = <?php echo $res_id; ?>;
			$.ajax({
				type:"POST",
				url:"includes/orders.inc.php",
				data:{order: value, res_id: res_id}
			});
			Swal.fire({
				position: 'top-end',
				type: 'success',
				title: 'เพื่มรายการอาหาร',
				showConfirmButton: false,
				timer: 1500
			})
		}
		function mymenu(){
			var res_id = <?php echo $res_id; ?>;
			$.ajax({
				type:"POST",
				url:"includes/orders_mymenu.inc.php",
				data:{res_id : res_id},
				success:function(data){
					$("#my-menu").html(data);
				}
			});
		}
		function del(Id){
			var res_id = <?php echo $res_id; ?>;
			Swal.fire({
				title: 'คุณต้องการที่จะลบ?',
				text: "คุณต้องการลบวัตถุดิบชิ้นนี้ ออกจากเมนูนีั!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ใช่, ฉันต้องการลบ!',
				cancelButtonText: 'ยกเลิก',
				reverseButtons: true
			}).then((result) => {
				if (result.value) {
					Swal.fire('ลบเรียบร้อย !', 'วัตถุดิบถูกลบเรียบร้อย.', 'success').then(function(){
						window.location = 'includes/orders.inc.php?del='+Id+'&r='+res_id;
					})
				}
			})
		}
	</script>
</body>
</html>