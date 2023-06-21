<?php
require_once "../../../connect.php";
$sql = "DELETE FROM `objects` WHERE `name` = ''";
$connect->exec($sql);
?>