<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");

$sql = "SELECT `departments`.*, CONCAT(`users`.`lastname`,' ', `users`.`firstname`, ' ', `users`.`middlename`) as full_name FROM `departments`
LEFT JOIN `users` ON `departments`.`head_id` = `users`.`id_user`
ORDER BY `" . $_POST['nameColumn'] . "` " . $_POST['orderBy'];
$departments = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($departments);
?>
