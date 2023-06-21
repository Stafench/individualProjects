<?php
require_once "../../../connect.php";

$stmt = $connect->prepare("INSERT INTO `departments`(
    `name`
)
VALUES(
    :department_name
)");
$stmt->bindValue(":department_name", $_POST['name'], PDO::PARAM_STR);
$stmt->execute();
$id_department = $connect->query("SELECT LAST_INSERT_ID() as id_department")->fetchColumn();
echo json_encode($id_department); 
