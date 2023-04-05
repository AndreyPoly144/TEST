<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/TEST/css/style.css" rel="stylesheet">
    <title>Регистрация</title>
</head>
<body>
<form class="register" action="" method="post">
    <label for="name">Имя</label>
    <input id="name" name="name" type="text">

    <label for="login">Логин</label>
    <input id="login" name="login" type="text" >

    <label for="tel">Телефон</label>
    <input id="tel" name="tel" type="tel" placeholder="+7 (999) 000 00 00" >

    <label for="mail">Почта</label>
    <input id="mail" name="mail" type="text">

    <label for="password">Введите пароль</label>
    <input id="password" name="password" type="password">

    <label for="passwordAgain">Подтвердите пароль</label>
    <input id="passwordAgain" name="passwordAgain" type="password">

    <p id="message" class="hidden">Message</p>
    <input  id="btn-reg" type="submit" class="button" value="Регистрация">
</form>
<p>Уже есть аккаунт? - <a href="index.php" ;">Войти</a></p>

<script src="js/reg.js"></script>

</body>
</html>