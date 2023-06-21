<?php
require_once "../../../connect.php";

$stmt = $connect->prepare("INSERT INTO `users`(
    `login`,
    `password`,
    `lastname`,
    `firstname`,
    `middlename`,
    `role_id`
)
VALUES(
    :login,
    :password,
    :lastname,
    :firstname,
    :middlename,
    :role
)");
$stmt->bindValue(":login", $_POST['login'], PDO::PARAM_STR);
$stmt->bindValue(":password", $_POST['password'], PDO::PARAM_STR);
$stmt->bindValue(":lastname", $_POST['lastname'], PDO::PARAM_STR);
$stmt->bindValue(":firstname", $_POST['firstname'], PDO::PARAM_STR);
$stmt->bindValue(":middlename", $_POST['middlename'], PDO::PARAM_STR);
$stmt->bindValue(":role", $_POST['role'], PDO::PARAM_STR);
$stmt->execute();
$id_student = $connect->query("SELECT LAST_INSERT_ID() as id_student")->fetchColumn();
echo json_encode($id_student); 
