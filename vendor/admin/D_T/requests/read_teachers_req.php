<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");
if($_POST['unselected'] == 'false')
$sql = "SELECT `users`.`id_user`, concat(`users`.`lastname`,' ',`users`.`firstname`, ' ',`users`.`middlename`) AS full_name, `department_teachers`.`department_id` = '". $_POST['departmentID'] ."' AS have FROM `users`
LEFT JOIN `department_teachers` ON `users`.`id_user` = `department_teachers`.`teacher_id`
WHERE `users`.`role_id` = '3'  ORDER BY full_name " . $_POST['orderBy'];
else
$sql = "SELECT `users`.`id_user`, concat(`users`.`lastname`,' ',`users`.`firstname`, ' ',`users`.`middlename`) AS full_name FROM `users`
WHERE `users`.`role_id` = '3' AND `users`.`id_user` NOT IN (SELECT `department_teachers`.`teacher_id` FROM `department_teachers`) ORDER BY full_name " . $_POST['orderBy'];
$teachers = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($teachers);
?>
