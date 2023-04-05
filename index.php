<?php
session_start();
$log='';
$password='';
if (!empty($_SESSION['tel']) && !empty($_SESSION['password'])){
    $log=$_SESSION['tel'];  $password=$_SESSION['password'];
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
    <title>Вход</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<form>
    <input type='text' placeholder='Телефон или email' name='log' value="<?=$log?>">
    <input type='password' placeholder='Пароль' name='password' value="<?=$password?>">
    <div class="g-recaptcha" data-sitekey="6LcfklslAAAAAIV65N2vqWm1AxfyjFbzbF7XAyy4"></div>
    <div class="text-danger" id="recaptchaError"></div>
<?php
if(!empty($_SESSION['status']) && $_SESSION['status']=='endreg'){
    echo "<p class='reg'>Регистрация прошла успешно</p>";
    $_SESSION['status']='';
}
?>
    <p id="message" class="hidden">Message</p>
    <input type="submit" class="button" id="btn-log" value="Войти">
</form>
<p>Нет аккаунта? - <a href="register.php">Регистрация</a><p>

<script src="js/log.js"></script>


</body>
</html>
