<?php
$link = mysqli_connect('mysql', 'root', '144', 'TEST');
if(mysqli_connect_errno()){
    exit('Ошибка подключения, код ошибки -'. mysqli_connect_errno().', описание ошибки - '.mysqli_connect_error());
}
