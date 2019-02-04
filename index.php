<?php
header('Content-Type: text/html; charset=utf-8'); /*кодировка*/
include_once "functions.php"; /*include - запрашивает файл. Если нет информации, то даёт предуреждение. Require даёт фатальную ошибку (без функции)*/
LoginUser();
$db = mysqli_connect("schoolproject.test", "root", "", "schoolproject"); /*Возвращает ошибочный код с последного соединения.*/
if (empty($_GET["id"])) { /*Empty решает, настроена ли переменная величина внутри него.*/
    $_GET["id"] = 1;
}
$result = $db->query("select * from articles where id=" . $_GET["id"]);    /*Написано неправильно.*/
/*print_r($result->fetch_assoc());*/
$fullcontent = $result->fetch_assoc(); /*fetch_assoc возвращает текущий ряд набора результатов как объект.*/
$fullcontent["USERS"]=explode("+", $fullcontent["USERS"]); /*delimiter - разделитель*/
//print_r($fullcontent["USERS"]);
//print_r($_SESSION["USER"]["Role"]); /*Выводит статус пользователя.*/
$correctuser = false;
foreach ($fullcontent["USERS"] as $role){   /*Конструкция foreach предоставляет простой способ перебора массивов.*/
    if ($role == $_SESSION["USER"]["Role"]){
        $correctuser = true;
    }
}
if (!$correctuser){
    DrawForm();
    exit();
}
$content = $fullcontent["BODY"];    /*$ - переменная*/
$title = $fullcontent["TITLE"] ?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Seminarska naloga
    </title>
    <link rel="stylesheet" type="text/css" href="Main.css">
    <style type="text/css">
        body {
            background: url("img/<?php print($fullcontent["BACKGROUND"]); ?>");
        }
    </style>
    <script type="application/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="application/javascript">
        $(function () {
            $(".buttonwrapper a").click(function (event) {
                event.stopPropagation();
            });
            $(".buttonwrapper").click(function () {
                $(this).find("a")[0].click();
                //alert($(this).find("a").length);
            });
        });
        <?php if($_GET["id"] == 10){
        session_destroy();
        ?>setTimeout(function () {
            window.location.href="/?id=1";
        }, 2000);<?php
        }?>
    </script>
</head>
<body>
<h1><?php print($title); ?></h1>
<?php require "Menu.php" ?>
<div class="content"><?php print($content); ?></div>
<?php
if ($_SESSION["USER"]["Role"] == "admin"){
?>
    <a href="/admin.php?id=<?php print($_GET["id"]); ?>" target="_blank">Редактировать</a>
<?php
}
?>
<div class="footer"></div>
</body>
</html>
<!--Д/З Убрать "Редактировать" Если кто-то зашёл под АДМИН, он может видеть "Редактировать"-->
<!--Нужно, чтобы вместо главной страницы открылась страница admin.php. Если зарегистрировался admin, то появится кнопка "Редактировать",
если не админ, тогда этой кнопки не будет.-->

<!--Прочитать программы, подготовить вопросы. Прочитать про глобальные массивы и конкретно про директива autosession_start.-->
<!-- autosession_start - определяет, будет ли модуль сессии запускать сессию автоматически при старте. Значение по умолчанию 0 (отключено).-->

<!--Разбирать сайт; узнать, что по информатике; зарегистрироваться GitHub-->