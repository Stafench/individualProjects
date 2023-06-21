<?php
require_once "../../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1)
    header("Location:../../../index.php");
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
    `users`.`role_id` = '5'";
$students = $connect->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
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

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box; /* Учесть границы в общей ширине элемента */
        }
        input[type="text"]{
            margin-top: 10px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            outline: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
<a href="../../../index.php" class="button">Назад</a>
    <table>
        <tr>
            <th>Логин</th>
            <th>Пароль</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Сохранить</th>
            <th>Удалить</th>
        </tr>
        <?php foreach ($students as $student): ?>
            <form action="table_student_update.php" method="post">
                <input type="hidden" name="id_student" value="<?= $student['id_user'] ?>">
                <tr>
                    <td><input type="text" name="login" value="<?= $student['login'] ?>"></td>
                    <td><input type="text" name="password" value="<?= $student['password'] ?>"></td>
                    <td><input type="text" name="lastname" value="<?= $student['lastname'] ?>"></td>
                    <td><input type="text" name="firstname" value="<?= $student['firstname'] ?>"></td>
                    <td><input type="text" name="middlename" value="<?= $student['middlename'] ?>"></td>
                    <td><input type="submit" value="Сохранить"></td>
            </form>
            <form action="table_student_delete.php" method="post">
                <input type="hidden" name="id_student" value="<?= $student['id_user'] ?>">
                    <td><input type="submit" value="Удалить"></td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>
    <table>
        <tr>
            <th>Логин</th>
            <th>Пароль</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Добавить</th>
        </tr>
        <form action="table_student_add.php" method="post">
            <tr>
                <td><input type="text" name="login" value=""></td>
                <td><input type="text" name="password" value=""></td>
                <td><input type="text" name="lastname" value=""></td>
                <td><input type="text" name="firstname" value=""></td>
                <td><input type="text" name="middlename" value=""></td>
                <td><input type="submit" value="Добавить"></td>
                <td><td><input type="submit" value="Удали" style="visibility: hidden;"></td></td>
            </tr>
        </form>
    </table>
</body>
</html>
