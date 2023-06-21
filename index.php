<?php
session_start();
if(!isset($_SESSION['user']))
header("Location:vendor/signin_front.php");
require_once "vendor/connect.php";
$id_user = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/styles/style_index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Личный кабинет</title>
</head>
<body>
    <div class="login">Вы вошли как: <?= $_SESSION['user']['login']?></div>
    <form action="vendor/signout.php" method="post">
    <button type="submit" class="btn btn-danger exit">Выход</button>
    </form>
    <div id="listButtons" class="list-group-groups list-group container d-flex justify-content-center align-items-center container">
        <button type="button" class="active disabled list-group-item list-groups list-group-item-action" id="addUser" aria-current="true">
        Что вы хотите сделать?
        </button>
    <?php if($_SESSION['user']['role'] == 2):?>
    <button type="button" class="list-group-item list-groups list-group-item-action" id="loadDis" aria-current="true">
        Распледелить нагрузку между предподавателями
        </button>
    <?php endif;?>
    <?php if($_SESSION['user']['role'] == 3):?>
    <button type="button" class="list-group-item list-groups list-group-item-action" id="disOFp" aria-current="true">
        Распледелить проекты между студентами
        </button>
    <?php endif;?>
    <?php if($_SESSION['user']['role'] == 4):?>
    <button type="button" class="list-group-item list-groups list-group-item-action" id="createResultDoc" aria-current="true">
    Сформировать приказ
        </button>
    <?php endif;?>

    <?php if($_SESSION['user']['role'] == 1):?>
       
        

        <button type="button" class="list-group-item list-groups list-group-item-action" id="addObject" aria-current="true">
        Добавить учебные дисциплины
        </button>
        <button type="button" class="list-group-item list-groups list-group-item-action" id="addUser" aria-current="true">
        Добавить пользователя
        </button>
        <button type="button" class="list-group-item list-groups list-group-item-action" id="addGroup" aria-current="true">
        Добавить группы
        </button>

        <button type="button" class="list-group-item list-groups list-group-item-action" id="addCafedra" aria-current="true">
        Добавить кафедру
        </button>

        <button type="button" class="list-group-item list-groups list-group-item-action" id="addSG" aria-current="true">
        Распределить студентов по группам
        </button>

        <button type="button" class="list-group-item list-groups list-group-item-action" id="addTD" aria-current="true">
        Распределить учителей по кафедрам
        </button>

      </div>
                
    <?php endif;?>

    <?php
    if($_SESSION['user']['role'] == 5):
    $sql = "SELECT
    CONCAT(
        `users`.`lastname`,
        ' ',
        `users`.`firstname`,
        ' ',
        `users`.`middlename`
    ) as full_name_teacher,
    `objects`.`name` as name_object,
    `projects`.`topic` as topic,
    `projects`.`grade` as grade
    FROM
    `projects`
    INNER JOIN `users` ON `projects`.`teacher_id` = `users`.`id_user`
    INNER JOIN `objects` ON `projects`.`object_id` = `objects`.`id_object`
    WHERE
    `projects`.`student_id` = '$id_user'";
    $project = $connect->query($sql);
    $count_row = $project->rowCount();
    if($count_row != 0):
    $project = $connect->query($sql);
    $project = $project->fetchAll()[0];
    ?>
    <table>
        <tr>
            <td colspan="4" style="text-align: center;"><strong>Ваш проект:</strong></td>
        </tr>
        <tr>
            <th>Преподаватель</th>
            <th>Дисциплина</th>
            <th>Тема проекта</th>
            <th>Оценка</th>
        </tr>
        <tr>
            <td><?= $project['full_name_teacher']?></td>
            <td><?= $project['name_object']?></td>
            <td><?= $project['topic']?></td>
            <td>
                <?php
                if($project['grade'] == null) echo "Нет оценки";
                else echo $project['grade'];
                ?>
            </td>
        </tr>
    </table>
    <?php
    endif;
    endif;
    ?>
    <?php
    if(isset($count_row) && $count_row == 0) echo '<div class="no-project-message">У вас не назначен проект.</div>';
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</html>
<script>
    $('#addUser').click(function(){
        window.location.href = "vendor/admin/users/choose_table.html";
    })
    $(document).on('click', '#addUser', function(){
        window.location.href = "vendor/admin/users/choose_table.html";
    })
    $('#addObject').click(function(){
        window.location.href = "vendor/admin/objects/table_objects.html";
    })
    $('#addGroup').click(function(){
        window.location.href = "vendor/admin/groups/table_groups.html";
    })
    $('#addCafedra').click(function(){
        window.location.href = "vendor/admin/departments/table_departments.html";
    })
    $('#addSG').click(function(){
        window.location.href = "vendor/admin/S_G/front_table_S_G.html";
    })
    $('#loadDis').click(function(){
        window.location.href = "vendor/head_of_department/load_distribution.php";
    })
    $('#disOFp').click(function(){
        window.location.href = "vendor/teacher/distribution_of_projects.php";
    })
    $('#createResultDoc').click(function(){
        window.location.href = "vendor/methodologist/output.php";
    })
    $('#addTD').click(function(){
        window.location.href = "vendor/admin/D_T/front_table_D_T.html";
    })
    $('#addTD').click(function(){
        window.location.href = "vendor/admin/D_T/front_table_D_T.html";
    })

</script>

