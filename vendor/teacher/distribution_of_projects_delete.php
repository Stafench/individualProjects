<?php
require_once "../connect.php";
$id_project = $_POST['id_project'];
$connect->exec("DELETE FROM `projects` WHERE `projects`.`id_project` = '$id_project'");
header("Location: distribution_of_projects.php");