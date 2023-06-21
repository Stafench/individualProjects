<?php
require_once "../../../connect.php";
$sql = "UPDATE
`users`
SET
`". $_POST['name'] ."` = :". $_POST['name'] ."
WHERE
`users`.`id_user` = :id_user AND `users`.`role_id`= :role";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":" . $_POST['name'], $_POST['value'], PDO::PARAM_STR);
$stmt->bindValue(":id_user", $_POST['id_user'], PDO::PARAM_INT);
$stmt->bindValue(":role", $_POST['role'], PDO::PARAM_INT);
$stmt->execute();
echo "Успех";