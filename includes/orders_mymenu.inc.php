<?php require_once 'class-autoload.inc.php'; ?>
<?php $res_id = $_POST['res_id']; ?>
<?php
@$x = array_search(0, $_SESSION['order_submit']);
if ((string)@$x == '') {
	$x = 0;
}

$foods = new foodsview();
$types = new typeview();
?>
<div class="table-responsive-xl">
	<table class="table table-borderless table-striped table-hover">
		<thead class="text-center thead-dark">
			<tr>
				<th>#</th>
				<th>ชื่อเมนู</th>
				<th>ประเภท</th>
				<th>จำนวน</th>
				<th>แคลอรี่</th>
				<th>ราคา</th>
				<th>ลบ</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$Total = 0;
			$SumTotal = 0;
			for ($d2 = 0; $d2 <= (int)@$_SESSION['order']; $d2++) {
				for($d3=0; $d3 <= (int)@$_SESSION["order_line"][$d2]; $d3++) {
					@$order_id = $_SESSION['order_id'][$d2];
					if(@$order_id[$d3] != "") {
						$food = $foods->getId($order_id[$d3]);
						$type = $types->getOrder($res_id, $food['type_id']);
						if (empty($type['type_name'])) {
							$type['type_name'] = '';
						}
						?>
						<div class="sr-only" id="id<?=$d3;?>" data-kcal="<?php echo $food['mf_kcal']?>" data-price="<?php echo $food['mf_price']?>"></div>
						<tr>
							<td class="text-center"><?php echo $d3 + 1;?></td>
							<td class="text-center"><?php echo $food['mf_name'];?></td>
							<td class="text-center"><?php echo $type['type_name'];?></td>
							<td class="text-center" id="qty<?=$d3;?>" name="<?=$_SESSION['order_qty'][$d2][$d3];?>"><?=$_SESSION['order_qty'][$d2][$d3];?></td>
							<td class="text-center" id="total_kcal<?=$d3?>"><?php echo number_format($_SESSION['order_kcal'][$d2][$d3], 2); ?></td>
							<td class="text-center" id="total_price<?=$d3?>"><?php echo number_format($_SESSION['order_price'][$d2][$d3], 2); ?></td>
							<td class="text-center">
								<?php if ($_SESSION['order_submit'][$d2][$d3] == '0') { ?>
									<button class="btn btn-outline-danger" id="<?php echo $_SESSION['order_id'][$d2][$d3]; ?>" data-id="<?php echo $_SESSION['order_id'][$d2][$d3]; ?>" data-res="<?php echo $_SESSION['order_res_id'] ?>" onclick="del_order(this);"><i class="fas fa-minus-circle"></i></button>
								<?php } ?>
							</td>
						</tr>
						<?php
					}
				}
			}	
			?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md text-right">
		<label for="all_kcal"><h5>แคลอรี่ทั้งหมด : </h5></label>
	</div>
	<div class="col-md">
		<h5><div id="all_kcal"><?php echo number_format(@$_SESSION['all_kcal'], 2); ?></div></h5>
	</div>
	<div class="col-md text-right">
		<label for="all_price"><h5>ราคา : </h5></label>
	</div>
	<div class="col-md">
		<h5><div id="all_price"><?php echo number_format(@$_SESSION['all_price'], 2); ?></div></h5>
	</div>
</div>
<div class="row">
	<div class="col-md" id="confrim">
		<button class="btn btn-block btn-success" id="btnConfrim" onclick="confrim();">ยืนยันการสั่งอาหาร</button>
	</div>
	<div class="col-md-3" id="checkbill">
		<button class="btn btn-block btn-info" id="btnCheckbill" data-cus="<?php echo $_SESSION['cus_id']; ?>" onclick="checkbill(this);">คิดเงิน</button>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#confrim').hide();
		$('#checkbill').hide();
		var size  = <?php echo (int)@$_SESSION['order_size'];?>;
		var price = <?php echo (int)@$_SESSION['order_submit'][0][0];?>;
		var submit = <?php echo (int)@$_SESSION['order_submit'][0][0];?>;
		if (parseInt(size) > 0) {
			$('#confrim').show();
		}
		if (price != 0) {
			$('#checkbill').show();
		}
	});
</script>