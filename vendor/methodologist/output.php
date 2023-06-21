<?php
require_once "../connect.php";
require "../autoload.php";
$mpdf = new \Mpdf\Mpdf();
?>

<?
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Приказ ИНДИВИДУАЛЬНЫЙ ПРОЕКТ 2018</title>
    er: 1px solid;
        border-collapse: collapse;
        text-align: center;
        line-height: 1.5;
    }
    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: Times New Roman, Times, serif;
        line-height: 1.5;
    }
    
    
    
    .dynamic-table td,
    .dynamic-table th {
         /* Новый размер шрифта для таблиц */
        border: 1px solid;
        text-align: center;
        padding-left: 5px;
        padding-right: 5px;
    }
    
    .center {
        text-align: center;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .center * {
        max-width: 100%;
        max-height: 100%;
        display: inline-block;
        vertical-align: middle;
        width: auto !important;
        height: auto !important;
    }
    
    .image-container {
        max-width: 20%; /* Максимальная ширина контейнера изображения */
        max-height: 20%; /* Максимальная высота контейнера изображения */
    }
    
    #blueText {
        margin-top: -10px;
        color: #55a;
    }
    
    p {
        margin: 5;
        line-height: 1.5;
    }
    
    hr {
        color: #55c;
    }
    
    .rightLeft {
        width: 100%;
    }
    
    .main-txt {
        font-size: 17px;
        text-indent: 20px;
    }
    
    .list li {
        font-size: 16px;
    }
    
    .margin {
        margin-top: 50px;
    }
    .table-font {
        font-size: 1pt;
    }
    .dynamic-table {
        font-size: 14pt;
        border: 1px solid;
        border-collapse: collapse;
        text-align: center;
        line-height: 1.5;
    }
    #table {
        font-size: 14pt;
    }
    
    #table td,
    #table th {
        font-size: 14pt;
    }
</style>
</head>
<body>
<div class="center">
    <div class="image-container">
        <img width="60" src="../../resources/img/logo_irkpo.png" alt="Изображение">
        <p> МИНИСТЕРСТВО ОБРАЗОВАНИЯ ИРКУТСКОЙ ОБЛАСТИ<br>
    Государственное бюджетное профессиональное образовательное учреждение
    Иркутской области<br>
    «Иркутский региональный колледж педагогического образования»
    <p id="blueText">(ГБПОУ ИО ИРКПО)</p>
        </p>
        <hr>
    </div>
</div>
<div class="center" style="height:1vh;">ПРИКАЗ</div>
<table class="rightLeft">
<tr>
<td>27.09.2018</td>
<td style="text-align:right;">№ 801-од</td>
</tr>
</table>
<br>
<table class="rightLeft">
<tr>
<td style=" font-weight:bold;">Об утверждении тем<br>
индивидуальных проектов</td>
<td ></td>
</tr>
</table>
<br>
<p class="main-txt">
В соответствии с Федеральным законом «Об образовании в Российской
Федерации» от 29 декабря 2012 года № 273-ФЗ», руководствуясь
Федеральным государственным стандартом среднего (полного) общего
образования, утвержденным приказом Министерства образования и науки
Российской Федерации от 17 мая 2012 года № 413, на основании
Рекомендаций по организации получения среднего общего образования в
пределах освоения образовательных программ среднего профессионального
образования на базе основного общего образования с учетом требований
федеральных государственных образовательных стандартов и получаемой
профессии или специальности среднего профессионального образования
направленных письмом Министерства образования и науки Российской
Федерации от 17 марта 2015 г. № 06-259,
</p>
<p class="main-txt">
ПРИКАЗЫВАЮ:
<ol class="list">
<li>Утвердить руководителей и темы индивидуальных проектов
студентов 1 курсов по группам (приложение № 1).</li>
<li>Тьюторам отделений (Воробьева О.А., Никерова Т.К., Деркач
М.О., Горбачева С.В., Ерлыкова О.В.), заведующим отделениями (Гусев Б.В.,
Баранова Н.С.), в срок до 8 ноября 2018 года, завести в ИАС Ментор учебные
ведомости часов консультаций на каждого студента в соответствии с
распределенной нагрузкой по преподавателям (приложение № 1).</li>
<li>Контроль за исполнением настоящего приказа возложить на
заместителя директора по общеобразовательной деятельности
Ж.Г. Тимергалееву.</li>
</ol>

</p>
<br><br>
<table class="rightLeft">
<tr>
<td style="font-size: 17px;">Директор</td>
<td style="text-align:right; font-size: 17px;">Г.Ф. Кудрявцева</td>
</tr>
</table>
<br><br>
<table class="rightLeft">
<tr>
<td style="font-size: 17px;"></td>
<td style="text-align:right; font-size: 15px; font-weight: bold;">Приложение №1</td>
</tr>
</table>
<br>';

$groups = $connect->query("SELECT * FROM `groups`")->fetchAll();
foreach ($groups as $group) {
    $tests = $connect->query("SELECT 
        `objects`.`name`,
        (
            SELECT CONCAT(
                `users`.`lastname`,
                ' ',
                LEFT(`users`.`firstname`,1),
                '. ',
                LEFT(`users`.`middlename`,1), '.'
            ) AS full_name_student
            FROM `users`
            WHERE `users`.`id_user` = `projects`.`teacher_id`
        ) AS full_name_teacher,
        `projects`.`topic`,
        (
            SELECT CONCAT(
                `users`.`lastname`,
                ' ',
                `users`.`firstname`,
                ' ',
                `users`.`middlename`
            ) AS full_name_student
            FROM `users`
            WHERE `users`.`id_user` = `projects`.`student_id`
        ) AS full_name_student
    FROM
        `objects`
    INNER JOIN `projects` ON `projects`.`object_id` = `objects`.`id_object`
    INNER JOIN `student_groups` ON `projects`.`student_id` = `student_groups`.`student_id`
    WHERE `student_groups`.`group_id` = '". $group['id_group'] ."'")->fetchAll();

    $html .= '
    <div class="center margin" style="height:1vh; font-weight: bold; margin-top: 0vh; font-size: 15pt;">' . $group['name'] . '</div>
    <br>
    <table id="table" class="dynamic-table">
    <tr>
        <th style="width:5%; font-size: 14px;"></th>
        <th style="max-width:20%; font-size: 14px;">Общеобразовательная дисциплина</th>
        <th style="max-width:15%; font-size: 14px;">Преподаватель</th>
        <th style="max-width:30%; font-size: 14px;">Тема индивидуального проекта </th>
        <th style="max-width:20%; font-size: 14px;">Обучающийся</th>
    </tr>';

    $count = 1;
    foreach($tests as $test) {
        $html .= 
        '<tr>
        <td style="width:5%; font-size: 14px;">'.$count.'</td>
        <td style="max-width:20%; font-size: 14px;">'. $test['name'] .'</td> 
        <td style="max-width:15%; font-size: 14px;">'. $test['full_name_teacher'] .'</td>
        <td style="max-width:30%; font-size: 14px;">'. $test['topic'] .'</td>
        <td style="max-width:20%; font-size: 14px;">'. $test['full_name_student'] .'</td>
    </tr>';
        $count++;
    }

    $html .= '</table>
    <br>
    <br>
    ';
}
$html .= '<table class="rightLeft">
<tr>
<td style="font-size: 17px;">Директор</td>
<td style="text-align:right; font-size: 17px;">Г.Ф. Кудрявцева</td>
</tr>
</table>';
// echo $html;
$mpdf->WriteHTML($html);
$mpdf->Output('Приказ ИНДИВИДУАЛЬНЫЙ ПРОЕКТ 2018.pdf', 'I');
?>
<!-- <div class="center">
    <img src="../../img/logo_ikrpo.png" alt="Изображение">
</div> -->