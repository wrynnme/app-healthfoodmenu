<?php
SESSION_START();
(isset($_SESSION['cus_id']))?header('Location: index'):NULL;
?>