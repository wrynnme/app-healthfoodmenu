<?php
$txt = $_POST['cus_id']."&".$_POST['table'];
$encode = base64_encode(base64_encode($txt));
$host = stristr(stristr($_SERVER['REQUEST_URI'] , strrchr($_SERVER['REQUEST_URI'] ,'/'), true), strrchr(stristr($_SERVER['REQUEST_URI'] , strrchr($_SERVER['REQUEST_URI'] ,'/'), true) ,'/'), true);
$link = 'https://'.$_SERVER['HTTP_HOST'].$host.'/orders.php?s='.$encode;
$qr = 'http://api.qrserver.com/v1/create-qr-code/?data='.$link.'&size=150x150';
$code = '<center><img src="'.$qr.'"  onclick="removeQR('.$_POST['table'].');"></center>';
echo $code;
?>