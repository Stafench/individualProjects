<?php
function exist_student($id_student){
    require "../connect.php";
    $exist_student = $connect->query("SELECT EXISTS (SELECT * FROM projects WHERE `student_id` = '$id_student')");
    if($exist_student){
    return 1;
}
}