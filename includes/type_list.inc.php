<?php require_once 'class-autoload.inc.php'; ?>
<?php
@SESSION_START();
$type = $_POST['type'];
$types = new typecontr();
if ($type == 'del') {
	$type_id = $_POST['value'];
	echo $types->del($type_id);
	unset($types);
	exit();
}
if ($type == 'add') {
	$value = $_POST['value'];
	echo $types->add($value);
	unset($types);
	exit();
}
if ($type == 'mod') {
	$type_id = $_POST['id'];
	$value = $_POST['value'];
	echo $types->mod($type_id, $value);
	unset($types);
	exit();
}
unset($types);
?>
