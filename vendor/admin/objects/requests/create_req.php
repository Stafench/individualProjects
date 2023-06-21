<?php
require_once "../../../connect.php";

$stmt = $connect->prepare("INSERT INTO `objects`(
    `name`
)
VALUES(
    :object_name
)");
$stmt->bindValue(":object_name", $_POST['name'], PDO::PARAM_STR);
$stmt->execute();
$id_object = $connect->query("SELECT LAST_INSERT_ID() as id_object")->fetchColumn();
echo json_encode($id_object); 
