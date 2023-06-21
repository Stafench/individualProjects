<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql = "INSERT INTO `student_groups`(`student_id`, `group_id`) VALUES ('". $_POST['studentID'] ."','". $_POST['groupID'] ."')";
$students = $connect->exec($sql);
?>
