<?php
require_once 'config.php';
require_once 'function/function.php';
if($action=='add'){
    if(empty($_GET['student_uid'])) {
        alert("没有学生号");
    }

    $time = time();
    $sql="insert into {$tablepre}kaoqin_record(uid,record_date) value({$_GET[student_uid]},{$time})";
    query($sql);
    exit;
}
else if ($action=='jiazhang_checklist'){ // 家长查学生考勤情况
   /* $student_uid = $_GET['student_uid'];
    if(empty($student_uid)) {
        alert("没有学生号");
    }*/
    switch($_SESSION['groupid']){
        case 1:
            //家长端
            $sql="select child_uid from {$tablepre}family where `father_uid`=".$_SESSION['user_id'];
            $res=result($sql);
            $ids='';
            foreach($res as $v){
                $ids.=$v['child_uid'].',';
            }
            $ids=trim($ids,',');
            $sql="select * from {$tablepre}kaoqin_record where `uid` in($ids)";
            break;
        case 2:
            //学生端
            $sql="select * from {$tablepre}kaoqin_record where `uid`=".$_SESSION['user_id'];
            break;
        case 3:
            //老师端
            $sql="select room_id from jy_classroom where teacher_uid=".$_SESSION['user_id'];
            $res=result($sql);
            $ids='';
            foreach($res as $v){
                $ids.=$v['room_id'].',';
            }
            $ids=trim($ids,',');
            $sql="select * from jy_student as sd left join jy_kaoqin_record as kqr on sd.student_id=kqr.uid where sd.room_id in($ids)";

            break;
    }

    $result=result($sql);
    $kaoqin_data = '';
    if($result){
        foreach($result as $row){
            if(empty($row['uid']))continue;
            $date_str = date("Y-m-d H:i:s", $row["record_date"]) ;
            $kaoqin_data.="{\"id\":\"$row[id]\",\"record_date\":\"$date_str\"},";
        }
    }

    include "themes/kaoqin/jiazhang_checklist.php";
    exit;
}
else if ($action=="jiaoshi_checklist") { // 教师查询班级的学生考勤

}
else if($action=='ajax_serch'){
    $serch_value=$_POST['serch_value'];
    $serch_type=$_POST['serch_type'];
    if(empty($serch_value)){
        echo '{"flag":false,"msg":"请填写学号!"}';
    }
    $numelist=getNum();
    if($serch_type=='sk'){
        if(in_array($serch_value,$numelist)){
            $sql="select * from {$tablepre}kaoqin_record where `uid` = $serch_value";
            $kaoqin_data = array();
            $result=result($sql);
            $total=0;
            if($result){
                foreach($result as $row){
                    $row["record_date"]= date("Y-m-d H:i:s", $row["record_date"]) ;
                    $kaoqin_data[]=$row;
                    $total++;
                }
            }else{
                echo '{"flag":false,"msg":"没有查找到相关学号考勤信息!"}';exit;
            }
            echo json_encode(array("Rows"=>$kaoqin_data,"Total"=>$total));exit;
        }else{
            echo '{"flag":false,"msg":"你没有权限查找其它学号!"}';
        }
    }
    elseif($serch_type=='bz'){
        $sql='select room_id from jy_classroom where teacher_uid='.$_SESSION['user_id'].' and room_id='.$serch_value;
        $result=result($sql);
        if(!$result){
             echo '{"flag":false,"msg":"你没有权限查找其它班级考勤信息!"}';
             exit;
        }
        $sql="select * from jy_student as sd left join jy_kaoqin_record as kqr on sd.student_id=kqr.uid where sd.room_id=$serch_value";
        $kaoqin_data = array();
        $result=result($sql);
        $total=0;
        if($result){
            foreach($result as $row){
                if(empty($row['uid']))continue;
                $row["record_date"]= date("Y-m-d H:i:s", $row["record_date"]) ;
                $kaoqin_data[]=$row;
                $total++;
            }
        }
        if($total==0){
            echo '{"flag":false,"msg":"没有查找到相关班级考勤信息!"}';exit;
        }
        echo json_encode(array("Rows"=>$kaoqin_data,"Total"=>$total));
    }
}
function getNum(){
    switch($_SESSION['groupid']){
        case 1:
            $sql="select child_uid from jy_family where `father_uid`=".$_SESSION['user_id'];
            $res=result($sql);
            $ids=array();
            foreach($res as $v){
                $ids[]=$v['child_uid'];
            }
            return $ids;
        case 3:
            $sql="select sd.student_id from jy_classroom as cr left join jy_student as sd on cr.room_id=sd.room_id where cr.teacher_uid=".$_SESSION['user_id'];
            $res=result($sql);
            $ids=array();
            foreach($res as $v){
                $ids[]=$v['student_id'];
            }
            return $ids;
    }
}