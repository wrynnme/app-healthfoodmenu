<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php $uri_name = substr(stristr(strrchr($_SERVER['REQUEST_URI'] ,'/') ,'_', true), 1); ?>
<?php (empty($_SESSION['currentSize']))?header('Location:foods_list.php'):NULL; ?>
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
			<div class="h1">เมนูของฉัน</div>
			<div class="h2 mb-5">My menu</div>
		</div>
		<div class="row">
			<div class="col-3 h2 text-right">
				ชื่อเมนู
			</div>
			<div class="col">
				<input type="text" class="form-control" name="food_name" id="food_name" placeholder="ชื่อเมนูอาหาร" minlength="3" required onkeyup="return foodname(this.value);" value="<?=@$_SESSION['food_name'];?>">
			</div>
		</div>
		<br>
		<div class="table-responsive-xl">
			<table class="table table-borderless table-striped table-hover" border="1" style="">
				<thead class="thead-dark">
					<tr class="text-center">
						<th>#</th>
						<th>ชื่อวัตถุดิบ</th>
						<th>ประเภท</th>
						<th>กรัม</th>
						<th>แคลอรี่</th>
						<th>ลบ</th>
					</tr>
				</thead>

				<?php
				$Total = 0;
				$SumTotal = 0;
				$ings = new ingredientsview();
				for($i=0; $i <= (int)$_SESSION["intLine"]; $i++) {
					if($_SESSION["pro_id"][$i] != "") {
						$pro = $ings->id($_SESSION["pro_id"][$i]);
						$proType = $ings->idType($pro['ing_type']);
						?>
						<tbody>
							<tr>
								<td class="text-center"><?php echo $_SESSION['pro_id'][$i];?></td>
								<td><?php echo $pro['ing_name'];?></td>
								<td class="text-center"><?php echo $proType['ingt_name'];?></td>
								<td class="text-center">
									<input type="number" class="form-control fix-width" name="gram" id="gram" value="<?=$_SESSION['gram'][$i]?>" placeholder="จำนวนกรัม" onkeyup="return cal_kcal(this.value, <?php echo $pro['ing_unit'];?>, <?php echo $pro['ing_kcal'];?>, <?php echo $i;?>);" onfocusout="return cal_kcal(this.value, <?php echo $pro['ing_unit'];?>, <?php echo $pro['ing_kcal'];?>, <?php echo $i;?>);" min="0" maxlength="4" required>
									<!-- <input type="number" class="form-control fix-width" name="gram" id="gram" value="<?=$_SESSION['gram'][$i]?>" placeholder="จำนวนกรัม" onkeyup="return cal_kcal(this.value, <?php echo $pro['ing_unit'];?>, <?php echo $pro['ing_kcal'];?>, <?php echo $i;?>);" onfocusout="return cal_kcal(this.value, <?php echo $pro['ing_unit'];?>, <?php echo $pro['ing_kcal'];?>, <?php echo $i;?>);" maxlength="4" i="<?=$i;?>" required> -->
								</td>
								<td class="text-center" id="allcal<?=$i?>"><?=number_format(@$_SESSION['allcal'][$i],2);?></td>
								<td class="text-center"><button class="btn btn-outline-danger" onclick="del(<?=$i;?>, 'show');"><i class="fas fa-minus-circle"></i></button></td>
							</tr>
						</tbody>
						<?php
					}
				}
				?>
			</table>
		</div>
		<?php $cus_id = $_SESSION['cus_id']; ?>
		<?php
		$types = new typeview();
		$type = $types->getAll();
		?>
		<div class="row">
			<div class="col-md text-right">
				<label class="col-form-label" for="type">
					<a href="type_list.php">
						<h5>ประเภทของคุณ</h5>
					</a>
				</label>
			</div>
			<div class="col-md">
				<select class="custom-select" name="type" id="type" onchange="return choosetype();">
					<?php if($_SESSION['type_id'] == NULL){ ?>
						<option selected disabled value=""><h6 class="dropdown-header">เลือกประเภทของคุณ</h6></option>
					<?php }else{ ?>
						<?php
						$havechoose = $types->getId($_SESSION['type_id']);
						print_r($havechoose);
						?>
						<option selected value="<?=$_SESSION['type_id']?>"><?php echo $havechoose['type_name']?></option>
						<option disabled><h6 class="dropdown-header">----------</h6></option>
					<?php } ?>
					<?php for($i = 0; $i < sizeof($type);$i++){ ?>
						<option value="<?php echo $type[$i]['type_id']?>"><?php echo $type[$i]['type_name']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md text-right">
				<label class="col-form-label" for="price">
					<h5>ราคา</h5>
				</label>
			</div>
			<div class="col-md">
				<input type="number" class="form-control" name="price" id="price" placeholder="ราคา" step="0.01" onkeyup="return foodprice(this.value);" value="<?php echo @$_SESSION['food_price'];?>" onfocus="return foodprice(this.value);" value="<?php echo @$_SESSION['food_price'];?>" min="0" required>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md">
				<div class="text-right" id="allkcal">
					<?php if (@$_SESSION['allcal'] == null) { echo "<h4>แคลอรี่ทั้งหมด : 0.00</h4>"; }else{ echo "<h4>แคลอรี่ทั้งหมด : ".array_sum(@$_SESSION['allcal'])."</h4>"; } ?>
				</div>
			</div>
			<div class="col-md">
				<button class="btn btn-success btn-block" id="food_new">ยืนยันเมนูอาหารนี้</button>
			</div>
			<div class="col-md-2">
				<button class="btn btn-outline-danger btn-block" onclick="window.location.href='del.php?cancelmenu';">ยกเลิกเมนูนี้</button>
			</div>
		</div>
		<hr>
	</div>	
	<script src="dist/js/be.js"></script>
	<script src="dist/js/myjs.js"></script>
	<script>
		$('#food_new').click(function(){
			$.post('includes/food_save.inc.php', function(data, textStatus, xhr) {
				if (data == 'success') {
					Swal.fire('เพิ่ม', 'เพิ่มข้อมูลอาหารสำเร็จ !', 'success').then(function(){window.location = 'foods_list.php';})
				}else if(data == 'gram'){
					Swal.fire('เพิ่ม', 'กรุณากรอกจำนวน กรัมของวัตถุดิบ !', 'error')
				}else if(data == 'ingt'){
					Swal.fire('เพิ่ม', 'กรุณาเพิ่ม วัตถุดิบ หรือ กรอกจำนวน กรัมของวัตถุดิบ !', 'error')
				}else if(data == 'name'){
					Swal.fire('เพิ่ม', 'กรุณากรอก ชื่อเมนู หรือ ราคาให้เรียบร้อย !', 'error')
				}
			});
		});
	</script>
</body>
</html>