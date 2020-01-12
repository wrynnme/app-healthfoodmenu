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

</head>
<body>
	<div class="sideMenu">
		<button onclick="myFunction()">Click</button>
	</div>
	<div class="info">
		
	</div>
	<div class="book">
		<div class="page">
			<div class="subpage">
				Page 1/2

			</div>
		</div>
		<div class="page">
			<div class="subpage">
				Page 2/2
				

			</div>
		</div>
	</div>
	<script>
		function myFunction() {
			$('.sideMenu').hide();
			$('.info').hide();
			window.print();
			$('.sideMenu').show();
			$('.info').show();

		}
	</script>

</body>
</html>