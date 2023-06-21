<?php
require_once "../connect.php";
require_once "../functions.php";
session_start();
if(!($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2))
header("Location: ../../index.php");

$sql = "INSERT INTO `number_of_students` (`teacher_id`, `numbers_of`)
VALUES (:id, :numbers)
ON DUPLICATE KEY UPDATE `numbers_of` = :numbers";
$stmt = $connect->prepare($sql);
$stmt->bindValue(":id", $_POST['id'],pdo::PARAM_INT);
$stmt->bindValue(":numbers", $_POST['numbers'],pdo::PARAM_INT);
$stmt->execute();
header("Location:load_distribution.php");