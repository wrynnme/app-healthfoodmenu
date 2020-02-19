<?php require_once 'includes/class-autoload.inc.php'; ?>
<?php require_once 'includes/check_unlogin.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />
	
	<link rel="manifest" href="manifest.json">
	<link rel='icon' href='dist/img/HFM/favicon.ico' type='image/x-icon'/ >
	
	<title>Health Food Menu | Web Application for Healthy Food Menu of Store Management by WN Dev.</title>

	<link rel="stylesheet" href="dist/icon/css/all.css"/>

	<link rel="stylesheet" href="dist/css/be.css">
	<link rel="stylesheet" href="dist/css/print.css">
	
	<script src="dist/icon/js/all.js"></script>
	<script src="node_modules/jquery/dist/jquery.min.js"></script>

	<style>
		#dpi{
			height: 1in;
			width: 1in;
			position: absolute;
			left: -100%;
			top: -100%;
		}
	</style>

</head>
<body>
	<div class="sideMenu">
		<button onclick="myPrint()">Click</button>
		<hr>
		<input type="color" name="logopage" id="logopage" value="#f0f0f0">
		<input type="number" name="padding_logopage" id="padding_logopage" placeholder="10mm" min="0" max="100" maxlength="3">
		<hr>
	</div>
	<div class="info">
	</div>
	<div class="book">
		<div class="page p-0" data-page="0">
			<div class="logopage">
				<div class="logo">
					<img src="dist/img/HFM/logo_transparent_2.png" alt="">
				</div>

			</div>
		</div>
		<div class="page p-0" data-page="1">
			<div class="sp_page p-0">
				<div class="text-center">
					<h1>Special Menu</h1>
				</div>
				<div class="img">a</div>
			</div>
		</div>
		<div id='dpi'></div>
		<script>
			function myPrint() {
				$('.sideMenu').hide();
				$('.info').hide();
				window.print();
				$('.sideMenu').show();
				$('.info').show();
			}

			function getDPI(){
				return jQuery('#dpi').height();
			}

			function px2mm(inPx) {
				var px = parseFloat(inPx);
				var mm = (px * 25.4) / getDPI();
				return mm;
			}

			$('#logopage').on('change', function(e) {
				$('.logopage').css('background', $('#logopage').val());
				$('.sp_page').css('border-color', $('#logopage').val());

			});

			$('#padding_logopage').on('change', function(e) {
				let mm = $('#padding_logopage').val();
				if (mm > 100) {
					alert(mm + ' more than 100 ' );
				} else {
					$('.logopage').css('padding', mm+'mm');
				}
			});

			$(document).ready(function() {
				var px = $('.logopage').css('padding');
				$('#padding_logopage').val(px2mm(px).toFixed(3));
			});
		</script>

	</body>
	</html>