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
									<button class="btn btn-outline-danger" id="<?=$_SESSION['order_id'][$d2][$d3]?>" onclick="del(this.id);"><i class="fas fa-minus-circle"></i></button>
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
		<button class="btn btn-block btn-success" id="btnConfrim">ยืนยันการสั่งอาหาร</button>
	</div>
	<div class="col-md-3" id="checkbill">
		<button class="btn btn-block btn-info" id="btnCheckbill">คิดเงิน</button>
	</div>
</div>
<script>
	$(document).ready(function() {
		
		$('#confrim').hide();
		$('#checkbill').hide();
		var size  = <?php echo (int)@$_SESSION['order_size'];?>;
		var price = <?php echo (int)@$_SESSION['order_submit'][0][0];?>;
		var submit = <?php echo $x;?>;
		if (size > 0) {
			$('#confrim').show();
		}
		if (price != 0) {
			$('#checkbill').show();
		}
		$('#btnCheckbill').click(function() {
			var cus_id = <?php echo $_SESSION['cus_id']; ?>;
			$.post('includes/orders.inc.php', {cus_id: cus_id, pay_status: '1'}, function(data, textStatus, xhr) {
				Swal.fire({
					title: 'กรุณารอพนักงาน',
					text: "กรุณารอพนักงานคิดเงิน!",
					confirmButtonText: "รอพนักงาน",
					confirmButtonColor: "#28A745",
					icon: 'success',
					width: 600,
					padding: '3em',
					background: '#fff',
					backdrop: `
					rgba(0, 51, 102,0.4)
					url("dist/img/giphy.gif")
					`,
				}).then(value => {window.location.reload();}, dismiss => {Swal.DismissReason.close})
			});
		});
		$('#btnConfrim').on('click', function(){
			Swal.fire({
				title: 'ยืนยัน?',
				text: "คุณต้องการ สั่งอาหารเมนูนี้!",
				icon: 'success',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ฉันต้องการสั่ง!',
				cancelButtonText: 'ยกเลิก',
				reverseButtons: true
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						url: 'includes/orders_confrim.inc.php',
					}).done(function(result, textStatus, xhr){
						if (result == 'fail') {
							Swal.fire('สั่งอาหาร !', 'ไม่สามารถยืนยันการสั่งอาหารได้', 'error')
						}else if (result == 'error table or res_id') {
							Swal.fire('สั่งอาหาร !', 'ไม่สามารถยืนยันโต๊ะ หรือ ร้านอารหาร ได้', 'error')
						}else if (result == 'success') {
							Swal.fire('สั่งเรียบร้อย !', 'ยืนยันการสั่งอารหารเรียบร้อย.', 'success').then(function(){
								window.location.reload();
							})
						}
					});
				}
			})
		});
	});
</script>