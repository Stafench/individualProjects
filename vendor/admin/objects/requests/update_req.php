<?php
require_once "../../../connect.php";
$sql = "UPDATE
`objects`
SET
`". $_POST['name'] ."` = :object_name
WHERE
`id_object` = :id_object";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":object_name", $_POST['value'], PDO::PARAM_STR);
$stmt->bindValue(":id_object", $_POST['id_object'], PDO::PARAM_INT);
$stmt->execute();
echo "Успех";