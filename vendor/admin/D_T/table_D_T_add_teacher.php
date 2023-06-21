 <?php
require_once "../../connect.php";

$stmt = $connect->prepare("INSERT INTO `department_teachers`(`department_id`, `teacher_id`)
VALUES(:department_id, :teacher_id)");
$stmt->bindValue(":department_id", $_POST['id_department'], pdo::PARAM_INT);
$stmt->bindValue(":teacher_id", $_POST['select_teacher_add'], pdo::PARAM_INT);
$stmt->execute();
header("Location: front_table_D_T.php");