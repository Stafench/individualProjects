<?php
require_once "../../../connect.php";
$sql ="UPDATE `departments` SET `head_id`= NULL WHERE `id_department` = :id_department";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":id_department", $_POST['id_department'], PDO::PARAM_INT);
$stmt->execute();
echo "Успех";