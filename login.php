<?php /*Новая сессия при открытии нового файла. - session_start () */
header('Content-Type: text/html; charset=utf-8');
require_once "functions.php";
LoginUser(["admin"]);
?>
<!--Идёт проверка, кто проверился, а кто нет.-->