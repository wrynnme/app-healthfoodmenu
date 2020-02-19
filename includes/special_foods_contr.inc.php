<?php require_once 'class-autoload.inc.php'; ?>
<?php
if (isset($_GET['add'])) {
    $foods = new foodscontr();
    $x = $foods->add_specical($_SESSION['cus_id'], $_POST['data']);
    if ($x) {
        echo 'true';
    } else {
        echo 'false';
    }
    unset($foods);
}

if (isset($_GET['del'])) {
    $foods = new foodscontr();
    $x = $foods->del_special($_SESSION['cus_id'], $_POST['data']);
    if ($x == '1') {
        echo 'true';
    } else {
        echo 'false';
    }
    unset($foods);
}
?>