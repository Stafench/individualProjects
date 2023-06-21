<?php
require_once "../../../connect.php";
$id_department = $_POST['id_department'];
$sql = "DELETE
FROM
    `departments`
WHERE
    `id_department` = '$id_department'";
echo 'Количество строк: ' . $connect->exec($sql);