<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<?php
if (empty($_GET['p'])) {
	$currentPage = 1;
} else {
	$currentPage = $_GET['p'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once 'includes/head.inc.php'; ?>
	<style type="text/css" media="screen">
		@media print {
			@page {
				size: A4;
				margin: 27mm 16mm 27mm 16mm;
			}
			body * {
				visibility: hidden;
				margin: 0 0;
			}
			#printDiv, #printDiv * {
				visibility: visible;
			}
			#printDiv {
				position: absolute;
				left: 0;
				top: 0;
			}
		}
	</style>
</head>
<body data-page="<?php echo $currentPage; ?>" onload="return printValue(0);">
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<?php require_once 'includes/nav_menu.inc.php'; ?>
	<div class="container" id="menus_page">
		<blockquote class="blockquote text-center">
			<p class="mb-0">การสั่งอาหารออนไลน์จะ แสดงทั้งหมดและแยกประเภท</p>
			<footer class="blockquote-footer">ไม่เกี่ยวกับการ <cite title="Source Title">เลือกประเภท</cite> ในหน้านี้</footer>
		</blockquote>
		<div class="g1">
			<div id="printDiv"></div>
		</div>
	</div>
	<script src="dist/js/menus.js"></script>
	</body>
</html>