<?php
require_once "../../../connect.php";
$sql = "UPDATE
`groups`
SET
`". $_POST['name'] ."` = :group_name
WHERE
`id_group` = :id_group";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":group_name", $_POST['value'], PDO::PARAM_STR);
$stmt->bindValue(":id_group", $_POST['id_group'], PDO::PARAM_INT);
$stmt->execute();
echo "Успех";