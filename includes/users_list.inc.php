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

$users = new usersview();
$data = $users->pagination($value, $row, $currentPage);
$permission = array('ผู้ดูแลระบบ', 'ผู้ใช้งาน');
$status = array('ออกจากระบบ', 'กำลังใช้งาน');
?>
<div class="table-responsive-xl">
	<table class="table table-borderless table-striped table-hover" border="1">
		<thead class="thead-dark">
			<tr class="text-center">
				<th>#</th>
				<th>ชื่อ</th>
				<th>ชื่อร้าน</th>
				<th>อีเมล์</th>
				<th>เบอร์โทร</th>
				<th>วันที่สมัคร</th>
				<th>สถานะ</th>
				<th>สิทธิ์การใช้งาน</th>
				<th>แก้ไข</th>
				<th>การใช้งาน</th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i = 0; $i < sizeof($data); $i++) { ?>
				<tr class="text-center <?php echo ((string)$data[$i]['cus_permission'] == '0')?'bg-primary text-light': NULL; ?> <?php echo ((string)$data[$i]['cus_status'] == '0')?'bg-danger text-light': NULL; ?>">
					<td><?php echo $i+1;?></td>
					<td><?php echo $data[$i]['cus_fname']." ".$data[$i]['cus_lname'];?></td>
					<td class="text-center"><?php echo $data[$i]['cus_res_name'];?></td>
					<td><?php echo $data[$i]['cus_email'];?></td>
					<td><?php echo $data[$i]['cus_tel'];?></td>
					<td><?php echo $data[$i]['cus_regis_date'];?></td>
					<td><?php echo $status[$data[$i]['cus_login']];?></td>
					<td><?php echo $permission[$data[$i]['cus_permission']];?></td>
					<td class="text-center"><i class="fal fa-edit" data-id="<?php echo $data[$i]['cus_id'];?>" onclick="edit(this);"></i></td>
					<?php if ($data[$i]['cus_status'] == 1) { ?>
						<td class="text-center"><i class="far fa-check" data-id="<?php echo $data[$i]['cus_id'];?>" onclick="del_user(this);"></i></td>
					<?php } else { ?>
						<td class="text-center"><i class="far fa-ban" data-id="<?php echo $data[$i]['cus_id'];?>" onclick="active_user(this);"></i></td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php $users->navPagination($currentPage); ?>
