<?php
function checkRoleHeadOfDep(){
require "connect.php";
$login = $_SESSION['user'];
$check_user = $connect->query("Select `roles`.`id_role` = 2 as result FROM `users` INNER JOIN `roles` on `users`.`role_id` = `roles`.`id_role` WHERE `users`.`login` = '$login'");
$check_user = $check_user->fetchAll();
if(!$check_user[0]['result'])
header("Location: ../../index.php");
}