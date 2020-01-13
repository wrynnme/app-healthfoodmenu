<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
$cus_id = $_SESSION['cus_id'];
if (isset($_POST['where'])) {
	if ($_POST['where'] == 'order') {
		$orders = new ordersview();
		$data = $orders->recent($cus_id, '0', '1');
		for ($i = 0; $i < sizeof($data); $i++) {
			$date = date_create($data[$i]['or_time']);
			$cus = $data[$i]['cus_id'];
			$or = $data[$i]['or_id'];
			echo "<a href='orders_detail.php?id=$or'>";
			echo 'การสั่งที่ : <u>'.$data[$i]['or_id'].'</u> โต๊ะที่ : <u>'.$data[$i]['or_table'].'</u> เวลา : <u>'.date_format($date, "H:i:s").'</u>';
			echo '</a>';
			echo '<hr>';
		}
		unset($orders);
	}
	if ($_POST['where'] == 'checkbill') {
		$orders = new ordersview();
		$data = $orders->recent($cus_id, '1', '1');
		for ($i = 0; $i < sizeof($data); $i++) {
			$date = date_create($data[$i]['or_time_newStatus']);
			$cus = $data[$i]['cus_id'];
			$or = $data[$i]['or_id'];
			echo "<a href='orders_detail.php?id=$or'>";
			echo 'การสั่งที่ : <u>'.$data[$i]['or_id'].'</u> โต๊ะที่ : <u>'.$data[$i]['or_table'].'</u> เวลา : <u>'.date_format($date, "H:i:s").'</u>';
			echo '</a>';
			echo '<hr>';
		}
		unset($orders);
	}
	if ($_POST['where'] == 'menu') {
		$foods = new foodsview();
		$data = $foods->recent($cus_id, '1');
		for ($i = 0; $i < sizeof($data); $i++) {
			$id = $data[$i]['mf_id'];
			echo "<a href='foods.php?id=$id'>";
			echo 'ชื่อ : <u>'.$data[$i]['mf_name'].'</u> แคลอรี่ : <u>'.$data[$i]['mf_kcal'].'</u> ราคา : <u>'.$data[$i]['mf_price'].'</u>';
			echo '</a>';
			echo '<hr>';
		}
		unset($foods);
	}
	if ($_POST['where'] == 'login' && $_SESSION['cus_permission'] == '0') {
		$users = new usersview();
		$data = $users->recentLogin();
		for ($i = 0; $i < sizeof($data); $i++) {
			$cus_id = $data[$i]['cus_id'];
			$date = date_create($data[$i]['cus_login_time']);
			echo "<a href='users_edit.php?id=$cus_id'>";
			echo 'ID : <u>'.$data[$i]['cus_id'].'</u> ชื่อ : <u>'.$data[$i]['cus_fname'].' '.$data[$i]['cus_lname'].'</u> ชื่อร้าน : <u>'.$data[$i]['cus_res_name'].'</u> เข้าสู่ระบบเมื่อ : <u>'.date_format($date, 'd/m/y H:i:s').'</u>';
			echo "</a>";
			echo "<br>";
		}
		
	}
	if ($_POST['where'] == 'customer' && $_SESSION['cus_permission'] == '0') {
		$users = new usersview();
		$data = $users->recentCustomer();
		for ($i = 0; $i < sizeof($data); $i++) {
			$cus_id = $data[$i]['cus_id'];
			$date = date_create($data[$i]['cus_regis_date']);
			echo "<a href='users_edit.php?id=$cus_id'>";
			echo 'ID : <u>'.$data[$i]['cus_id'].'</u> ชื่อ : <u>'.$data[$i]['cus_fname'].' '.$data[$i]['cus_lname'].'</u> ชื่อร้าน : <u>'.$data[$i]['cus_res_name'].'</u> สมัครเมื่อ : <u>'.date_format($date, 'd/m/y H:i:s').'</u>';
			echo "</a>";
			echo "<br>";
		}
	}
	if ($_POST['where'] == 'ingt' && $_SESSION['cus_permission'] == '0') {
		$ings = new ingredientsview();
		$data = $ings->recent();
		for ($i = 0; $i < sizeof($data); $i++) {
			$ingt_id = $data[$i]['ing_type'];
			$type = $ings->idType($ingt_id);
			$date = date_create($data[$i]['ing_time']);
			$ing_id = $data[$i]['ing_id'];
			echo "<a href='ingredients_edit.php?id=$ing_id'>";
			echo 'ID : <u>'.$data[$i]['ing_id'].'</u> ชื่อ : <u>'.$data[$i]['ing_name'].'</u> แคลอรี่ : <u>'.$data[$i]['ing_kcal'].'</u> : <u>'.$data[$i]['ing_unit'].'</u> กรัม'.' ประเภท : <u>'.$type['ingt_name'].'</u> เพิ่มเมื่อ : <u>'.date_format($date, 'd/m/y H:i:s').'</u>';
			echo "</a>";
			echo "<br>";		    
		}
	}
}
?>