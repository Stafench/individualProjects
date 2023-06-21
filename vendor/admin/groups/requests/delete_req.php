<?php
require_once "../../../connect.php";
$id_group = $_POST['id_group'];
$sql = "DELETE
FROM
    `groups`
WHERE
    `id_group` = '$id_group'";
echo 'Количество строк: ' . $connect->exec($sql);