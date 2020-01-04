<?php
SESSION_START();
(empty($_SESSION['cus_id']))?header('Location: login.php'):NULL;

function checkAdmin() {
	((string)$_SESSION['cus_permission'] == '1')?header('Location: login.php'):NULL;
}
?>