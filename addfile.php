<?php
$db = mysqli_connect("schoolproject.test", "root", "", "schoolproject");
$db->query ("insert into articles (TITLE, BODY, CREATEDAT, MENUITEM, USERS, deleted) values ('New title', 'New body', '".date('Y-m-d H:i:s')."','New title','admin', false)");
/*Сюда входить только админ.*/
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 24.02.2019
 * Time: 18:45
 */