<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql = "UPDATE `student_groups` SET `group_id`='". $_POST['groupID'] ."' WHERE `student_id`='". $_POST['studentID'] ."'";
$students = $connect->exec($sql);
?>
