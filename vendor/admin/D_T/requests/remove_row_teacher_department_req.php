<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql = "DELETE FROM `department_teachers` WHERE `teacher_id` = '". $_POST['teacherID'] ."'";
$result = $connect->exec($sql);
?>
