<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php
$or_id = $_GET['id'];
// $or_id = 162;
if ($or_id == '') {
	header('Location : orders_list.php');
}else{
	$orders = new ordersview();
	$foods = new foodsview();
	$order = $orders->getId($or_id, $_SESSION['cus_id']);
	$detail = $orders->getId_detail($or_id);
	$all_kcal = 0;
	$all_price = 0;
}
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
		<?php if ($order['or_status'] == '0') { ?>
			<div class="alert alert-warning" role="alert">
				<h4 class="alert-heading">ยกเลิก</h4>
				<p>การสั่งอาหารนี้ได้ถูกยกเลิกจากทางร้านค้าแล้ว</p>
			</div>
		<?php }elseif ($order['or_pay_status'] == '0') { ?>
			<div class="alert alert-danger" role="alert">
				<h4 class="alert-heading">ยังไม่ได้ทำการคิดเงิน</h4>
				<p>รอลูกค้า ต้องคิดเงิน</p>
			</div>
		<?php }elseif ($order['or_pay_status'] == '1'){	?>
			<div class="alert alert-info" role="alert">
				<h4 class="alert-heading">รอการคิดเงิน</h4>
				<p>ลูกค้ากำลังรอการคิดเงินจาก พนักงานของทางร้าน</p>
			</div>
		<?php }elseif ($order['or_pay_status'] == '2'){	?>
			<div class="alert alert-success" role="alert">
				<h4 class="alert-heading">ชำระเงินแล้ว</h4>
				<p>ลูกค้าจากรหัสการสั่งนี้ได้ทำการชำระเงินแล้ว</p>
			</div>
		<?php } ?>

		<div class="g1">
			<div class="row h4 text-center">
				<div class="col-md">รหัสการสั่งที่ : </div>
				<div class="col-md"><?php echo $order['or_id'] ?></div>
				<div class="col-md">โต๊ะที่ : </div>
				<div class="col-md"><?php echo $order['or_table']; ?></div>
				<div class="col-md">วัน เวลาที่สั่ง : </div>
				<div class="col-md"><?php echo $order['or_time']; ?></div>
			</div>
			<div class="table-responsive-xl">
				<table class="table table-borderless table-striped table-hover" border="1">
					<thead class="thead-dark">
						<tr class="text-center">
							<th>ชื่อ</th>
							<th>จำนวน</th>
							<th>แคลอรี่</th>
							<th>ราคา</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 0; $i < sizeof($detail); $i++) { ?>
							<?php
							$mf_id = $detail[$i]['mf_id'];
							$all_kcal += $detail[$i]['kcal'];
							$all_price += $detail[$i]['price'];
							$food = $foods->getId($mf_id);
							?>
							<tr class="text-center">
								<td><?php echo $food['mf_name']; ?></td>
								<td><?php echo $detail[$i]['quantity']; ?></td>
								<td><?php echo $detail[$i]['price']; ?></td>
								<td><?php echo $detail[$i]['kcal']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="row h4 text-center">
				<div class="col-md-3">แคลอรี่ทั้งหมด : </div>
				<div class="col-md-3"><?php echo number_format($all_kcal, 2); ?></div>
				<div class="col-md-3">ราคาทั้งหมด : </div>
				<div class="col-md-3"><?php echo number_format($all_price, 2); ?></div>
			</div>
			<br>
			
			<div class="row">
				<?php if ($order['or_pay_status'] == '1') { ?>
					<div class="col-md-8">
						<button class="btn btn-success btn-block" id="checkbill">คิดเงิน</button>
					</div>
					<div class="col-md">
						<button class="btn btn-outline-danger btn-block" id="cancelbill">ยกเลิกการคิดเงิน</button>
					</div>
				<?php } ?>
				<?php if ($order['or_pay_status'] == '0' && $order['or_status'] == '1'){ ?>
					<div class="col-md">
						<button class="btn btn-outline-danger btn-block" id="cancelorder">ยกเลิกการสั่งอาหารนี้</button>
					</div>
				<?php } ?>
				<?php if ($order['or_status'] == '0') { ?>
					<div class="col-md">
						<button class="btn btn-outline-danger btn-block" id="getorder">ยกเลิก การยกเลิกเมนูนี้</button>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<script>
		$('#cancelorder').click(function() {
			Swal.fire({title : 'ยืนยัน', text : 'ยืนยันการยกเลิกเมนูนี้จากลูกค้า !', icon : 'error', showCancelButton: true, confirmButtonColor: '#DC3545', confirmButtonText: 'ยกเลิกตอนนี้ !', cancelButtonText: "ยัง, ไม่ต้องการยกเลิก",}).then((result) => {
				if (result.value) {
					var id = <?php echo $or_id; ?>;
					$.post('includes/orders.inc.php', {id: id, status: '0'}, function(data, textStatus, xhr) {
						if (data == 'success') {
							Swal.fire('เรียบร้อย!', 'เมนูนี้ได้ถูกยกเลิกเรียบร้อยแล้ว', 'success').then(function(){
								window.location.reload();
							});
						}
					});
				}
			});
		});
		$('#cancelbill').click(function() {
			Swal.fire({title : 'ยืนยัน', text : 'ยืนยันการยกเลิกการคิดเงินนี้จากลูกค้า !', icon : 'error', showCancelButton: true, confirmButtonColor: '#DC3545', confirmButtonText: 'ยกเลิกตอนนี้ !', cancelButtonText: "ยัง, ไม่ต้องการยกเลิก",}).then((result) => {
				if (result.value) {
					var id = <?php echo $or_id; ?>;
					$.post('includes/orders.inc.php', {id: id, pay_status: '0'}, function(data, textStatus, xhr) {
						if (data == 'success') {
							Swal.fire('เรียบร้อย!', 'เมนูนี้ได้ถูกยกเลิกการคิดเงินเรียบร้อยแล้ว', 'success').then(function(){
								window.location.reload();
							});
						}
					});
				}
			});
		});
		$('#checkbill').click(function() {
			Swal.fire({title : 'ยืนยัน', text : 'ยืนยันการเก็บเงินจากลูกค้า !', icon : 'warning', showCancelButton: true, confirmButtonColor: '#28A745', confirmButtonText: 'เรียบร้อย !', cancelButtonText: "ยัง, ยกเลิก",}).then((result) => {
				if (result.value) {
					var id = <?php echo $or_id; ?>;
					var kcal = <?php echo $all_kcal; ?>;
					var price = <?php echo $all_price; ?>;
					$.post('includes/orders.inc.php', {id: id, kcal: kcal, price: price, pay_status: '2'}, function(data, textStatus, xhr) {
						if (data == 'success') {
							Swal.fire('ยืนยัน!', 'คิดเงินเรียบร้อย', 'success').then(function(){
								window.location.reload();
							});
						}
					});
				}
			})
		});
		$('#getorder').click(function() {
			Swal.fire({title : 'ยืนยัน', text : 'ยืนยันการยกเลิก การยกเลิกเมนูนี้ !', icon : 'warning', showCancelButton: true, confirmButtonColor: '#28A745', confirmButtonText: 'เรียบร้อย !', cancelButtonText: "ยัง, ยกเลิก",}).then((result) => {
				if (result.value) {
					var id = <?php echo $or_id; ?>;
					$.post('includes/orders.inc.php', {id: id, status: '1'}, function(data, textStatus, xhr) {
						if (data == 'success') {
							Swal.fire('ยืนยัน!', 'ยกเลิกการ ยกเลิกเมนูนี้ เรียบร้อย', 'success').then(function(){
								window.location.reload();
							});
						}
					});
				}
			})
		});
	</script>
</body>
</html>