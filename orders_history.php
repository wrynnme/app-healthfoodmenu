<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php
@session_start();
$page = @$_GET['p'];
(@$page < 1)?$page = 1:NULL;
$row = 20;
$or_phpsessid = session_id();
$orders = new ordersview();
$data = $orders->cli_pagination($or_phpsessid, $row, $page);
$users = new usersview();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php require_once 'includes/head.inc.php'; ?>
</head>
<body>
	<?php require_once 'includes/nav_clients.php'; ?>
	<div class="container">
		<div class="g1 text-center">
			<label for="">
				<h2>ประวัติการสั่งอาหาร</h2>
			</label>
			<div class="table-responsive-xl">
				<table class="table table-borderless table-striped table-hover" border="1">
					<thead class="thead-dark">
						<tr>
							<td>#</td>
							<td>ร้าน</td>
							<td>โต๊ะ</td>
							<td>เวลา</td>
							<td>กิโลแคลอรี่</td>
							<td>ราคา</td>
							<td>สถานะการจ่ายเงิน</td>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 0; $i < sizeof($data); $i++) { ?>
							<?php $res = $users->show($data[$i]['cus_id']); ?>
							<?php $rname = $res['cus_res_name'];?>
							<tr>
								<td>
									<?php echo $data[$i]['or_id']; ?>
								</td>
								<td>
									<?php echo $rname; ?>
								</td>
								<td>
									<?php echo $data[$i]['or_table']; ?>
								</td>
								<td>
									<?php echo $data[$i]['or_time']; ?>
								</td>
								<td>
									<?php echo $data[$i]['or_kcal']; ?>
								</td>
								<td>
									<?php echo $data[$i]['or_kcal']; ?>
								</td>
								<td>
									<?php
									if ($data[$i]['or_pay_status'] == 2) { ?>
										<i class="fas fa-check text-success" aria-hidden="true"></i>
									<?php }elseif ($data[$i]['or_pay_status'] == 1) { ?>
										<i class="fad fa-circle-notch text-info loader" aria-hidden="true"></i>
									<?php }else{ ?>
										<i class="fas fa-times text-danger" aria-hidden="true"></i>
									<?php }	?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php $orders->navPagination($page); ?>
	</div>
</body>
</html>