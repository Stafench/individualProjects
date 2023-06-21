<?php
require_once "../connect.php";
session_start();
$login = $_SESSION['user']['login'];
$id_student = $_POST['select_student'];
if($id_student != $_POST['old_student']){
$exist_student = $connect->query("SELECT EXISTS (SELECT * FROM projects WHERE `student_id` = '$id_student')");
$exist_student = $exist_student->fetchColumn();
 if($exist_student){
     $_SESSION['err_student_alredy_exist'] = 'У этого студента уже назначен проект';
    header("Location: distribution_of_projects.php");
    die("конец");
 }}
$sql = "UPDATE
`projects`
SET
`object_id` = :object_id,
`student_id` = :student_id,
`topic` = :topic,
`grade` = :grade
WHERE
`projects`.`id_project` = :id_project";
$stmt = $connect->prepare($sql);
$stmt->bindValue(":object_id", $_POST['select_object'],pdo::PARAM_INT);
$stmt->bindValue(":student_id", $_POST['select_student'],pdo::PARAM_INT);
$stmt->bindValue(":topic", $_POST['topic'],pdo::PARAM_STR);
$stmt->bindValue(":grade", $_POST['grade'],pdo::PARAM_INT);
$stmt->bindValue(":id_project", $_POST['id_project'],pdo::PARAM_INT);
$stmt->execute();
header("Location: distribution_of_projects.php");