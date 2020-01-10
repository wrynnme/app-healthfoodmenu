<?php require_once 'class-autoload.inc.php'; ?>
<?php
$ingtDB = array('1' => 'oils', '2' => 'eggs', '3' => 'seas', '4' => 'meats', '5' => 'vegetables', '6' => 'ran', '7' => 'nas', '8' => 'milks', '9' => 'fruits', '10' => 'garnishs');
$attrDB = array('1' => 'oil', '2' => 'egg', '3' => 'sea', '4' => 'meat', '5' => 'veg', '6' => 'ran', '7' => 'nas', '8' => 'milk', '9' => 'fru', '10' => 'gar');

if (isset($_SESSION['food_name']) && isset($_SESSION['food_price']) && isset($_SESSION['edit_food'])) {
	if (isset($_SESSION['intLine']) && isset($_SESSION['pro_id']) && isset($_SESSION['allcal'])) {
		if (sizeof($_SESSION['pro_id']) == sizeof($_SESSION['gram'])) {
			$eid = $_SESSION['edit_food'];
			$f_name = $_SESSION['food_name'];
			$f_price = $_SESSION['food_price'];
			$f_kcal = array_sum($_SESSION['allcal']);
			$cus_id = $_SESSION['cus_id'];
			$type_id = $_SESSION['type_id'];
			if ($type_id == 0) {
				$q1 = $con->query("UPDATE `menu_foods` SET `mf_name` = '$f_name', `mf_price` = '$f_price', `mf_kcal` = '$f_kcal', `type_id` = NULL WHERE `menu_foods`.`mf_id` = '$eid' "); // Insert Name_Food, Price;
			}else{
				$q1 = $con->query("UPDATE `menu_foods` SET `mf_name` = '$f_name', `mf_price` = '$f_price', `mf_kcal` = '$f_kcal', `type_id` = '$type_id' WHERE `menu_foods`.`mf_id` = '$eid' "); // Insert Name_Food, Price;
			}
			if ($q1) {
				$old_line = 0;
				$c = 0;
				for ($i = 0; $i < sizeof($ingtDB); $i++) {
					$c++;
					$tableDB = $ingtDB[$c];
					$qq = $con->query("SELECT * FROM $tableDB WHERE `mf_id` = '$eid'");
					/*echo nr($qq);
					br();
					echo "SELECT * FROM $tableDB WHERE `mf_id` = '$eid'";
					br();*/
					while($ff = fa($qq)){
						$_SESSION['old_ingt'][$old_line] = $ff[2];
						$_SESSION['old_gram'][$old_line] = $ff[3];
						$_SESSION['old_allcal'][$old_line] = $ff[4];
						$old_line++;
					}
				}
				for ($o = 0; $o < sizeof($_SESSION['old_ingt']) ; $o++) { 
					$k = array_search($_SESSION['old_ingt'][$o], $_SESSION['pro_id']); // old check new
					if ((string)$k == "") {
						$pp = $_SESSION['old_ingt'][$o];
						/*echo @"$o : [$o] => $pp [x] can delete";
						br();*/
						$find_DB = $con->query("SELECT ing_type FROM ingredients WHERE ing_id = '$pp'"); // หา DB
						$fdb = fa($find_DB);
						$fdb_T = $ingtDB[$fdb[0]];
						// echo "DELETE FROM $fdb_T WHERE mf_id = '$eid' AND ing_id = '$pp'";
						// br();
						$qre = $con->query("DELETE FROM $fdb_T WHERE mf_id = '$eid' AND ing_id = '$pp'");
						if (!$qre) {
							// alr("ไม่สามารถลบ $pp ได้");
							echo 'delete';
							exit;
						}
					}
				}
				for ($o = 0; $o < sizeof($_SESSION['pro_id']) ; $o++) { 
					$k = array_search($_SESSION['pro_id'][$o], $_SESSION['old_ingt']); // old check new
					if ((string)$k != "") {
						$pp = $_SESSION['pro_id'][$o];
						$gg = $_SESSION['gram'][$o];
						$al = $_SESSION['allcal'][$o];
						/*echo @"$o : [$o] => $pp [/] can update";
						br();*/
						$find_DB = $con->query("SELECT ing_type FROM ingredients WHERE ing_id = '$pp'"); // หา DB
						$fdb = fa($find_DB);
						$fdb_T = $ingtDB[$fdb[0]];
						$attr_T = $attrDB[$fdb[0]];
						// echo "UPDATE $fdb_T SET ".$attr_T."_gram = '$gg', ".$attr_T."_kcal = '$al' WHERE mf_id = '$eid' AND ing_id = '$pp'";
						$qre = $con->query("UPDATE $fdb_T SET ".$attr_T."_gram = '$gg', ".$attr_T."_kcal = '$al' WHERE mf_id = '$eid' AND ing_id = '$pp'");
						if (!$qre) {
							// alr("ไม่สามารถอัพเดท $pp ได้");
							echo 'add';
							exit;
						}
					}else{
						if (empty($_SESSION['pro_id'][$o])) {
							$pp = $_SESSION['pro_id'][$o];
							// echo @"$o : [$o] => $pp [x] can't insert";
						}else{
							$pp = $_SESSION['pro_id'][$o];
							$gg = $_SESSION['gram'][$o];
							$al = $_SESSION['allcal'][$o];
							/*echo @"$o : [$o] => $pp [x] can insert";
							br();*/
							$find_DB = $con->query("SELECT ing_type FROM ingredients WHERE ing_id = '$pp'"); // หา DB
							$fdb = fa($find_DB);
							$fdb_T = $ingtDB[$fdb[0]];
							$attr_T = $attrDB[$fdb[0]];
							// echo "INSERT INTO $fdb_T VALUES(NULL, '$eid', '$pp', '$gg', '$al')";
							$qre = $con->query("INSERT INTO $fdb_T VALUES(NULL, '$eid', '$pp', '$gg', '$al')");
							if (!$qre) {
								sc("ไม่สามารถเพิ่มข้อมูล $pp ได้");
							}
						}
					}
				}
				uns('edit');
				echo 'success';
				// hd('fmm.php');
			}
		}else{
			echo 'gram';
			// sc("กรุณากรอกจำนวน กรัมของวัตถุดิบ");
		}
	}else{
		echo 'ingt';
		// sc("กรุณาเพิ่ม วัตถุดิบ หรือ กรอกจำนวน กรัมของวัตถุดิบ");
	}
}else{
	echo 'name';
	// sc("กรุณากรอก ชื่อเมนู หรือ ราคาให้เรียบร้อย");
}
?>