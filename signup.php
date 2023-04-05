<?php
if(empty($_POST)){
    header("Location: /TEST/");
    exit;}
session_start();
//ЧИСТИМ ВХОДНЫЕ ДАННЫЕ
function clearData($value){
    $value=trim($value);
    $value=htmlspecialchars($value);
    return $value;
}
$name=clearData($_POST['name']);
$login=clearData($_POST['login']);
$password=clearData($_POST['password']);
$passwordAgain=clearData($_POST['passwordAgain']);
$mail=clearData($_POST['mail']);
$tel=clearData($_POST['tel']);

//ЕСЛИ ПОЛЯ НЕ ЗАПОЛНЕНЫ
if($name==''){
    $response=['status'=>'error', 'message'=>'Укажите ваше имя', 'where'=>'name'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
if($login==''){
    $response=['status'=>'error', 'message'=>'Заполните логин', 'where'=>'login'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
//ПРОВЕРЯЕМ ЧТОБЫ В БД НЕ БЫЛО 2 ОДИНАКОВЫХ ЛОГИНОВ
require 'includes/connect.php';
$result = mysqli_query($link, "SELECT * FROM `users` WHERE `login`='$login'");   //отфильтрвываю все строки которые содержат логин введеный пол-ль
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (!empty($data)) {                              //если хоть одна строка есть, значит такой логин уже занят
    $response=['status'=>'error', 'message'=>'Такой логин уже занят', 'where'=>'login'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

if($tel==''){
    $response=['status'=>'error', 'message'=>'Укажите ваш телефон', 'where'=>'tel'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
//ВАЛИДАЦИЯ ТЕЛЕФОНА
$reg='/^(\+7)\d{10}$/';
if (!preg_match($reg, $tel)){
    $response=['status'=>'error', 'message'=>'Номер не соответсвует формату +7 (000) 000 00 00', 'where'=>'tel'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
//ПРОВЕРЯЕМ ЧТОБЫ В БД НЕ БЫЛО 2 ОДИНАКОВЫХ ТЕЛЕФОНОВ
$result = mysqli_query($link, "SELECT * FROM `users` WHERE `tel`='$tel'");
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (!empty($data)) {
    $response=['status'=>'error', 'message'=>'Такой телефон уже зарегистрирован', 'where'=>'tel'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

if($mail==''){
    $response=['status'=>'error', 'message'=>'Укажите вашу почту', 'where'=>'mail'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
//ВАЛИДАЦИЯ ПОЧТЫ
if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
    $response=['status'=>'error', 'message'=>'Некорректный адрес почты', 'where'=>'mail'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
//ПРОВЕРЯЕМ ЧТОБЫ В БД НЕ БЫЛО 2 ОДИНАКОВЫХ МАЙЛОВ
$result = mysqli_query($link, "SELECT * FROM `users` WHERE `mail`='$mail'");
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (!empty($data)) {
    $response=['status'=>'error', 'message'=>'Такая почта уже зарегистрирована', 'where'=>'mail'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

if($password==''){
    $response=['status'=>'error', 'message'=>'Введите пароль', 'where'=>'password'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

//ЕСЛИ ПАРОЛИ НЕ СОВПАЛИ
if ( $password != $passwordAgain) {
    $response=['status'=>'error', 'message'=>'Пароли не совпадают', 'where'=>'passwordAgain'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

//ЗАНОСИМ ПОЛЬЗОВАТЕЛЯ В БД (если все выше выполнено)
        $pw_hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($link, "INSERT INTO `users` (`name`, `login`, `tel`, `mail`, `password`) VALUES ('$name', '$login','$tel', '$mail', '$pw_hash')");
        $_SESSION['tel'] = $tel;
        $_SESSION['mail'] = $mail;
        $_SESSION['password'] = $password;   //переносим теле, маил и пароль в сессию чтобы на странице входа данные уже были заполнены;
        $_SESSION['status']='endreg';
        $response=['status'=>'success'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;

