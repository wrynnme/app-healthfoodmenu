<?php if (!isset($_SESSION['res_name'])) {
	exit();
} ?>
<?php @session_start(); ?>
<nav class="navbar navbar-expand-md navbar-light bg-light b-navshadow">
	<div class="d-flex w-50 order-0">
		<a class="navbar-brand mr-1" href="#"><?php echo $_SESSION['res_name'];?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
	</div>
	<div class="navbar-collapse collapse justify-content-center order-2" id="collapsingNavbar">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="orders.php?s=<?php echo $_SESSION['order_encode'];?>">สั่งอาหาร <span class="sr-only">Home</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="orders_history.php">ประวัติการสั่งอาหาร</a>
			</li>
		</ul>
	</div>
	<!-- <span class="navbar-text small text-truncate mt-1 w-50 text-right order-1 order-md-last">always show</span> -->
</nav>