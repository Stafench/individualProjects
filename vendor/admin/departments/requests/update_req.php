<?php
require_once "../../../connect.php";
$sql = "UPDATE
`departments`
SET
`". $_POST['name'] ."` = :value
WHERE
`id_department` = :id_department";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":value", $_POST['value'], PDO::PARAM_STR);
$stmt->bindValue(":id_department", $_POST['id_department'], PDO::PARAM_INT);
$stmt->execute();
echo "Успех";