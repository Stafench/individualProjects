<?php
require_once "../connect.php";
session_start();
$id_user = $_SESSION['user']['id'];
$id_student = $_POST['select_student'];
$exist_student = $connect->query("SELECT EXISTS (SELECT * FROM projects WHERE `student_id` = '$id_student')");
$exist_student = $exist_student->fetchColumn();
 if($exist_student){
     $_SESSION['err_student_alredy_exist'] = 'У этого студента уже назначен проект';
    header("Location: distribution_of_projects.php");
    die("конец");
}

$check_limit = $connect->query("SELECT (SELECT COUNT(*) FROM `projects` WHERE `projects`.`teacher_id` = '$id_user') = (SELECT `number_of_students`.`numbers_of` FROM `number_of_students` WHERE `number_of_students`.`teacher_id` = '$id_user')");
$check_limit = $check_limit->fetchColumn();
var_dump($check_limit);
if($check_limit){
    $_SESSION['limit_of_students'] = 'Вы достигли ограничения по кол-ву проектов';
    header("Location: distribution_of_projects.php");
    die("конец");
}
var_dump($check_limit);

$sql = "INSERT INTO `projects`(
    `object_id`,
    `teacher_id`,
    `student_id`,
    `topic`
)
VALUES(
    :object_id,
    :teacher_id,
    :student_id,
    :topic
)";
$stmt = $connect->prepare($sql);
$stmt->bindValue(":object_id", $_POST['select_object'], PDO::PARAM_INT);
$stmt->bindValue(":teacher_id", $_SESSION['user']['id'], PDO::PARAM_INT);
$stmt->bindValue(":student_id", $_POST['select_student'], PDO::PARAM_INT);
$stmt->bindValue(":topic", $_POST['topic'], PDO::PARAM_STR);
$stmt->execute();
header("Location: distribution_of_projects.php");