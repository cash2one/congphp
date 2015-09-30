<?php
require_once 'config.php';
require_once 'function\function.php';
error_reporting(0);
if($action==''){
	if(!is_login())alert('请重新登陆！');
	$user_id=$_SESSION['user_id'];
	$sql="select * from topic where user_id=$user_id order by lastdate desc";
	$user_topic=result($sql);
	include "themes/user.php";
	exit;
}
if($action=='zone'){
	$user_id=intval($_GET['card']);
	$row=mysql_fetch_assoc(query("SELECT * FROM jy_member WHERE uid =".$user_id));
	include "themes/zone.php";
	exit;
}
if($action=='reg'){
	if(isset($_SESSION['user_id'])){ 
		@header("location:index.php");
	}else{
		include "themes/reg.php";
	}
}
if($action=='user-reg'){
	check();
	$user_name=empty($_POST['username'])?'':trim(addslashes($_POST['username']));
    $chinese_name=empty($_POST['chinese_name'])?'':trim(addslashes($_POST['chinese_name']));
    $group_id=$_POST['group_id'];
	$user_pass=empty($_POST['pass'])?'':md5($_POST['pass']);
	$user_pass_confirm=empty($_POST['pass_confirm'])?'':md5($_POST['pass_confirm']);
	$user_email=empty($_POST['email'])?'':trim(addslashes($_POST['email']));
	if(empty($user_email)){
		exit('ERROR:EMAIL');
	}
	if(!is_email($user_email)){
		exit('ERROR:EMAILX');
	}
	if(repeat("user",'user_email',$user_email)){
		exit('ERROR:EMAILED');
	}
	if(empty($user_pass)){
		exit('ERROR:PASS');
	}
	if($user_pass!==$user_pass_confirm){
		exit('ERROR:UNPASS');
	}
	if(empty($user_name)){
		exit('ERROR:NAME');
	}
	$sql="insert into jy_member set username='$user_name',password='$user_pass',email='$user_email',chinese_name='$chinese_name',group_id='$group_id'";
    query($sql);
	$ins_id=id();#获取新注册会员的id
	$_SESSION['user_id']=$ins_id;
	$_SESSION['user_email']=$user_email;
	$_SESSION['user_name']=$user_name;
    $_SESSION['groupid']=$group_id;
    $_SESSION['chinese_name']=$chinese_name;
    $_SESSION['pw']=$user_pass;
    if(isset($_SESSION['user_id'])){
        @header("location:index.php");
    }
}
if($action=='login'){
    if(!empty($_SESSION['user_id'])){
		@header("location:index.php");
	}else{
		include "themes/login.php";
	}
}
if($action=='user-login'){
	check();
    $out["state"]="err";
    $out["error"]="未知错误";
    if(isset($_POST['username']) && !empty($_POST['username'])){
        $username=$_POST['username'];
        $userpass=$_POST['password'];
        if(strlen($username)<1)$out["error"]="请输入账号！";
        else if(strlen($userpass)<1)$out["error"]="请输入密码！";
        else
        {
            $userpass=md5($userpass);
            $sql="select * from jy_member where `username`='$username'";
            $row=row($sql);
            if ($row['username']==$username){
                if ($row['password']==$userpass){
                    if($row['status']==0){
                        $_SESSION['user_id']=$row["uid"];
                        $_SESSION['user_name']=$username;
                        $_SESSION['groupid']=$row["group_id"];
                        $_SESSION['pw']=$row["password"];
                        $_SESSION['face']=$row["face"];
                        $_SESSION['chinese_name']=$row["chinese_name"];
                        $out["error"]="登陆成功！";
                        $out["state"]="ok";
                    }else{
                        $out["error"]="账号已停用";
                    }
                }
                else {
                    $out["error"]="密码错误";
                }
            }
            else {
                $out["error"]="用户名不存在！";
            }
        }
    }
    echo json_encode($out);
}
if($action=='qq-login'){
	$_SESSION['qq_appid']=$config['qq_appid']; 
	$_SESSION['qq_appkey']=$config['qq_appkey']; 
	$_SESSION['qq_appcallback']=$config['qq_appcallback']; 
	$_SESSION['qq_scope']= "get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo";
    $_SESSION['qq_state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $url="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=".$config['qq_appid']."&redirect_uri=".urlencode($config['qq_appcallback'])."&state=".$_SESSION['qq_state']."&scope=".$_SESSION['qq_scope'];
    header("Location:$url");
    exit;
}
if($action=='qq-callback'){
	#验证state防止CSRF攻击
    if($_GET['state']!= $_SESSION['qq_state']){
    	exit('Access denied!');
    }
    #请求访问
    $data = file_get_contents("https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=".$config['qq_appid']."&redirect_uri=".urlencode($config["qq_appcallback"])."&client_secret=".$_SESSION["qq_appkey"]."&code=".$_REQUEST["code"]);

    if (strpos($data, "callback") !== false){
        $lpos = strpos($data, "(");
        $rpos = strrpos($data, ")");
        $data  = substr($data, $lpos + 1, $rpos - $lpos -1);
        $msg = json_decode($data);
        if (isset($msg->error)){
            echo "<h3>error:</h3>" . $msg->error;
            echo "<h3>msg  :</h3>" . $msg->error_description;
            exit;
        }
    }
	$params = array();
	parse_str($data, $params);
   	if(isset($params["access_token"])){#获取OPENID
	    $data  = file_get_contents("https://graph.qq.com/oauth2.0/me?access_token=".$params["access_token"]);
	    if (strpos($data, "callback") !== false){
	        $lpos = strpos($data, "(");
	        $rpos = strrpos($data, ")");
	        $data  = substr($data, $lpos + 1, $rpos - $lpos -1);
	    }
	    $user = json_decode($data);
	    if (isset($user->error)){
	        echo "<h3>error:</h3>" . $user->error;
	        echo "<h3>msg  :</h3>" . $user->error_description;
	        exit;
	    }
    	$_SESSION["qq_token"] = $user->openid;
    	if(isset($user->openid)){#获取QQ信息
		    $data = file_get_contents("https://graph.qq.com/user/get_user_info?access_token=".$params["access_token"]."&oauth_consumer_key=" . $config["qq_appid"]. "&openid=" .$user->openid."&format=json");
		    $json = json_decode($data, true);
		    $_SESSION["qq_nickname"] = $json['nickname'];
		    $_SESSION["qq_avatar"] = $json['figureurl_qq_2'];
    	}
	}

    if(!empty($_SESSION['qq_token'])){
    	$row=row("SELECT * FROM jy_member WHERE qq_token='".$_SESSION['qq_token']."' LIMIT 1");
    	if($row){
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['user_name'];
			$_SESSION['user_email']=$row['user_email'];
			$_SESSION['user_avatar']=$row['user_avatar'];
			redirect('/');
		}else{
			$user_id=empty($_POST['id'])?0:intval($_POST['id']);
			$user_name=$_SESSION["qq_nickname"];
			$user_avatar=$_SESSION["qq_avatar"];
			$qq_token=$_SESSION['qq_token'];
			$sql="insert into user set user_id='$user_id',user_name='$user_name',user_avatar='$user_avatar',qq_token='$qq_token'"; 
			query($sql); 
			$ins_id=id();#获取新注册会员的id
			$_SESSION['user_id']=$ins_id;
			$_SESSION['user_name']=$user_name;
			$_SESSION['user_avatar']=$user_avatar;
			redirect('/');
		}
    }else{
    	exit('Access denied!');
    }  
    exit;
}
if($action=='logout'){
	unset($_SESSION['user_id'],$_SESSION['user_email'],$_SESSION['user_name'],$_SESSION['chinese_name'],$_SESSION['pw']);
    $_SESSION=array();
    redirect('login.html');
}
if($action=='profile'){
	if(!is_login())alert('请重新登陆！');
	if(isset($_POST['submit'])){
		$chinese_name=trim($_POST['chinese_name']);
		$user_email=trim(addslashes($_POST['email']));
		if(isset($_SESSION['user_id'])){
			if(empty($_SESSION['user_email'])){
				if(empty($user_email)){
					alert('邮箱不能为空');
				}
				if(!is_email($user_email)){
					alert('邮箱格式不正确');
				}
				if(repeat("user",'user_email',$user_email)){
					alert('邮箱已存在');
				}
			}
		}
		$user_sex=intval($_POST['user_sex']);
		//$user_sign=trim($_POST['user_sign']);
		$user_weixin=trim($_POST['user_weixin']);
		$user_weibo=trim($_POST['user_weibo']);
		$user_id=$_SESSION['user_id'];

		$sql="update jy_member set chinese_name='".$chinese_name."',email='".$user_email."',sex='".$user_sex."',weixin='".$user_weixin."',weibo='".$user_weibo."' where uid='".$user_id."'";
		query($sql);
		$_SESSION['chinese_name']=$chinese_name;
		$_SESSION['user_email']=$user_email;
		alert('修改成功');
	}
	$row=mysql_fetch_assoc(query("SELECT * FROM jy_member WHERE uid =".$_SESSION['user_id']));
	include 'themes/profile.php';
	exit;
}
if ($action=='notice'){
	$user_id=$_SESSION['user_id'];
	$notice=value("user","user_notice","user_id='$user_id' LIMIT 0,1");
	exit(number_format($notice));
}
if ($action=='clnotice'){
	if(!is_login())alert('请重新登陆！');
	$user_id=$_SESSION['user_id'];
	$user_notice='0';
	query("update user set user_notice='$user_notice' where user_id='$user_id'"); 
	$notice=value("user","user_notice","user_id='$user_id' LIMIT 0,1");
	exit(number_format($notice));
}
if($action=='avatar'){
	if(!is_login())alert('请重新登陆！');
	if($do=='upload'){
		if(!isset($_SESSION['user_id'])){
			exit('ERROR:LOGIN');
		}
		$file=upload($_FILES['file'],'data/cache/','jpg',1);
		echo $file;
		exit;
	}
	if($do=='crop'){
		$image=isset($_GET['image'])?trim($_GET['image']):exit();
		if(strpos($image,"jpg")===false&&strpos($image,"php")!==false){
			echo("ERROR:FILE");
			exit;
		}
		$x=isset($_GET['x'])?intval($_GET['x']):0;
		$y=isset($_GET['y'])?intval($_GET['y']):0;
		$w=isset($_GET['w'])?intval($_GET['w']):100;
		$h=isset($_GET['h'])?intval($_GET['h']):100;
		#载入图像
		$im=ImageCreateFromJpeg(DOCUMENT_ROOT.$image);
		$canvas=ImageCreateTrueColor(100,100);
			imagecopyresampled($canvas,$im,0,0,$x,$y,100,100,$w,$h);
		imagejpeg($canvas,ROOT.$image,100);
		imagedestroy($canvas);
		imagedestroy($im);
		if(copy(ROOT.$image,ROOT."/data/user/".$_SESSION['user_id'].".jpg")){
			@unlink(DOCUMENT_ROOT.$image);
		}
		$newavatar="/data/user/".$_SESSION['user_id'].".jpg";
		$user_id=$_SESSION['user_id'];
		query("update jy_member set face='$newavatar' where uid='$user_id'");
		echo $newavatar;
		$_SESSION['user_avatar']=$newavatar;
		exit;
	}
}
?>