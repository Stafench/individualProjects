<?php 
session_start();
if(isset($_SESSION['user']))
header("Location: ../index.php");
if(!isset($_SESSION['error_incorrect_login_or_password']))
$_SESSION['error_incorrect_login_or_password'] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Авторизация</h1>
        <form action="signin_back.php" method="post" id="form_signin">
            <input type="text" placeholder="Введите логин" name="login">
            <input type="password" placeholder="Введите пароль" name="password">
            <input type="submit" value="Войти">
        </form>
        <?php
        if($_SESSION['error_incorrect_login_or_password']):
        ?>
        <div class="error-message">Неправильный логин или пароль.</div>
        <?php
        $_SESSION['error_incorrect_login_or_password'] = false;
        endif
        ?>
    </div>
</body>
</html>