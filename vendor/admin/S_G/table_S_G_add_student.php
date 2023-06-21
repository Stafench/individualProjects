 <?php
require_once "../../connect.php";

$stmt = $connect->prepare("INSERT INTO `student_groups`(`group_id`, `student_id`)
VALUES(:group_id, :student_id)");
$stmt->bindValue(":group_id", $_POST['id_group'], pdo::PARAM_INT);
$stmt->bindValue(":student_id", $_POST['select_student_add'], pdo::PARAM_INT);
$stmt->execute();
header("Location: front_table_S_G.php");