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
	<script>
		function printValue(type){
			var currentPage = $('body').data("page");
			$.ajax({
				type:"POST",
				url:"includes/menus.inc.php",
				data:{type:type, currentPage:currentPage},
				success:function(data){
					$("#printDiv").html(data);
					$('.btn').removeClass('active');
				}
			});
		}
		
	</script>
</head>
<body data-page="<?php echo $currentPage; ?>" onload="return printValue(0);">
	<?php require_once 'includes/nav_defalut.inc.php'; ?>
	<?php require_once 'includes/nav_menu.inc.php'; ?>
	<div class="container">
		<blockquote class="blockquote text-center">
			<p class="mb-0">การสั่งอาหารออนไลน์จะ แสดงทั้งหมดและแยกประเภท</p>
			<footer class="blockquote-footer">ไม่เกี่ยวกับการ <cite title="Source Title">เลือกประเภท</cite> ในหน้านี้</footer>
		</blockquote>
		<div class="g1">
			<div id="printDiv"></div>
		</div>
	</div>
	<script>
		function removeQR(table){
			$('#qrDiv').removeClass('col');
			$('#bst'+table).removeClass('active');
			$('#qrDiv').hide();
		}
	</script>
</body>
</html>