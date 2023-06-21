<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql = "SELECT COUNT(*) AS count FROM `student_groups` WHERE `student_id` = '". $_POST['studentID'] ."'";
$students = $connect->query($sql)->fetchColumn();

echo json_encode($students);
?>
