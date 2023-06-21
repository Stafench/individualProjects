<?php
require_once "../../connect.php";
$check_head = $connect->query("SELECT EXISTS( SELECT `departments`.`head_id` FROM `departments` WHERE `departments`.`head_id` = '". $_POST['select_head'] ."' AND `departments`.`id_department` <> '".$_POST['id_department']."')")->fetchColumn();


if($check_head){
    session_start();
    $_SESSION['error_head_alredy_exist'] = "Уже есть кафедра с этим заведующим. Выберите другого.";
    header("Location:front_table_departments.php");
}



$sql = "UPDATE
`departments`
SET
`name` = :department_name,
`head_id` = :head_id
WHERE
`id_department` = :id_department";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":department_name", $_POST['department_name'], PDO::PARAM_STR);
$stmt->bindValue(":head_id", $_POST['select_head'], PDO::PARAM_INT);
$stmt->bindValue(":id_department", $_POST['id_department'], PDO::PARAM_INT);
$stmt->execute();
header("Location: front_table_departments.php");