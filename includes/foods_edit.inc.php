<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
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
			$foodsc = new foodscontr();
			$foodsv = new foodsview();
			$ings = new ingredientsview();
			($edit = $foodsc->edit('mf_name', $f_name, $eid))? NULL : exit();
			($edit = $foodsc->edit('mf_price', $f_price, $eid))? NULL : exit();
			($edit = $foodsc->edit('mf_kcal', $f_kcal, $eid))? NULL : exit();
			($edit = $foodsc->edit('type_id', $type_id, $eid))? NULL : exit();

			if ($edit) {
				$old_line = 0;
				for ($l = 0; $l < sizeof($ingtDB); $l++) {
					$tableDB = $ingtDB[$l+1];
					$fv = $foodsv->getDetail($tableDB, $eid);
					
					for ($i = 0; $i < sizeof($fv); $i++){
						$_SESSION['old_ingt'][$old_line] = $fv[$i][2];
						$_SESSION['old_gram'][$old_line] = $fv[$i][3];
						$_SESSION['old_allcal'][$old_line] = $fv[$i][4];
						$old_line++;
					}
				}
				for ($o = 0; $o < sizeof($_SESSION['old_ingt']) ; $o++) { 
					$k = array_search($_SESSION['old_ingt'][$o], $_SESSION['pro_id']); // old check new
					if ((string)$k == "") {
						$pp = $_SESSION['old_ingt'][$o];
						$ing = $ings->id($pp);
						$fdb_T = $ingtDB[$ing['ing_type']];
						$del_ingr = $foods->del($fdb_t, $eid, $pp);
						if (!$del_ingr) {
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
						$fdb = $ings->id($pp);
						$fdb_T = $ingtDB[$fdb['ing_type']];
						$attr_T = $attrDB[$fdb['ing_type']];

						$qre = $foodsc->edit_ingt($fdb_T, $attr_T."_gram" , $gg, $eid, $pp);
						$qre = $foodsc->edit_ingt($fdb_T, $attr_T."_kcal" , $al, $eid, $pp);;
						if (!$qre) {
							echo 'add';
							exit;
						}
					}else{
						if (empty($_SESSION['pro_id'][$o])) {
							$pp = $_SESSION['pro_id'][$o];
						}else{
							$pp = $_SESSION['pro_id'][$o];
							$gg = $_SESSION['gram'][$o];
							$al = $_SESSION['allcal'][$o];

							$fdb = $ings->id($pp);
							$fdb_T = $ingtDB[$fdb['ing_type']];
							$attr_T = $attrDB[$fdb['ing_type']];

							$qre = $foodsc->add_ingt($fdb_T ,$eid, $pp, $gg, $al);
							if (!$qre) {
								sc("ไม่สามารถเพิ่มข้อมูล $pp ได้");
							}
						}
					}
				}
				unset($_SESSION['intLine']);
				unset($_SESSION['pro_id']);
				unset($_SESSION['gram']);
				unset($_SESSION['allcal']);
				unset($_SESSION['food_name']);
				unset($_SESSION['food_price']);
				unset($_SESSION['type_id']);
				unset($_SESSION['edit_food']);
				unset($_SESSION['currentSize']);
				unset($_SESSION['old_ingt']);
				unset($_SESSION['old_gram']);
				unset($_SESSION['old_allcal']);
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