<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();

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
			$fv = $foodsv->getDetail($eid);
			if ($edit) {
				$old_line = 0;
				for ($i = 0; $i < sizeof($fv); $i++) {
					$_SESSION['old_ingt'][$old_line] = $fv[$i]['ing_id'];
					$_SESSION['old_gram'][$old_line] = $fv[$i]['gram'];
					$_SESSION['old_allcal'][$old_line] = $fv[$i]['kcal'];
					$old_line++;
				}
				for ($o = 0; $o < sizeof($_SESSION['old_ingt']) ; $o++) { 
					$k = array_search($_SESSION['old_ingt'][$o], $_SESSION['pro_id']); // old check new
					if ((string)$k == "") {
						$pp = $_SESSION['old_ingt'][$o];
						$ing = $ings->id($pp);
						$del_ingr = $foodsc->del($eid, $pp);
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
						$qre = $foodsc->edit_ingt("gram" , $gg, $eid, $pp);
						$qre = $foodsc->edit_ingt("kcal" , $al, $eid, $pp);;
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
							$qre = $foodsc->add_ingt($eid, $pp, $gg, $al);
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