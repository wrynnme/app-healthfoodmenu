<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php

$uri_name = substr(stristr(strrchr($_SERVER['REQUEST_URI'] ,'/') ,'_', true), 1);

$page = @$_GET['p'];
(@$page < 1)?$page = 1:NULL;
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
			<div class="h1">การจัดการเมนูอาหาร</div>
			<div class="h2 mb-5">Food Menu Management</div>
			<div class="form-row justify-content-sm-center mb-5">
				<div class="col-sm-8">
					<input type="text" class="form-control inpSearch" placeholder="ชื่อเมนูอาหาร">
				</div>
				<div class="col-sm">
					<a class="btn btn-block btn-info" href="menu.php">พิมพ์รายการอาหาร</a>
				</div>
			</div>
			<div id="resultDiv"></div>
		</div>
	</div>
	<script src="dist/js/myjs.js"></script>
	<script>
		$(document).ready(function() {
			search(this.value);
		});
	</script>
</body>
</html>