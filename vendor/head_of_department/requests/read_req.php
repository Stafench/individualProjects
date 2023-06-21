<?php
require_once "../../connect.php";
session_start();
$id_user = $_SESSION['user']['id'];
$result = $connect->query("SELECT
`users`.`id_user`,
CONCAT(
    `users`.`lastname`,
    ' ',
    `users`.`firstname`,
    ' ',
    `users`.`middlename`
) AS full_name,
`number_of_students`.`numbers_of`
FROM
`users`
INNER JOIN `department_teachers` ON `department_teachers`.`teacher_id` = `users`.`id_user`
LEFT JOIN `number_of_students` ON `number_of_students`.`teacher_id` = `department_teachers`.`teacher_id`
WHERE
`users`.`role_id` = '3' AND `department_teachers`.`department_id` =(
SELECT
    `departments`.`id_department`
FROM
    `departments`
INNER JOIN `users` ON `departments`.`head_id` = `users`.`id_user`
WHERE
    `users`.`id_user` = '$id_user'
)");
$result = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
