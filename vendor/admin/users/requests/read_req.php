<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1){
    die("Недостаточно прав");
} 


$sql = "SELECT
`users`.`id_user`,
`users`.`login`,
`users`.`password`,
`users`.`lastname`,
`users`.`firstname`,
`users`.`middlename`
FROM
`users`
WHERE
`users`.`role_id` = '". $_POST['user_role'] . "'
ORDER BY `". $_POST['nameColumn'] ."` " . $_POST['orderBy'];
$students = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($students);