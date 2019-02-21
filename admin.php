<?php
require "login.php"; /*Require и include работает быстрее, чем require_once и include_once. Иногда нам нужно подключать файл несколько раз.*/
/*Проверить задан или нет ID*/
if (empty($_GET["id"])) {
    print("Не задан ID-материал!");
    exit();
}
$db = mysqli_connect("schoolproject.test", "root", "", "schoolproject");
if (preg_match("/^\d+$/", $_GET["id"])) {    /*Вся строка состоит из цифр. \d - одна цифра, + - больше*/    /*Начало текста, цифровой символ, одно или более, конец текста.*/
    if (!empty($_POST["BODY"])) {
        $db->query("update articles set `body`='" . $_POST["BODY"] . "',`title`='" . $_POST["TITLE"] . "' where id=" . $_GET["id"]);
    }
    $result = $db->query("select * from articles where id=" . $_GET["id"]);
} else {
    print("Неверный ID-материал!");
    exit();
}
$fullcontent = $result->fetch_assoc();
$content = $fullcontent["BODY"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        admin.php
    </title>
    <script src="js/nicEdit.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
</head>
<body>
<form method="post" action="admin.php?id=<?php print($_GET["id"]); ?>">
    <input type="text" name="TITLE" value="<?php print($fullcontent["TITLE"]); ?>"/><br/>
    <textarea name="BODY" style="width: 700px; height: 400px"><?php print($content); ?>
		</textarea>
    <button type="submit">
        Save
    </button>
</form>
</body>
<!--Выводит BODY из HeidiSQL-->
<!--Максимум символов зависит от 1 строки-->

<!--$_SESSION["USER"] == "admin"-->