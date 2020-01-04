<?php
@SESSION_START();
if ($_GET['s']) {
	unset($_SESSION[$_GET['s']]);
	echo "<script>window.history.back();</script>";
}