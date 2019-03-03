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
        /*sha1 переводит данные, которые мы написали в password и hash их: мы написали пароль, а sha1 переводит пароль в комбинацию букв и цифр. Когда мы пишем пароль, sha1 проверяет эти комбинации с теми, которые есть в базе данных.*/
        if (preg_match("/^[a-z\d]+$/", $login)) {   /*Preg_match выполняет глобальное совмещение обычного выражения (из букв и цифр).*/
            $result = $db->query("select * from `users` where `login`='$login' and `password`='$password'")->fetch_assoc(); /*Query - запрос*/ /*Ищем информацию о пользователе*/
//            print_r($result);
//            print_r($_POST);
//            print("select * from `users` where `login`='$login' and `password`='$password'");
            /*Array ( [ID] => 1 [Login] => admin [Password] => f865b53623b121fd34ee5426c792e5c33af8c227 [Username] => Администратор [Role] => admin )*/
//            Array ( [ID] => 2 [Login] => user [Password] => d7316a3074d562269cf4302e4eed46369b523687 [Username] => User1 [Role] => user ) Array ( [login] => user [password] => user1234 ) select * from `users` where `login`='user' and `password`='d7316a3074d562269cf4302e4eed46369b523687'
            if (!empty($result) && !empty($result["Login"])) { /*Если пользователь найден.*/
                $_SESSION["USER"] = $result;
                return True;
            }
        }
    }


    return False;
}

function LoginUser($roles=[]) /*Подпрограмма*/
{
    if (empty($_SESSION["USER"]) || (!empty($_POST) &&!empty($_POST["login"]))) { /*|| - или. Супер глобальный массив. Он виден отовсюду и проверяем на наличие по ключу USER, который будет заполнен на 21 строке.*/
        if (login()){   /*Вызов функций.*/
//            && $result["Role"] == "admin" Д/З
            if (!empty($roles)){
                if (in_array($_SESSION["USER"]["Role"], $roles)){
                    return;
                }
            }
            else {
                return;
            }
        }
        DrawForm();
        exit();
    }
    else {
        if (!empty($roles)){
            if (in_array($_SESSION["USER"]["Role"], $roles)){
                return;
            }
            DrawForm();
            exit();
        }
//        print_r($_SESSION);
    }
}

function DrawForm()
{
    header('HTTP/1.0 403 Forbidden'); /*Написать НАДО до любого вывода (session_start и header)*/ /*Это ошибочный заголовок (нормальный 200).*/
    print("User not logged in!");
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