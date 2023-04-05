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

    <title>Профиль</title>
</head>
<body>

<p>Добро пожаловать, <?=$_SESSION['name']?>!</p>
<?php
if(!empty($_SESSION['status']) && $_SESSION['status']=='endedit'){
    echo "<p style='color:#15ff00'>Ваши данные успешно изменены</p>";
    $_SESSION['status']='';
}
?>
<a href="/TEST/profile_edit.php">Изменить профиль</a><br><br>
<a href="/TEST/logout.php">Выйти</a>

</body>
</html>


