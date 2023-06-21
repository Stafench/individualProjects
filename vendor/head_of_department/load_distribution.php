<?php
require_once "../connect.php";
require_once "../functions.php";
session_start();
if(!($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2))
header("Location: ../../index.php");

$id_user = $_SESSION['user']['id'];
$result = $connect->query("SELECT `users`.`id_user`, CONCAT(`users`.`lastname`, ' ', `users`.`firstname`, ' ', `users`.`middlename`) AS full_name, `number_of_students`.`numbers_of` FROM `users` INNER JOIN `department_teachers` ON `department_teachers`.`teacher_id` = `users`.`id_user` LEFT JOIN `number_of_students` ON `number_of_students`.`teacher_id` = `department_teachers`.`teacher_id` WHERE `users`.`role_id` = '3' AND `department_teachers`.`department_id` = (SELECT `departments`.`id_department` FROM `departments` INNER JOIN `users` ON `departments`.`head_id` = `users`.`id_user` WHERE `users`.`login` = '$login')");
$result = $result->fetchAll();
var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Распределение нагрузки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        table {
            text-align: center;
            margin-top: 20px;
        }
        
        table th, table td {
            padding: 10px;
        }
        
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table td {
            border-bottom: 1px solid #ddd;
        }
        
        input[type="number"] {
            width: 80px;
            height: 30px;
            font-size: 14px;
        }
        
        input[type="submit"] {
            height: 30px;
            padding: 5px 10px;
            font-size: 14px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            outline: none;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        #exit {
            margin-top: 20px;
        }
        
        #exit input[type="submit"] {
            background-color: #ccc;
            color: #000;
        }
        
        #exit input[type="submit"]:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th style="padding: 15px;">ФИО преподавателя</th>
            <th style="padding: 15px;">Количество студентов</th>
            <th style="padding: 15px;">Сохранить</th>
        </tr>
        <?php foreach($result as $element): ?>
            <form action="numbers_of_students_back.php" method="post">
                <tr>
                    <input type="hidden" name="id" value="<?= $element['id_user']?>">
                    <td><?= $element['full_name']?></td>
                    <td><input type="number" name="numbers" max="10" min="1" value="<?php if(isset($element['numbers_of'])) echo $element['numbers_of']; ?>"></td>
                    <td><input type="submit" value="Сохранить"></td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>
    
    <form action="../../index.php" method="post" id="exit">
        <input type="submit" value="Назад">
    </form>
</body>
</html>
