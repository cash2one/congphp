<?php
if(!empty($_SESSION['user_id'])){
    @header("location:user.php?action=login");
}
switch($_SESSION['groupid']){
    case 1:
    //家长端
    require("./themes/jy/jiazhang.htm");
    break;
    case 2:
    //学生端
    require("./themes/jy/xuesheng.htm");
    break;
    case 3:
    //老师端
    require("./themes/jy/teacher.htm");
    break;
    }
?>