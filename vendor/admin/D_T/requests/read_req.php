<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1) header("Location:../../../index.php");


$sql = "SELECT * FROM `departments` ORDER BY `" . $_POST['nameColumn'] . "` " . $_POST['orderBy']; ;
$groups = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($groups);
?>
