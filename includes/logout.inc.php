<?php require_once 'class-autoload.inc.php'; ?>
<?php
$logout = new UsersContr();
$logout->change('cus_login', '0', $_SESSION['cus_id']);
unset($logout);
session_destroy();
header("Location: ../");
?>