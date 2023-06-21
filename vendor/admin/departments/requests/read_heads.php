<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql ="SELECT `users`.`id_user`, CONCAT(`users`.`lastname`,' ', `users`.`firstname`, ' ', `users`.`middlename`, ' ') as full_name FROM `users`
WHERE `users`.`id_user` NOT IN( SELECT `departments`.`head_id` FROM `departments` WHERE `departments`.`head_id` IS NOT null) AND 
`users`.`role_id` = '2' ORDER BY `users`.`login` ASC";

$heads = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($heads);