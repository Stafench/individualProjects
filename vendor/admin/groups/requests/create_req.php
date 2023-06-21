<?php
require_once "../../../connect.php";

$stmt = $connect->prepare("INSERT INTO `groups`(
    `name`
)
VALUES(
    :group_name
)");
$stmt->bindValue(":group_name", $_POST['name'], PDO::PARAM_STR);
$stmt->execute();
$id_group = $connect->query("SELECT LAST_INSERT_ID() as id_group")->fetchColumn();
echo json_encode($id_group); 
