<?php
session_start();
if(isset($_SESSION['user']))
header("Location: ../index.php");
require_once "connect.php";


$login = $_POST['login'];
$password = $_POST['password'];


$prepare = $connect->prepare("SELECT EXISTS (SELECT * FROM `users` WHERE `login` = :login AND `password` = :password)");

$prepare->bindValue(':password', $password, pdo::PARAM_STR);
$prepare->bindValue(':login', $login, pdo::PARAM_STR);
$prepare->execute();
$result = $prepare->fetchColumn();
if(!$result){
$_SESSION['error_incorrect_login_or_password'] = true;
header("Location:signin_front.php");
}
else{
    $prepare = $connect->query("SELECT `users`.`role_id`, `users`.`id_user`,`users`.`login` FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    $result = $prepare->fetchAll()[0];
    $_SESSION['user'] = array("login" => $result['login'], "role" => $result['role_id'], "id" => $result['id_user']);

    if($_SESSION['user']['role'] == 2) header("location: head_of_department/load_distribution.html");
    else header("Location: ../index.php");
}
?>