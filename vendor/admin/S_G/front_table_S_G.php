<?php
require_once "../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1)
    header("Location:../../../index.php");
$sql = "SELECT * FROM `departments`";
$departments = $connect->query($sql)->fetchAll();
$sql = "SELECT * FROM `groups`";
$groups = $connect->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group-Student Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        select {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            outline: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a.button {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px;
        }

        a.button:hover {
            background-color: #0069d9;
        }
        input, select{
            outline: none;
        }
        #addButton{
            margin-top: 10px;
        }
        #deleteButton{
            margin: 0px;
            width: 90%;
        }
    </style>
</head>
<body>
    <a href="../../../index.php" class="button">Назад</a>
    <table>
        <tr>
            <th>Наименование группы</th>
            <th style="width: 200px;">Студенты</th>
            <th>Удалить</th>
            <th>Добавить студента</th>
        </tr>
        <?php foreach ($groups as $group): ?>
            <tr>
                <form action="table_S_G_delete_student.php" method="post">
                    <input type="hidden" name="id_group" value="<?= $group['id_group'] ?>">
                    <td><?= $group['name'] ?></td>
                    <td>
                        <select name="select_student_delete" size="7">
                            <?php
                            $students = $connect->query("SELECT
                                `users`.`id_user`,
                                CONCAT(`users`.`lastname`, ' ', LEFT(`users`.`firstname`,1), '. ', LEFT(`users`.`middlename`,1), '.') as full_name
                            FROM
                                `users`
                            INNER JOIN `student_groups` ON `student_groups`.`student_id` = `users`.`id_user`
                            WHERE `student_groups`.`group_id` = '" . $group['id_group'] . "'")->fetchAll();
                            foreach ($students as $student):
                                ?>
                                <option value="<?= $student['id_user'] ?>"><?= $student['full_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Удалить" id="deleteButton"></td>
                </form>
                <form action="table_S_G_add_student.php" method="post">
                    <input type="hidden" name="id_group" value="<?= $group['id_group'] ?>">
                    <td>
                        <select name="select_student_add">
                            <?php
                            $students = $connect->query("SELECT
                                `users`.`id_user`,
                                CONCAT(
                                    `users`.`lastname`,
                                    ' ',
                                    LEFT(`users`.`firstname`, 1),
                                    '. ',
                                    LEFT(`users`.`middlename`, 1),
                                    '.'
                                ) AS full_name
                            FROM
                                `users`
                            WHERE
                                `users`.`id_user` NOT IN (
                                    SELECT `student_groups`.`student_id`
                                    FROM `student_groups`
                                ) AND `users`.`role_id` = '5'")->fetchAll();
                            foreach ($students as $student):
                                ?>
                                <option value="<?= $student['id_user'] ?>"><?= $student['full_name'] ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <input type="submit" value="Добавить" id="addButton">
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
