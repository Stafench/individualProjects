<?php

require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql ="SELECT `users`.`id_user`, CONCAT(`users`.`lastname`,' ', `users`.`firstname`, ' ', `users`.`middlename`, ' ') as full_name FROM `users`
WHERE `users`.`role_id` = '3' ORDER BY `users`.`login` ASC";

$teachers = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($teachers);