<?php
require_once "../../../connect.php";
$sql = "DELETE FROM `users` WHERE `login` = '' AND `password` = ''  AND `lastname` = '' AND `firstname` = '' AND `middlename` = ''";
$connect->exec($sql);
?>