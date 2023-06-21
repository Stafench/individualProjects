<?php
require_once "../../../connect.php";
$sql = "DELETE FROM `departments` WHERE `name` = '' AND `head_id` IS NULL";
$connect->exec($sql);
?>