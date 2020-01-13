<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php require_once 'includes/head.inc.php'; ?>
	<style>
		.recent{
			background: #fff;
			width: 100%;
			height: auto;
			padding: 1rem;
		}
		hr{
			padding: unset;
			margin: 5px;
		}
		.sync{

		}
	</style>
</head>
<body onload="dateNow(1); recent('order'); recent('checkbill'); recent('menu'); recent('login'); recent('customer'); recent('ingt');">
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<?php 

	if ($_SESSION['cus_permission'] == '0') {
		echo "<h3> PHP List All Session Variables</h3>";
		$arr = get_defined_vars();
		print_r($arr);

	}	
	?>
	<hr>
	<div class="container">
		<div class="text-center h1 row py-3">
			<div class="col-md">
				<?php echo $_SESSION['cus_res_name']; ?>
			</div>
			<div class="col-md h4 datetime py-3"></div>
		</div>
		<?php if ($_SESSION['cus_permission'] == '0'){ ?>
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" id="customSwitch1"  data-toggle="collapse" data-target="#admin" aria-expanded="false" aria-controls="admin">
				<label class="custom-control-label" for="customSwitch1">สำหรับผู้ดูแล</label>
			</div>
			<div class="collapse" id="admin">
				<div class="recent border border-light rounded-lg my-3">
					<div class="row">
						<div class="col h4">เข้าสู่ระบบล่าสุด</div>
						<div class="col h4 text-right"><i class="sync fad fa-sync-alt" id="login" onclick="refreshBtn(this.id);"></i></div>
					</div>
					<div id="recentlogin" class="container"></div>
				</div>
				<div class="recent border border-light rounded-lg my-3">
					<div class="row">
						<div class="col h4">สมาชิกล่าสุด</div>
						<div class="col h4 text-right"><i class="sync fad fa-sync-alt" id="customer" onclick="refreshBtn(this.id);"></i></div>
					</div>
					<div id="recentcustomer" class="container"></div>
				</div>
				<div class="recent border border-light rounded-lg my-3">
					<div class="row">
						<div class="col h4">วัตถุดิบล่าสุด</div>
						<div class="col h4 text-right"><i class="sync fad fa-sync-alt" id="ingt" onclick="refreshBtn(this.id);"></i></div>
					</div>
					<div id="recentingt" class="container"></div>
				</div>
			</div>
		<?php } ?>
		<div class="text-right h6">ระบบจะทำการรีเฟรชข้อมูลอัตโนมัติทุกๆ 5 นาที</div>
		<div id="" class="recent border border-dark rounded-lg my-3">
			<div class="row">
				<div class="col h4">รายการสั่งอาหารล่าสุด</div>
				<div class="col h4 text-right"><i class="sync fad fa-sync-alt" id="order" onclick="refreshBtn(this.id);"></i></div>
			</div>
			<div id="recentorder" class="container"></div>
		</div>
		<div id="" class="recent border border-dark rounded-lg my-3">
			<div class="row">
				<div class="col h4">รายการรอคิดเงินล่าสุด</div>
				<div class="col h4 text-right"><i class="sync fad fa-sync-alt" id="checkbill" onclick="refreshBtn(this.id);"></i></div>
			</div>
			<div id="recentcheckbill" class="container"></div>
		</div>
		<div id="" class="recent border border-dark rounded-lg my-3">
			<div class="row">
				<div class="col h4">รายการอาหารที่สร้างล่าสุด</div>
				<div class="col h4 text-right"><i class="sync fad fa-sync-alt" id="menu" onclick="refreshBtn(this.id);"></i></div>
			</div>
			<div id="recentmenu" class="container"></div>
		</div>
	</div>
	<script>
		function dateNow(lang){
			var date = new Date();
			var days = [["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"], ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"]];
			var months = [["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"]];
			var txt = [days[0][date.getDay()] + " " + date.getDate() + " " + months[0][date.getMonth()] + " "+ (date.getFullYear()) + " Time : " + (date.getHours()<10?'0':'') + date.getHours() + ":" + (date.getMinutes()<10?'0':'') + date.getMinutes() + ":" + (date.getSeconds()<10?'0':'') + date.getSeconds(),days[1][date.getDay()] + " ที่ " + date.getDate() + " " + months[1][date.getMonth()] + " "+ (date.getFullYear()+543) + " เวลา : " + (date.getHours()<10?'0':'') + date.getHours() + ":" + (date.getMinutes()<10?'0':'') + date.getMinutes() + ":" + (date.getSeconds()<10?'0':'') + date.getSeconds()];
			$('.datetime').html(txt[lang]);
			setTimeout(function() {
				dateNow(lang);
			}, 1000);
		}
		function refreshBtn(id){
			$('#'+id).addClass('loader');
			recent(id);
		}
		function recent(id){
			$.ajax({
				url: 'includes/index.inc.php',
				type: 'POST',
				data: {where: id},
			}).done(function(result, textStatus, xhr) {
				$('#recent'+id).html(result);
				$('#'+id).removeClass('loader');
			}).fail(function() {
				console.log("error");
			});
		}
		$(document).ready(function() {
			setInterval(function() {
				recent('order');
				recent('checkbill');
				recent('menu');
				recent('login');
				recent('customer');
				recent('ingt');
			}, ((1000 * 60) * 5));
		});
	</script>
</body>
</html>