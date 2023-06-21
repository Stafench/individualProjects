<?php
require_once "../../../connect.php";
$id_student = $_POST['id_student'];
$sql = "DELETE
FROM
    `users`
WHERE
    `id_user` = '$id_student' AND `users`.`role_id`= '". $_POST['role'] ."'";
echo 'Количество строк: ' . $connect->exec($sql);