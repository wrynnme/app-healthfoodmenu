<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php
if (@$_SESSION['new_menu'] == '1') {
	unset($_SESSION['intLine']);
	unset($_SESSION['new_menu']);
}
if (isset($_GET['id'])) {
	$mf_id = $_GET['id'];
	$foods = new foodsview();
	$food = $foods->getId($mf_id);
	if ($_SESSION['cus_id'] == $food['cus_id']) {
		$_SESSION['edit_food'] = $mf_id;
		$_SESSION['food_name'] = $food['mf_name'];
		$_SESSION['food_price'] = $food['mf_price'];
		$_SESSION['type_id'] = $food['type_id'];
		$ingtDB = array('1' => 'oils', '2' => 'eggs', '3' => 'seas', '4' => 'meats', '5' => 'vegetables', '6' => 'ran', '7' => 'nas', '8' => 'milks', '9' => 'fruits', '10' => 'garnishs');
		if (!isset($_SESSION["intLine"])) {
			$_SESSION["intLine"] = 0;
			$_SESSION['currentSize'] = 1;
			$c = 0;
			for ($l = 0; $l < sizeof($ingtDB); $l++) {
				$c++;
				$tableDB = $ingtDB[$c];
				$detail = $foods->getDetail($tableDB, $mf_id);
				for ($i = 0; $i < sizeof($detail); $i++){
					$_SESSION['currentSize']++;
					$_SESSION['pro_id'][$_SESSION['intLine']] = $detail[$i][2];
					$_SESSION['gram'][$_SESSION['intLine']] = $detail[$i][3];
					$_SESSION['allcal'][$_SESSION['intLine']] = $detail[$i][4];
					$_SESSION["intLine"]++;
				}
			}
			$_SESSION['currentSize']--;
			$_SESSION["intLine"]--;
		}
	}else{
		header('Location: index.php');
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once 'includes/head.inc.php'; ?>
	<style>
		
	</style>
</head>
<body>
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<div class="container">
		<div class="g1">
			<div class="text-center">
				<h1>แก้ไขเมนู <?=$_SESSION['food_name']?></h1>
			</div>
			<br><br>
			<div class="row">
				<div class="col-3 text-right">
					<h2>เมนู </h2>
				</div>
				<div class="col">
					<input type="text" class="form-control" name="food_name" id="food_name" placeholder="ชื่อเมนูอาหาร" minlength="3" required onkeyup="return foodname(this.value);" value="<?php echo @$_SESSION['food_name'];?>">
				</div>
			</div>
			<br>
			<div class="table-responsive-xl">
				<table class="table table-borderless table-striped table-hover">
					<thead class="text-center thead-dark">
						<tr>
							<th>#</th>
							<th>ชื่อวัตถุดิบ</th>
							<th>ประเภท</th>
							<th>กรัม</th>
							<th>แคลอรี่</th>
							<th>ลบ</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$Total = 0;
						$SumTotal = 0;
						$ings = new ingredientsview();
						$i = 0;
						foreach ($_SESSION['pro_id'] as $key => $value) {
							// echo $key.'=>'.$value.'<br>';
							if($value != "") {
								$ing = $ings->id($value);
								$type = $ings->idType($ing['ing_type']);
								?>
								<tr>
									<td class="text-center"><?php echo $i+1;?></td>
									<td><?php echo $ing["ing_name"];?></td>
									<td class="text-center"><?php echo $type['ingt_name'];?></td>
									<td class="text-center">
										<input type="number" class="form-control fix-width" name="gram" id="gram" value="<?php echo $_SESSION['gram'][$key]?>" placeholder="จำนวนกรัม" onkeyup="return cal_kcal(this.value, <?php echo $ing['ing_unit'];?>, <?php echo $ing['ing_kcal'];?>, <?php echo $key;?>);" required maxlength="4">
									</td>
									<td class="text-center" id="allcal<?php echo $key; ?>"><?php echo number_format(@$_SESSION['allcal'][$key],2);?></td>
									<td class="text-center"><button class="btn btn-outline-danger" onclick="del_foods(<?php echo $key;?>, 'edit');"><i class="fas fa-minus-circle"></i></button></td>
								</tr>
								<?php
							}
							$i++;
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="row">
				<?php $cus_id = $_SESSION['cus_id']; ?>
				<?php
				$types = new typeview();
				$type = $types->getAll();?>
				<div class="col-md text-right">
					<label class="col-form-label" for="type">
						<a href="type.php">
							<h5>ประเภทของคุณ</h5>
						</a>
					</label>
				</div>
				<div class="col-md">
					<select class="custom-select" name="type" id="type" onchange="return choosetype();">
						<?php if($_SESSION['type_id'] == NULL){ ?>
							<option selected disabled><h6 class="dropdown-header">เลือกประเภทของคุณ</h6></option>
						<?php }else{ ?>
							<?php $hc = $types->getId($_SESSION['type_id']);?>
							<option selected value="<?php echo $_SESSION['type_id']; ?>"><?php echo $hc['type_name']; ?></option>
							<option value="0"><h6 class="dropdown-header">นำประเภทออกจากเมนู</h6></option>
						<?php } ?>
						<?php for ($i = 0; $i < sizeof($type); $i++) { ?>
							<option value="<?php echo $type[$i]['type_id']; ?>"><?php echo $type[$i]['type_name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md">
					<h2 class="text-right">ราคา</h2>
				</div>
				<div class="col-md">
					<input type="number" class="form-control" name="price" placeholder="ราคา" step="0.01" required onkeyup="return foodprice(this.value);" value="<?=$_SESSION['food_price'];?>">
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
					<button class="btn btn-success btn-block" id="save">ยืนยันเมนูอาหารนี้</button>
				</div>
				<div class="col-md-2">
					<button class="btn btn-outline-danger btn-block" onclick="window.location.href='del.php?cancelfood=<?php echo $mf_id;?>';">ยกเลิกเมนูนี้</button>
				</div>
			</div>
		</div>
	</div>
	<script src="dist/js/be.js"></script>
	<script src="dist/js/myjs.js"></script>
	<script>
		$('#save').click(function(){
			$.post('includes/foods_edit.inc.php', function(data, textStatus, xhr) {
				console.log(data);
				if (data == 'success') {
					Swal.fire('แก้ไข', 'แก้ไขข้อมูลอาหารสำเร็จ !', 'success').then(function(){window.location = 'foods_list.php';})
				}else if(data == 'gram'){
					Swal.fire('แก้ไข', 'กรุณากรอกจำนวน กรัมของวัตถุดิบ !', 'error')
				}else if(data == 'ingt'){
					Swal.fire('แก้ไข', 'กรุณาเพิ่ม วัตถุดิบ หรือ กรอกจำนวน กรัมของวัตถุดิบ !', 'error')
				}else if(data == 'name'){
					Swal.fire('แก้ไข', 'กรุณากรอก ชื่อเมนู หรือ ราคาให้เรียบร้อย !', 'error')
				}else if(data == 'delete'){
					Swal.fire('แก้ไข', 'ไม่สามารถบันทึกข้อมูลที่ถูกลบออกไปได้ !', 'error')
				}else if(data == 'add'){
					Swal.fire('แก้ไข', 'ไม่สามารถบันทึกข้อมูลที่ถูกเพิ่มมาได้ !', 'error')
				}
			});
		});
	</script>
</body>
</html>