<?php require_once 'class-autoload.inc.php'; ?>
<?php

$row = 10;

if (empty($_POST['currentPage'])) {
	$currentPage = 1;
} else {
	$currentPage = $_POST['currentPage'];
}

$foods = new foodsview();
$types = new typeview();
$special = $foods->getSpecial($_SESSION['cus_id']);

if (empty($_POST['type'])) {
	$value = '';
	$type['type_name'] = 'ทั้งหมด';

} else {
	$value = $_POST['type'];
	$type = $types->getId($value);

}

$data = $foods->pagination_menu($value, $row, $currentPage);

?>
<script>
	var total_data = <?php echo $foods->total_data; ?>;
	if (total_data < 1) {
		$('.g1').hide();
		Swal.fire('Oops...','ไม่สามารถพิมพ์ได้เนื่องจากไม่มีเมนูอาหาร !!!','error',{showClass: {popup: 'animated fadeInDown faster'}, hideClass: {popup: 'animated fadeOutUp faster'}}).then(function(){
			window.location = 'index.php';
		});
	}
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	})
</script>
<div class="row mx-auto my-auto text-center">
	<?php if ($_SESSION['cus_logo'] != '' || $_SESSION['cus_logo'] != NULL) { ?>
		<div class="col mx-auto my-auto" id="logoDiv">
				<img src="dist/img/logos/<?php echo $_SESSION['cus_logo']?>" alt="logo" width="300px">
		</div>
	<?php } ?>
	<div class="col mx-auto my-auto text-center" id="resDiv">
		<div class="h1"><?php echo $_SESSION['cus_res_name']; ?></div>
	</div>
	<div class="col mx-auto my-auto" id="qrDiv" data-toggle="tooltip" data-placement="bottom" data-original-title="คลิกเพื่อลบ QR Code" style="display:none;"></div>
</div>
<div class="text-center h2 bold my-auto">
	<b><?php echo $type['type_name']; ?></b>
</div>
<table class="table table-striped" border="0" style="margin: 0 auto;" style="width:400px;">
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
<div class="row my-5 mx-auto">
<?php for ($i = 0; $i < sizeof($special); $i++) { ?>
	<?php $thisimg = $foods->getId($special[$i]['mf_id'])	?>
	<div class="col text-center mx-auto">
		<a href="foods.php?id=<?php echo $thisimg['mf_id'];?>">
			<img src="dist/img/foods/<?php echo $thisimg['mf_img']; ?>"  width="250px" class="img-thumbnail rounded mx-auto d-block">
			<?php echo $thisimg['mf_name']; ?>
		</a>
	</div>
<?php } ?>
</div>
<div class="row my-5 mx-auto">
<?php for ($i = 0; $i < sizeof($special); $i++) { ?>
	<?php $thisimg = $foods->getId($special[$i]['mf_id'])	?>
	<div class="col text-center mx-auto">
		<a href="foods.php?id=<?php echo $thisimg['mf_id'];?>">
			
		</a>
	</div>
<?php } ?>
</div>
<div class="text-center print" id="">
	<br>
	<button type="button" class="btn btn-warning btn-block" id="print" onclick="printDiv();"><i class="fal fa-print"></i> พิมพ์</button>
</div>
<br>
<?php $foods->navPagination($currentPage); ?>
