<?php
$db = mysqli_connect("schoolproject.test", "root", "", "schoolproject");
$db->query("update articles set `deleted`= not deleted where `ID` = ".$_GET["id"]); /*Сюда входить только админ.*/
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 24.02.2019
 * Time: 18:46
 */