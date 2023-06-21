<?php
require_once "../../../connect.php";
$sql = "DELETE FROM `groups` WHERE `name` = ''";
$connect->exec($sql);
?>