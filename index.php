<?php
header('Content-Type: text/html; charset=utf-8'); /*kodiranje*/
include_once "functions.php"; /*include - poizveduje datoteko. Če ni informacije, opozori. Require pa obveščuje usodno napako (brez funkcije.)*/
LoginUser();
$db = mysqli_connect("schoolproject.test", "root", "", "schoolproject"); /*Vrača napačno napako od zadnje povezave.*/
if (empty($_GET["id"])) { /*Empty se določa, ali je oblikovana spremenljivka znotraj pogoja.*/
    $_GET["id"] = 1;    /*Ta niz je napisana narobe, saj je določen ID. Harm code – zaradi njega se koda izgubi prilagodljivost.*/
}
$result = $db->query("select * from articles where id=" . $_GET["id"]);    /*Napisano je narobe.*/
/*print_r($result->fetch_assoc());*/
$fullcontent = $result->fetch_assoc(); /*fetch_assoc vrača trenutno vrsto opreme rezultatov kot predmet.*/
$fullcontent["USERS"]=explode("+", $fullcontent["USERS"]); /*delimiter - izločevalec*/
//print_r($fullcontent["USERS"]);
//print_r($_SESSION["USER"]["Role"]); /*Pokaže se uporabnikov položaj.*/
$correctuser = false;
foreach ($fullcontent["USERS"] as $role){   /*Gradnja foreach se predstavlja kot enostaven način štetje nizov. Cikel vlogov*/
    if ($role == $_SESSION["USER"]["Role"]){ /*Primerja vlogo konkretnega uporabnika.*/
        $correctuser = true; /*Zapolnja spremenljivko.*/
    }
}
if (!$correctuser){
    DrawForm();
    exit();
}
$content = $fullcontent["BODY"];    /*$ - spremenljivka*/
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
    <a href="/admin.php?id=<?php print($_GET["id"]); ?>" target="_blank">Uredi</a><br>
    <a href="/admin.php?id=<?php print($_GET["id"]); ?>" target="_blank">Dodati novo datoteko</a><br>
    <a href="/admin.php?id=<?php print($_GET["id"]); ?>" target="_blank">Izbrisati datoteko</a><br>
<?php
}
?>
<div class="footer"></div>
</body>
</html>