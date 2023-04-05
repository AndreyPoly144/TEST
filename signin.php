<?php
if(empty($_POST)){
    header("Location: /TEST/");                 //чтобы в адрес строке не вписали профиль и без ввода не вошли
    exit;}
session_start();

function clearData($value){
    $value=trim($value);
    $value=htmlspecialchars($value);
    return $value;
}
$log=clearData($_POST['log']);              //емаил или телефон
$password=clearData($_POST['password']);


//ПРОВЕРКА НА ПУСТОЙ ВВОД
if($log==''){                                                                                                            //если  пустой лог
    $response=['status'=>'error', 'message'=>'Введите телефон или почту', 'where'=>'log'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
if($password==''){                                                         //если  пустой пароль
    $response=['status'=>'error', 'message'=>'Вы не ввели пароль', 'where'=>'password'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}
//ЕСЛИ ПОЛЬЗОВАТЕЛЬ ВВЕЛ ЛОГ КОТОРЫЙ И НЕ ТЕЛЕФОН И НЕ ПОЧТА;
if(!preg_match('/^(\+7)\d{10}$/', $log) &&  !filter_var($log, FILTER_VALIDATE_EMAIL)){      //т.е. лог и по РВ не проходит и по фильтру тоже не проходит
    $response=['status'=>'error', 'message'=>'Некорректный формат телефона или email', 'where'=>'log'];
    header('Content-type: application/json');
    echo json_encode($response);
    exit;
}

//ЕСЛИ ЛОГ ТЕЛЕФОН
if(preg_match('/^(\+7)\d{10}$/', $log)){
    require_once 'includes/connect.php';
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `tel`='$log'");//выбираем запись из бд с телефоном который ввел клиент
    $data=mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($data)){
        $response=['status'=>'error', 'message'=>'Номер телефона не зарегистрирован', 'where'=>'log'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
}
    $hash=$data[0]['password'];
    if(!password_verify($password, $hash)){
        $response=['status'=>'error', 'message'=>'Неверный пароль', 'where'=>'password'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
}

//ЕСЛИ ЛОГ ПОЧТА
if(filter_var($log, FILTER_VALIDATE_EMAIL)){
    require_once 'includes/connect.php';
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `mail`='$log'");
    $data=mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($data)){
        $response=['status'=>'error', 'message'=>'Адрес почты не зарегистрирован', 'where'=>'log'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
    $hash=$data[0]['password'];
    if(!password_verify($password, $hash)){     //если введеный пароль не соотв хешу  (если ввели неправильный пароль)
        $response=['status'=>'error', 'message'=>'Неверный пароль', 'where'=>'password'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
}

//ЕСЛИ НЕ ВВЕЛИ КАПЧУ
if ($_POST['g-recaptcha-response']==''){
    $response=['status'=>'error', 'message'=>'Вы не прошли капчу', 'where'=>'recaptcha'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }

//ПРОВЕРКА КАПЧИ
if ($_POST['g-recaptcha-response']!=''){
    $secret='6LcfklslAAAAAE_tCoodTGKy8J_eAvtq0M53qKNH';
    $ip=$_SERVER['REMOTE_ADDR'];
    $response=$_POST['g-recaptcha-response'];
    $url="https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip";
    $file=file_get_contents($url);
    $res=json_decode($file);
    if($res->success==false) {
        $response=['status'=>'error', 'message'=>'Возникли ошибки, перепройдите капчу', 'where'=>'recaptcha'];
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
}

//УСПЕШНЫЙ ВХОД
$_SESSION['name']=$data[0]['name'];
$_SESSION['login']=$data[0]['login'];
$_SESSION['tel']=$data[0]['tel'];
$_SESSION['mail']=$data[0]['mail'];
$_SESSION['password']=$_POST['password'];

$response=['status'=>'success'];
header('Content-type: application/json');
echo json_encode($response);
exit;
?>

