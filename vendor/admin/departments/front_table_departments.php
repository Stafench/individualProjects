<?php
require_once "../../connect.php";
session_start();
if ($_SESSION['user']['role'] != 1)
    header("Location:../../../index.php");
if (!isset($_SESSION['error_head_alredy_exist']))
    $_SESSION['error_head_alredy_exist'] = null;
$sql = "SELECT * FROM `departments`";
$departments = $connect->query($sql)->fetchAll();
$sql = "SELECT
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
WHERE
`users`.`role_id` = '2'";
$heads = $connect->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Table</title>
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

        select,
        input[type="text"] {
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
            width: 80%;
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

        .error-message {
            color: red;
            margin-top: 10px;
        }
        section, input{
            outline: none;
        }
    </style>
</head>
<body>
    <a href="../../../index.php" class="button">Назад</a>
    <table>
        <tr>
            <th>Наименование кафедры</th>
            <th>Заведующий кафедрой</th>
            <th>Сохранить</th>
            <th>Удалить</th>
        </tr>
        <?php foreach ($departments as $department): ?>
            <form action="table_departments_update.php" method="post">
                <input type="hidden" name="id_department" value="<?= $department['id_department'] ?>">
                <tr>
                    <td><input type="text" name="department_name" value="<?= $department['name'] ?>"></td>
                    <td>
                        <select name="select_head">
                            <?php foreach ($heads as $head): ?>
                                <option value="<?= $head['id_user'] ?>" <?php if ($head['id_user'] == $department['head_id']) echo "selected"; ?>>
                                    <?= $head['full_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Сохранить"></td>
            </form>
            <form action="table_departments_delete.php" method="post">
                <input type="hidden" name="id_department" value="<?= $department['id_department'] ?>">
                    <td><input type="submit" value="Удалить"></td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>
    <table>
        <tr>
            <th>Наименование кафедры</th>
            <th>Заведующий кафедрой</th>
            <th>Добавить</th>
        </tr>
        <form action="table_departments_add.php" method="post">
            <tr>
                <td><input type="text" name="department_name" value=""></td>
                <td>
                    <select name="select_head">
                        <?php foreach ($heads as $head): ?>
                            <option value="<?= $head['id_user'] ?>"><?= $head['full_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="submit" value="Добавить" style="margin-left: 15px;"></td>
                <td><input type="submit" value="Удалить" style="visibility: hidden;"></td>
            </tr>
        </form>
    </table>
    <?php if ($_SESSION['error_head_alredy_exist'] != null): ?>
        <div class="error-message"><?= $_SESSION['error_head_alredy_exist'] ?></div>
        <?php $_SESSION['error_head_alredy_exist'] = null; ?>
    <?php endif; ?>
</body>
</html>
