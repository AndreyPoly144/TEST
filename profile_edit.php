<?php
session_start();
if (empty($_SESSION['name']) || empty($_SESSION['login']) || empty($_SESSION['tel']) || empty($_SESSION['mail'])){
    header("Location: /TEST/");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/TEST/css/style.css" rel="stylesheet">
    <title>Личные данные</title>
</head>
<body>
<form class="register" action="" method="post">
    <label for="name">Ваше имя</label>
    <input id="name" name="name" type="text" value="<?=$_SESSION['name']?>">

    <label for="login">Ваш логин</label>
    <input id="login" name="login" type="text" value="<?=$_SESSION['login']?>">

    <label for="tel">Ваш телефон</label>
    <input id="tel" name="tel" type="tel" placeholder="+7 (999) 000 00 00" value="<?=$_SESSION['tel']?>">

    <label for="mail">Ваша почта</label>
    <input id="mail" name="mail" type="text" value="<?=$_SESSION['mail']?>">

    <label for="password">Ваш пароль</label>
    <input id="password" name="password" type="password" value="<?=$_SESSION['password']?>">

    <p id="message" class="hidden">Message</p>
    <input  id="btn-edit" type="submit" class="button" value="Измененить">
</form>
<a href="/TEST/profile.php">Отмена</a>


<script src="js/profile_edit.js"></script>

</body>
</html>