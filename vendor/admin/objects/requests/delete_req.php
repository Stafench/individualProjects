<?php
require_once "../../../connect.php";
$id_object = $_POST['id_object'];
$sql = "DELETE
FROM
    `objects`
WHERE
    `id_object` = '$id_object'";
echo 'Количество строк: ' . $connect->exec($sql);