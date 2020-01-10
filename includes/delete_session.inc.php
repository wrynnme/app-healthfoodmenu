<?php
@SESSION_START();
if ($_GET['s']) {
	if ($_GET['s'] == 'edit_food') {
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
	} else {
		unset($_SESSION[$_GET['s']]);
	}
	echo "<script>window.history.back();</script>";
}