<?php require_once 'class-autoload.inc.php'; ?>
<?php

$row = 18;

if (empty($_POST['currentPage'])) {
	$currentPage = 1;
} else {
	$currentPage = $_POST['currentPage'];
}

$foods = new foodsview();
$types = new typeview();

if (empty($_POST['type'])) {
	$value = '';
	$type['type_name'] = 'ทั้งหมด';

} else {
	$value = $_POST['type'];
	$type = $types->getId($value);

}

$data = $foods->pagination_menu($value, $row, $currentPage);

print_r($data);

?>
<script>
	var total_data = <?php echo $foods->total_data; ?>;
	if (total_data < 1) {
		$('.g1').hide();
		Swal.fire('Oops...','ไม่สามารถพิมพ์ได้เนื่องจากไม่มีเมนูอาหาร !!!','error',{showClass: {popup: 'animated fadeInDown faster'}, hideClass: {popup: 'animated fadeOutUp faster'}}).then(function(){
			window.location = 'index.php';
		});
	}
</script>
<div class="row">
	<div class="col text-center py-5">
		<div class="h1"><?php echo $_SESSION['cus_res_name']; ?></div>
	</div>
	<div id="qrDiv"></div>
</div>
<div class="text-center h2 bold mb-5">
	<b><?php echo $type['type_name']; ?></b>
</div>
<table class="table table-striped" border="0" style="margin: 0 auto;">
	<thead>
		<tr class="text-center">
			<td><b>เมนู</b></td>
			<td><b>ราคา</b></td>
			<td><b>แคลอรี่</b></td>
		</tr>
	</thead>
	<tbody>
		<?php for ($i = 0; $i < sizeof($data); $i++) { ?>
			<tr class="text-center">
				<td>
					<?php echo $data[$i]['mf_name']; ?>
				</td>
				<td>
					<?php echo $data[$i]['mf_price']; ?>
				</td>
				<td>
					<?php echo $data[$i]['mf_kcal']; ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<div class="text-center print" id="">
	<br>
	<button type="button" class="btn btn-warning btn-block" id="print" onclick="printDiv();"><i class="fal fa-print"></i> พิมพ์</button>
</div>
<br>
<?php $foods->navPagination($currentPage); ?>