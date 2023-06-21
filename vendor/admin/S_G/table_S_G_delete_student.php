<?php
require_once "../../connect.php";
$id_group = $_POST['id_group'];
$id_student = $_POST['select_student_delete'];
$sql = "DELETE
FROM
    `student_groups`
WHERE
    `group_id` = '$id_group' AND `student_id` = '$id_student'";
$connect->exec($sql);
header("Location:front_table_S_G.php");