<?php
function prepareLinks($text)
{
    $result = preg_replace("/(https?:\/\/[^\s]+)(\:?\s\(\w+\))?/", "<div class='longlink'><a href='$1'>$1</a>$2</div>", $text); /*preg_replace
    izpolni navadno iskanje izraza in ga zamenja, uporabljajoč komentar.*/
    return $result;
}

/*Namen te funkcije je reorganizacija povezav.*/
/*Funkcija, ki bo videla uporabniško ime in njegovo obliko.*/
function login()
{
    $db = mysqli_connect("schoolproject.test", "root", "", "schoolproject"); /*Mestna spremenljivka*/
    if (!empty($_POST["login"]) && !empty($_POST["password"])) {
        $login = (strtolower($_POST["login"])); /*Premestimo v spodnji register.    Strtolower išče v pogoju pozicijo prve možnosti podpogoja.*/
        $password = sha1($_POST["password"]);
        /*sha1 prevaja podatke, ki smo napisali v password in jih kriptira: napisali smo geslo, sha1 pa ga prevaja v kombinacijo črk in številk. Ko vnesemo geslo, sha1 preverja kombinacijo s tistimi, ki so v bazi podatkov.*/
        if (preg_match("/^[a-z\d]+$/", $login)) {   /*Preg_match naredi globalno kombinacijo običajnega izraza (črk in številk).*/
            $result = $db->query("select * from `users` where `login`='$login' and `password`='$password'")->fetch_assoc(); /*Query - raziskava*/ /*Iščemo informacijo o uporabniku.*/
//            print_r($result);
//            print_r($_POST);
//            print("select * from `users` where `login`='$login' and `password`='$password'");
            /*Array ( [ID] => 1 [Login] => admin [Password] => f865b53623b121fd34ee5426c792e5c33af8c227 [Username] => Администратор [Role] => admin )*/
//            Array ( [ID] => 2 [Login] => user [Password] => d7316a3074d562269cf4302e4eed46369b523687 [Username] => User1 [Role] => user ) Array ( [login] => user [password] => user1234 ) select * from `users` where `login`='user' and `password`='d7316a3074d562269cf4302e4eed46369b523687'
            if (!empty($result) && !empty($result["Login"])) { /*Če je uporabnik najden.*/
                $_SESSION["USER"] = $result;
                return True;
            }
        }
    }


    return False;
}

function LoginUser($roles=[]) /*Podprogram*/
{
    if (empty($_SESSION["USER"]) || (!empty($_POST) &&!empty($_POST["login"]))) { /*|| - ali. "Super array data". Ga lahko vidimo povsod in preverimo na prisotnost s ključem USER, ki je zapolnjen na 21. nizu.*/
        if (login()){   /*Klic funkcije.*/
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
    header('HTTP/1.0 403 Forbidden'); /*NUJNO je napisati do katerega koli zaključka (session_start и header)*/ /*To je napačen naslov(normalen je 200).*/
    print("Uporabnik ni prijavljen!");
    ?>
    <form method="post">
        <label>Uporabniško ime:
            <!--Label opredeli besedilo za input. Ta oznaka je potrebna, da bi tja lahko vneseli podatke.-->
            <input type="text" name="login"/>
        </label><br>
        <label>Geslo:
            <input type="password" name="password"/>
        </label><br>
        <button type="submit">Prijava</button>
    </form><?php
}