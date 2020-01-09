<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php $uri_name = substr(stristr(strrchr($_SERVER['REQUEST_URI'] ,'/') ,'_', true), 1); ?>
<?php
$row = 10;
if (empty($_GET['page'])) {
	$currentPage = 1;
} else {
	$currentPage = $_GET['page'];
}
if ($currentPage < 1) {
	$currentPage = 1;
}


$orders = new ordersview();

if (isset($_GET['m'])) {
	$mode = $_GET['m'];
} else {
	$mode = 1;
}
$data = $orders->pagination($mode, $row, $currentPage);
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
			<div class="h1">รายการสั่งอาหาร</div>
			<div class="h2 mb-5">Orders list</div>
		</div>
		<div class="row mx-auto my-3">
			<div class="col-sm"><a href="?m=0" class="btn btn-block btn-danger">ยังไม่ได้ชำระเงิน</a></div>
			<div class="col-sm"><a href="?m=1" class="btn btn-block btn-info">รอชำระเงิน</a></div>
			<div class="col-sm"><a href="?m=2" class="btn btn-block btn-success">ชำระเงินเรียบร้อย</a></div>
		</div>
		<div class="table-responsive-xl">
			<table class="table table-borderless table-striped table-hover" border="1">
				<thead class="thead-dark">
					<tr class="text-center">
						<th>#</th>
						<th>โต๊ะ</th>
						<th>เวลา</th>
						<th>สถานะ</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < sizeof($data); $i++) { ?>
						<tr class="text-center">
							<td>
								<a href="orders_detail.php?id=<?php echo $data[$i]['or_id']?>"><?php echo $data[$i]['or_id']; ?></a>
							</td>
							<td>
								<a href="orders_detail.php?id=<?php echo $data[$i]['or_id']?>"><?php echo $data[$i]['or_table']; ?></a>
							</td>
							<td>
								<a href="orders_detail.php?id=<?php echo $data[$i]['or_id']?>"><?php echo $data[$i]['or_time']; ?></a>
							</td>
							<td>
								<a href="orders_detail.php?id=<?php echo $data[$i]['or_id']?>">
									<?php
									if ($data[$i]['or_pay_status'] == 2) { ?>
										<i class="fas fa-check text-success" aria-hidden="true"></i>
									<?php }elseif ($data[$i]['or_pay_status'] == 1) { ?>
										<!-- <i class="fas fa-spinner text-info loader" aria-hidden="true"></i> -->
										<i class="fad fa-circle-notch text-info loader" aria-hidden="true"></i>
									<?php }else{ ?>
										<i class="fas fa-times text-danger" aria-hidden="true"></i>
									<?php }	?>
								</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<?php $orders->navPagination($currentPage); ?>
	</div>
</body>
</html>