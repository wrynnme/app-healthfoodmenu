<?php require_once 'includes/class-autoload.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="dist/css/login.css">
	<?php require_once 'includes/head.inc.php'; ?>
	<style>
		.card{
			display: flex !important;
		}
		.card img {
			width: unset;
			height: unset;
		}
		img {
			width: 100%;
		}
	</style>
</head>
<body>
	<div class="login-box">
		<div class="login-logo">
			<img src="dist/img/HFM/facebook_cover_photo_1.png" alt="">
		</div>
		<div class="card" style="width: unset;">
			<div class="card-body">
				<form action="<?PHP echo $_SERVER['PHP_SELF']?>" method="post" accept-charset="utf-8">
					<div class="alert alert-danger alert-incorrect d-none" role="alert"></div>
					<?php if(isset($_COOKIE["cus_id"])){?>
						<?php foreach($_COOKIE["cus_id"] as $k => $v){?>
							<div title="<?php echo $v;?>" class="text-center card-user-cookie card-user-<?php echo $k;?> formlogin" data-key="<?php echo $k;?>" data-email="<?php echo $v;?>">
								<button type="button" class="close" aria-label="Close" data-toggle="modal" data-target="#deleteModal" data-key="<?php echo $k;?>" data-email="<?php echo $v;?>">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="account_info" data-key="<?php echo $k;?>" data-email="<?php echo $v;?>">
									<img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png" alt="" width="75" class="img-fluid rounded-circle img-thumbnail">
									<?php echo "<p style='font-size:14px;'>".$v."</p>";?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="text-center  formlogin card-user-choose d-none mx-auto">
						<button type="button" class="close" aria-label="Close" style="position: absolute; right: 14px;" data-toggle="modal" data-target="#deleteModal">
							<span aria-hidden="true">&times;</span>
						</button>
						<div class="account_info_choose" style="font-size: 16px;">
							<img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png" alt="" width="75" class="img-fluid rounded-circle img-thumbnail">
						</div>
						<p></p> <span class="small notme text-danger">ไม่ใช่ฉัน ?</span>
					</div>
					<!-- Email -->
					<div class="form-group email">
						<div class="input-group">
							<input type="email" class="form-control login-input" id="email" name="email" placeholder="E-mail" autocomplete="off">
							<div class="input-group-prepend">
								<div class="input-group-text login-input-group-text" id="btnGroupAddon"><span class="fa fa-user"></span>
								</div>
							</div>
						</div>
						<span id="error-email" class="text-danger small"></span>
					</div>
					<!-- Password -->
					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control login-input" id="password" name="password" placeholder="Password" autocomplete="off">
							<div class="input-group-prepend">
								<div class="input-group-text login-input-group-text" id="btnGroupAddon"><span class="fa fa-lock"></span>
								</div>
							</div>
						</div>
						<span id="error-password" class="text-danger small"></span>
					</div>
					<!-- Remember Me? -->
					<div class="form-group">
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="customSwitch1" name="remember" id="remember" value="1">
							<label class="custom-control-label small" for="customSwitch1">จดจำการเข้าสู่ระบบ</label>
						</div>
					</div>
					<!-- Button Login -->
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block btn-login">เข้าสู่ระบบ</button>
						<button class="btn btn-primary btn-block d-none btn-loading" type="button" disabled>
							<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
							กำลังเข้าสู่ระบบ...
						</button>
					</div>
					<div class="text-center">
						<a href="reset_password.php" class="small">ลืมรหัสผ่าน ?</a> | <a href="register.php" class="small">สมัครสมาชิก</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">ลบ ? <span class="account_id"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<h1 style="font-size:5.5rem;"><i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i></h1>
					<p>คุณแน่ใจว่าต้องการลบ ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
					<a href="#" class="btn btn-danger btn-delete">ลบ</a>
				</div>
			</div>
		</div>
	</div>
	<script src="dist/js/login.js"></script>
</body>
</html>