<?php
function prepareLinks($text)
{
    $result = preg_replace("/(https?:\/\/[^\s]+)(\:?\s\(\w+\))?/", "<div class='longlink'><a href='$1'>$1</a>$2</div>", $text); /*preg_replace
    выполняет обычный поиск выражения и заменяет его, используя отзыв.*/
    return $result;
}

/*Смысл этой функции - преобразование ссылок*/
/*Функция, которая увидит логин, форму логина.*/
function login()
{
    $db = mysqli_connect("schoolproject.test", "root", "", "schoolproject"); /*Локальная переменная*/
    if (!empty($_POST["login"]) && !empty($_POST["password"])) {
        $login = (strtolower($_POST["login"])); /*Перевели в нижний регистр.    Strtolower ищет в условии позицию первого случая подусловия */
        $password = sha1($_POST["password"]);
        if (preg_match("/^[a-z\d]+$/", $login)) {   /*Preg_match выполняет глобальное совмещение обычного выражения (из букв и цифр).*/
            $result = $db->query("select * from `users` where `login`='$login' and `password`='$password'")->fetch_assoc();
            /*print("select * from `users` where `login`='$login' and `password`='$password'");*/
            /*Array ( [ID] => 1 [Login] => admin [Password] => f865b53623b121fd34ee5426c792e5c33af8c227 [Username] => Администратор [Role] => admin )*/
            if (!empty($result) && !empty($result["Login"])) {
                $_SESSION["USER"] = $result;
                return True;
            }
        }
    }


    return False;
}

function LoginUser($roles=[]) /*Подпрограмма*/
{
    if (empty($_SESSION["USER"])) { /*Супер глобальный массив. Он виден отовсюду и проверяем на наличие по ключу USER, который будет заполнен на 21 строке.*/
        if (login()){   /*Вызов функций.*/
//            && $result["Role"] == "admin" Д/З
            return;
        }
        header('HTTP/1.0 403 Forbidden'); /*Написать НАДО до любого вывода (session_start и header)*/ /*Это ошибочный заголовок (нормальный 200).*/
        print("User not logged in!");
        DrawForm();
        exit();
    }
}

function DrawForm()
{
    ?>
    <form method="post">
        <label>login
            <!--Label определяет текстовую метку для элемента input. Этот тег для того, чтобы в него можно ввести данные.-->
            <input type="text" name="login"/>
        </label><br>
        <label>password
            <input type="password" name="password"/>
        </label><br>
        <button type="submit">Log in</button>
    </form><?php
}