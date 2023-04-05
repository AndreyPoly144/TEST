<?php
session_start();
if (empty($_SESSION['name']) || empty($_SESSION['login']) || empty($_SESSION['tel']) || empty($_SESSION['mail'])){
    header("Location: /TEST/");
}
//ЧИСТИМ ВХОДНЫЕ ДАННЫЕ
function clearData($value){
    $value=trim($value);
    $value=htmlspecialchars($value);
    return $value;
}
$name=clearData($_POST['name']);
$login=clearData($_POST['login']);
$password=clearData($_POST['password']);
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
if($login!=$_SESSION['login']) {        //если указали логин который не сотв предыдущему
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `login`='$login'");
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!empty($data)) {
        $response = ['status' => 'error', 'message' => 'Такой логин уже занят', 'where' => 'login'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
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
if($tel!=$_SESSION['tel']) {
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `tel`='$tel'");
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!empty($data)) {
        $response = ['status' => 'error', 'message' => 'Такой телефон уже зарегистрирован', 'where' => 'tel'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
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
if($mail!=$_SESSION['mail']) {
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `mail`='$mail'");
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!empty($data)) {
        $response = ['status' => 'error', 'message' => 'Такая почта уже зарегистрирована', 'where' => 'mail'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
}
if($password==''){
    $response=['status'=>'error', 'message'=>'Введите пароль', 'where'=>'password'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

//ИЗМЕНЯЕМ ДАННЫЕ ПОЛЬЗОВАТЕЛЯ В БД (если выше не было ошибок)
$pw_hash = password_hash($password, PASSWORD_DEFAULT);
mysqli_query($link, "UPDATE `users` SET `name`='$name', `login`='$login', `tel`='$tel', `mail`='$mail', `password`='$pw_hash' WHERE `login`='{$_SESSION['login']}';");
$_SESSION['name']=$name;
$_SESSION['login']=$login;
$_SESSION['tel']=$tel;
$_SESSION['mail']=$mail;
$_SESSION['password']=$password;
$_SESSION['status']='endedit';
$response=['status'=>'success'];
header('Content-type: application/json');
echo json_encode($response);
exit;

