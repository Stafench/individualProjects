<?php
require_once "../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1)
    header("Location:../../../index.php");
$sql = "SELECT * FROM `departments`";
$departments = $connect->query($sql)->fetchAll();
$sql = "SELECT DISTINCT
`users`.`id_user`,
CONCAT(
    `users`.`lastname`,
    ' ',
    `users`.`firstname`,
    ' ',
    `users`.`middlename`
) AS full_name
FROM
`users`
WHERE `users`.`role_id` = '3'";
$teachers = $connect->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher-Object Table</title>
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
            <th>ФИО преподавателя</th>
            <th style="width: 200px;">Предметы</th>
            <th>Удалить</th>
            <th>Добавить предмет</th>
        </tr>
        <?php foreach ($teachers as $teacher): ?>
            <tr>
                <form action="table_T_O_delete_object.php" method="post">
                    <input type="hidden" name="id_teacher" value="<?= $teacher['id_user'] ?>">
                    <td><?= $teacher['full_name'] ?></td>
                    <td>
                        <select name="select_object_delete" size="4">
                            <?php
                            $objects = $connect->query("SELECT `objects`.* FROM `objects` 
                                INNER JOIN `teachers_objects` ON `teachers_objects`.`object_id` = `objects`.`id_object`
                                WHERE `teachers_objects`.`teacher_id` = '" . $teacher['id_user'] . "'")->fetchAll();
                            foreach ($objects as $object):
                                ?>
                                <option value="<?= $object['id_object'] ?>"><?= $object['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Удалить" id="deleteButton"></td>
                </form>
                <form action="table_T_O_add_object.php" method="post">
                    <input type="hidden" name="id_teacher" value="<?= $teacher['id_user'] ?>">
                    <td>
                        <select name="select_object_add">
                            <?php
                            $objects = $connect->query("SELECT `objects`.* FROM `objects` 
                                WHERE `objects`.`id_object` NOT IN(
                                SELECT `objects`.`id_object` FROM `objects`
                                INNER JOIN `teachers_objects` ON `teachers_objects`.`object_id` = `objects`.`id_object`
                                WHERE `teachers_objects`.`teacher_id` = '" . $teacher['id_user'] . "')")->fetchAll();
                            foreach ($objects as $object):
                                ?>
                                <option value="<?= $object['id_object'] ?>"><?= $object['name'] ?></option>
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
