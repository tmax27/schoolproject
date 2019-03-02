<?php
$db = mysqli_connect("schoolproject.test", "root", "", "schoolproject");
$db->query("update articles set `deleted`= not deleted where `ID` = ".$_GET["id"]); /*Сюда входить только админ.*/
if ($_SESSION["USER"]["Role"] == "admin"){
    ?>
    <a href="/admin.php?id=<?php print($_GET["id"]); ?>" target="_blank">Izbrisati datoteko</a>
    <?php
}
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 24.02.2019
 * Time: 18:46
 */