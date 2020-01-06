<?php require_once 'class-autoload.inc.php'; ?>
<?php

// error_reporting(0);
// ini_set('display_errors', 0);

$row = 10;
if (empty($_POST['value'])) {
	$value = '';
} else {
	$value = $_POST['value'];
}

if (empty($_POST['page'])) {
	$currentPage = 1;
} else {
	$currentPage = $_POST['page'];
}

$foods = new foodsview();
$data = $foods->pagination($value, $row, $currentPage);
$status = array('ปิดใช้งาน', 'เปิดใช้งาน');
?>
<div class="table-responsive-xl">
	<table class="table table-borderless table-striped table-hover" border="1">
		<thead class="thead-dark">
			<tr class="text-center">
				<th>#</th>
				<th>ชื่อ</th>
				<th>กิโลแคลอรี่</th>
				<th>ราคา</th>
				<th>สถานะ</th>
				<th>แก้ไข</th>
				<th>ลบ</th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i = 0; $i < count($data); $i++) { ?>
				<tr class="text-center">
					<td>
						<a href="foods.php?id=<?php echo $data[$i]['mf_id'];?>"><?php echo $i+1;?></a>
					</td>
					<td>
						<a href="foods.php?id=<?php echo $data[$i]['mf_id'];?>"><?php echo $data[$i]['mf_name'];?></a>
					</td>
					<td align="center">
						<a href="foods.php?id=<?php echo $data[$i]['mf_id'];?>"><?php echo $data[$i]['mf_kcal'];?></a>
					</td>
					<td align="center">
						<a href="foods.php?id=<?php echo $data[$i]['mf_id'];?>"><?php echo $data[$i]['mf_price'];?></a>
					</td>
					<td align="center">
						<a href="foods.php?id=<?php echo $data[$i]['mf_id'];?>"><?php echo $status[$data[$i]['mf_status']];?></a>
					</td>
					<td align="center"><i class="fal fa-edit" data-id="<?php echo $data[$i]['cus_id'];?>" onclick="edit(this);"></i></td>
					<td align="center"><i class="fal fa-edit" data-id="<?php echo $data[$i]['cus_id'];?>" onclick="edit(this);"></i></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php $foods->navPagination($currentPage); ?>
