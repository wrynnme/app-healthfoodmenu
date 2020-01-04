<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php

$uri_name = substr(stristr(strrchr($_SERVER['REQUEST_URI'] ,'/') ,'_', true), 1);

$page = @$_GET['p'];
(@$page < 1)?$page = 1:NULL;

$status = array('ปิดการใช้งาน', 'เปิดการใช้งาน');

$types = new typeview();
$data = $types->getAll();
// print_r($data);
// echo sizeof($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php require_once 'includes/head.inc.php'; ?>
</head>
<body data-page="<?php echo $page;?>" data-name="<?php echo $uri_name;?>">
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<div class="container">

		<div class="text-center">
			<div class="h1">การจัดการประเภทอาหาร</div>
			<div class="h2 mb-5">Types Management</div>

			<div class="form-row justify-content-sm-center mb-2">
				<div class="col-sm-8">
					<input type="text" class="form-control inpSearch" placeholder="ชื่อเมนูอาหาร">
				</div>
				<div class="col-sm">
					<a class="btn btn-block btn-info" href="menu.php">พิมพ์รายการอาหาร</a>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col">
					<button class="btn btn-block btn-event btn-success" id="add" data-toggle="button" aria-pressed="false"> เพิ่ม </button>
				</div>
				<div class="col">
					<button class="btn btn-block btn-event btn-danger" id="dif" data-toggle="button" aria-pressed="false"> ลบ </button>
				</div>
				<div class="col">
					<button class="btn btn-block btn-event btn-warning" id="mod" data-toggle="button" aria-pressed="false"> แก้ไข </button>
				</div>
			</div>
			<div class="table-responsive-xl">
				<table class="table table-borderless table-striped table-hover" border="1">
					<thead class="thead-dark">
						<tr class="text-center">
							<th>#</th>
							<th>ชื่อ</th>
							<th>สถานะ</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 0; $i < sizeof($data); $i++) { ?>
							<tr class="data">
								<td>
									<div class="custom-control custom-checkbox tr-dif">
										<input type="checkbox" class="custom-control-input" id="<?php echo $data[$i]['type_id']; ?>">
										<label class="custom-control-label" for="<?php echo $data[$i]['type_id']; ?>"></label>
									</div>
								</td>
								<td>
									<?php echo $data[$i]['type_name']; ?>
								</td>
								<td>
									<?php echo $status[$data[$i]['type_status']]; ?>
								</td>
							</tr>
							<tr class="tr-mod">
								<td></td>
								<td>
									<input class="form-control" type="text" id="mod-input<?php echo $data[$i]['type_id']; ?>" value="<?php echo $data[$i]['type_name']; ?>" placeholder="ชื่อประเภท" style="display: inherit; width: 40%" maxlength="30">
								</td>
								<td>
									<i class="fas fa-check mod-confrim" id="<?php echo $data[$i]['type_id']; ?>" color="green" style="width: 25px;height: 25px;"></i>
									<i class="fas fa-times mod-cancle" id="<?php echo $data[$i]['type_id']; ?>" color="red" style="width: 25px;height: 25px;"></i>
								</td>
							</tr>
						<?php } ?>
						<tr class="tr-add">
							<td></td>
							<td>
								<input class="form-control" type="text" id="add-input" placeholder="ชื่อประเภท" style="display: inherit; width: 60%">
							</td>
							<td>
								<i class="fas fa-check" id="add-confrim" color="green" style="width: 25px;height: 25px;"></i>
								<i class="fas fa-times" id="add-cancel" color="red" style="width: 25px;height: 25px;"></i>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<hr>
			<div class="g2 tr-dif">
				<div class="row">
					<div class="col">
						<button type="button" class="btn btn-block btn-success" name="selectall" id="selectall">เลือกทั้งหมด</button>
					</div>
					<div class="col">
						<button type="button" class="btn btn-block btn-info" name="deselectall" id="deselectall">ยกเลิก ที่เลือกทั้งหมด</button>
					</div>
					<div class="col">
						<button type="button" class="btn btn-block btn-danger" name="delete" id="delete">ลบที่เลือก</button>
					</div>
					<!-- <div class="col">
						<button type="button" class="btn btn-block btn-primary" name="cancle" id="cancle">Cancle</button>
					</div> -->
				</div>
			</div>
		</div>
		<div id="resultDiv"></div>
	</div>
</div>
<script src="dist/js/type.js"></script>
<script src="dist/js/myjs.js"></script>
</body>
</html>