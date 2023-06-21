<?php
require_once "../../connect.php";

$stmt = $connect->prepare("INSERT INTO `teachers_objects`(`teacher_id`, `object_id`)
VALUES(:teacher_id, :object_id)");
$stmt->bindValue(":teacher_id", $_POST['id_teacher'], pdo::PARAM_INT);
$stmt->bindValue(":object_id", $_POST['select_object_add'], pdo::PARAM_INT);
$stmt->execute();
header("Location: front_table_T_O.php");