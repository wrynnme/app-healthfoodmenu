<?php
if (isset($_SESSION['edit_food'])) {
	$foods = new foodsview();
	$food = $foods->getId($_SESSION['edit_food']);
	?>
	<ul class="nav justify-content-center bg-warning" style="margin: 0;">
		<li class="nav-item">
			<span>คุณกำลังแก้ไขเมนูอาหาร</span> <a href="foods_edit.php?id=<?=$_SESSION['edit_food']?>" class="text-dark"><?php echo $food['mf_name'] ?></a> <a href="includes/delete_session.inc.php?s=edit_food" class="text-danger">ยกเลิก</a>
		</li>
	</ul>
<?php } ?>
<nav class="navbar navbar-dark bg-nav navbar-expand-lg justify-content-between">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-nav">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse dual-nav w-50 order-1 order-lg-0">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						อาหาร
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-1">
						<?php if (!empty($_SESSION['edit_food'])) { ?>
							<a class="dropdown-item" href="foods_edit.php?mf_id=<?=$_SESSION['edit_menu']?>">จัดการเมนูอาหาร</a>
						<?php }else{ ?>
							<a class="dropdown-item" href="foods_list.php">จัดการเมนูอาหาร</a>
						<?php } ?>
						<div class="dropdown-divider"></div>
						<h6 class="dropdown-header">สำหรับสร้างเมนู</h6>
						<a class="dropdown-item" href="products_list.php">วัตถุดิบอาหาร</a>
						<a class="dropdown-item" href="foods_add.php">วัตถุดิบที่เลือก</a>
						<div class="dropdown-divider"></div>
						<h6 class="dropdown-header">สำหรับประเภทของอาหาร</h6>
						<a class="dropdown-item" href="type_list.php">จัดการประเภท</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						พิมพ์
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-2">
						<a class="dropdown-item" href="menus.php">พิมพ์รายการอาหาร</a>
						<a class="dropdown-item" href="foods.php">พิมพ์อาหาร</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="orders_list.php">รายการสั่งอาหาร</a>
				</li>
			</ul>
		</div>
		<a href="./" class="navbar-brand mx-auto d-block text-center order-0 order-lg-1 w-25">
			<img class="nav-logo-wide" src="dist/img/HFM/logo_transparent_2.png" alt="Health Food Menu">
		</a>
		<div class="navbar-collapse collapse dual-nav w-50 order-2">
			<ul class="navbar-nav ml-auto nav-flex-icons">
				<?php if ($_SESSION['cus_permission'] == '0') { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							สำหรับผู้ดูแล
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-3">
							<a class="dropdown-item" href="users_list.php"><font color="red">จัดการสมาชิก</font></a>
							<div class="dropdown-divider"></div>
							<h6 class="dropdown-header">สำหรับวัตถุดิบอาหาร</h6>
							<a class="dropdown-item" href="ingredients_list.php">จัดการวัตถุดิบ</a>
							<a class="dropdown-item" href="ingredients_add.php">เพิ่มวัตถุดิบ</a>
						</div>
					</li>
				<?php }	?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $_SESSION['cus_fname']." ".$_SESSION['cus_lname'] ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-4">
						<a class="dropdown-item" href="users_edit.php">แก้ไขข้อมูลส่วนตัว</a>
						<a class="dropdown-item" data-toggle="modal" data-target="#LogoutModal" href="#"> ออกจากระบบ <i class="fad fa-sign-out"></i></a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<br>


<!------------------------------ Modal Session ------------------------------>
<div id="LogoutModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">ออกจากระบบ ?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<h1 style="font-size:5.5rem;"><i class="fa fa-sign-out text-danger" aria-hidden="true"></i></h1>
				<p>ยืนยันการออกจากระบบ</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
				<a href="includes/logout.inc.php" class="btn btn-danger">ออกจากระบบ</a>
			</div>
		</div>
	</div>
</div>

<button onclick="topFunction()" class="btn btn-warning animated fadeInUp" id="myTop" title="Go to top"><i class="fad fa-angle-double-up animated fadeInUp delay-1s infinite slow"></i></button>
<script>
	//Get the button
	var mybutton = document.getElementById("myTop");

	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			mybutton.style.display = "block";
		} else {
			mybutton.style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
</script>