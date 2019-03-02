<?php
$db = mysqli_connect("schoolproject.test", "root", "", "schoolproject");
$db->query ("insert into articles (TITLE, BODY, CREATEDAT, MENUITEM, USERS, deleted) values ('New title', 'New body', '".date('Y-m-d H:i:s')."','New title','admin', false)");
/*Сюда входить только админ.*/
if ($_SESSION["USER"]["Role"] == "admin"){
    ?>
    <a href="/admin.php?id=<?php print($_GET["id"]); ?>" target="_blank">Dodati novo datoteko</a>
    <?php
}
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 24.02.2019
 * Time: 18:45
 */