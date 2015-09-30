<?php
require_once 'config.php';
require_once 'function/function.php';

if(empty($_SESSION['user_id'])){
    @header("location:login.html");
}
switch($_SESSION['groupid']){
    case 1:
        //家长端
       // require("./themes/jy/jiazhang.php");
        display("jy/jiazhang.php");

        break;
    case 2:
        //学生端
        display("jy/xuesheng.php");
        break;
    case 3:
        //老师端
        display("jy/teacher.php");
        break;
}
?>