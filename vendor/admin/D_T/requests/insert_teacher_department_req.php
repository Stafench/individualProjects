<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql = "INSERT INTO `department_teachers`(`department_id`, `teacher_id`) VALUES ('". $_POST['departmentID'] ."', '". $_POST['teacherID'] ."')";
$result = $connect->exec($sql);
?>
