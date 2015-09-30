<?php 
require_once 'config.php'; 
require_once 'function.php';
error_reporting(E_ALL & ~E_DEPRECATED);
if($action==''){
	$tid=intval($_GET['tid']);
	$row=mysql_fetch_assoc(query("SELECT * FROM topic WHERE tid =".$tid));
	if(!$row)http_404();
	$sql2="select * from reply where tid='$tid' order by lastdate asc"; 
	$comment=result($sql2);
	$no=2;
	$comments="select * from reply order by pid desc limit 10";
	$best_comments=result($comments);
	include "themes/view.php";
}
if($action=='click'){
	$tid=intval($_GET['tid']);
	$sql="update topic set click=click+1 where tid='$tid'"; 
	query($sql);
	$click=value("topic","click","tid='$tid' LIMIT 0,1");
	exit(number_format($click));
}
if($action=='comment'){
	check();
	$tid=empty($_GET['tid'])?0:intval($_GET['tid']);
	$name=empty($_GET['nickname'])?'':trim(addslashes($_GET['nickname']));
	$email=empty($_GET['email'])?'':trim(addslashes($_GET['email']));
	$content=empty($_GET['content'])?'':trim(addslashes($_GET['content']));
	$content=html($content);
	$time=$_SERVER['REQUEST_TIME'];
	$agent=addslashes($_SERVER['HTTP_USER_AGENT']);
	if(isset($_SESSION['user_id'])){
		$user_id=$_SESSION['user_id'];
		$update_points="update user set user_point=user_point+2 where user_id='$user_id'"; 
		query($update_points); 
	}else{
		$user_id='';
	}
	$emailTo=empty($_GET['emailTo'])?'':trim(addslashes($_GET['emailTo']));
	$row=mysql_fetch_assoc(query("SELECT * FROM topic WHERE tid =".$tid));
	if($_SESSION['user_id']!=$row['user_id']){
		$topic_user=$row['user_id'];
		$notices="update user set user_notice=user_notice+1 where user_id='$topic_user'"; 
		query($notices); 
		include ('smtp.class.php');
		if(empty($_GET['emailTo'])){
			$subject = $name."评论了您的主题：".$row['title'];//邮件主题
			$subject = iconv('UTF-8','GB2312',$subject);
			$body = "<br/>主题：".$row['title']."<br/><br/><div style='background:#f9f9f9;padding:10px;border:1px solid #eee;color:#666'><strong style='padding-right:10px;'>".$name."</strong>"."说:".$content."</div>"."<br>"
			."<a href='http://".$_SERVER['SERVER_NAME']."/topic/tid-".$row['tid'].".html'>查看回应</a>"."<br>"
			."(邮件为系统发出，无需回复)";//邮件内容
			$body = iconv('UTF-8','GB2312',$body);
			$smtp = new smtp($config['smtp_server'],$config['smtp_user'],$config['smtp_pass'],true);
			$smtp->debug = FALSE;//是否显示发送的调试信息
			$smtp->send($row['email'], $config['smtp_user'], $subject, $body);
		}else{
			$subject = $name."回复了您的评论";//邮件主题
			$subject = iconv('UTF-8','GB2312',$subject);
			$body = "<br/>主题：".$row['title']."<br/><br/><div style='background:#f9f9f9;padding:10px;border:1px solid #eee;color:#666'><strong style='padding-right:10px;'>".$name."</strong>"."说:".$content."</div>"."<br>"
			."<a href='http://".$_SERVER['SERVER_NAME']."/topic/tid-".$row['tid'].".html'>查看回应</a>"."<br>"
			."(邮件为系统发出，无需回复)";//邮件内容
			$body = iconv('UTF-8','GB2312',$body);
			$smtp = new smtp($config['smtp_server'],$config['smtp_user'],$config['smtp_pass'],true);
			$smtp->debug = FALSE;//是否显示发送的调试信息
			$smtp->send($emailTo, $config['smtp_user'], $subject, $body);
		}
	}
	$sql="insert into reply set tid='$tid',nickname='$name',lastdate='$time',email='$email',content='$content',user_id='$user_id',agent='$agent'"; 
	query($sql); 
	$comments="update topic set comments=comments+1,lastdate=$time where tid='$tid'"; 
	query($comments); 
}
if ($action=='comment-list'){
	$tid=intval($_GET['tid']);
	$sql="select * from reply where tid='$tid' order by lastdate asc"; 
	$comment=result($sql);
	$no=2;
	include "themes/comment.php";
}
if($action=='delete'){
	if(!is_login())alert('您没有权限访问！');
	$pid = $_GET['pid']; 
	$row=mysql_fetch_assoc(query("SELECT * FROM reply WHERE pid =".$pid));
	$tid=$row['tid'];
	$comments="update topic set comments=comments-1 where tid='$tid'"; 
	query($comments); 
	if ($row['user_id']) {
		$user_id=$row['user_id'];
		$update_points="update user set user_point=IF(user_point>=2,user_point-2,user_point) where user_id='$user_id'"; 
		query($update_points); 
	}
	$sql="delete from reply where pid=".$pid; 
	query($sql);
}
if($action=='top'){
	$tid=$_GET['tid'];
	$lasttime=$_SERVER['REQUEST_TIME'];
	$sql="update topic set lastdate='$lasttime' where tid='$tid'";
	query($sql); 
}
?>