<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");
if($_POST['unselected'] == 'false')
$sql = "SELECT `users`.`id_user`, concat(`users`.`lastname`,' ',`users`.`firstname`, ' ',`users`.`middlename`) AS full_name, `student_groups`.`group_id` = '". $_POST['groupID'] ."' AS have FROM `users`
LEFT JOIN `student_groups` ON `users`.`id_user` = `student_groups`.`student_id`
WHERE `users`.`role_id` = '5'  ORDER BY full_name " . $_POST['orderBy'];
else
$sql = "SELECT `users`.`id_user`, concat(`users`.`lastname`,' ',`users`.`firstname`, ' ',`users`.`middlename`) AS full_name FROM `users`
WHERE `users`.`role_id` = '5' AND `users`.`id_user` NOT IN (SELECT `student_groups`.`student_id` FROM `student_groups`) ORDER BY full_name " . $_POST['orderBy'];
$students = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($students);
?>
