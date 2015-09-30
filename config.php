<?php
# ================================================================
# 程序数据库及网站设置配置文件
# @update   2015.09.26
# @notice   您只能在不用于商业目的的前提下对程序代码进行修改和使用
# ================================================================

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('PRC');
$action=isset($_REQUEST['action'])?trim($_REQUEST['action']):'';
error_reporting(0);
$do=isset($_REQUEST['do'])?trim($_REQUEST['do']):'';
define('ROOT',dirname($_SERVER['SCRIPT_FILENAME']));
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('THEMES_ROOT',$_SERVER['DOCUMENT_ROOT']."/themes");

# 数据库连接配置

$db_host		= '192.168.1.236';	//数据库主机
$db_user		= 'root';		//数据库用户
$db_pass		= 'root';		//数据库密码
$db_name		= 'szjy'; 		//数据库名称(新建数据库名)
$tablepre       = 'jy_';

# 结束配置


# 网站信息配置

$config=array(
	'version' => 'V0.001', 		//程序版本号
	'sitename' => '胜网素质教育',				//站点名称
	'keywords' => '胜网,素质教育',	//站点关键字，用英文逗号分隔
	'description' => '素质教育网站！',					//网站描述
	'topiclimit'	=>	'20',			//首页讨论每页显示条数
	'smtp_server' => 'smtp.qq.com',		//邮件发送配置
	'smtp_user' => 'service@yuur.net',	//邮箱帐号	(推荐QQ邮箱)
	'smtp_pass' => '123456',			//邮箱密码	(一般为QQ密码)
	'qq_appid' => '',					//QQ互联的appid
	'qq_appkey' => '',					//QQ互联的appkey
	'qq_appcallback' => 'www.yuur.net/user.php?action=qq-callback'	//回调地址，更改前面域名为自己的即可
);

# 结束配置

$link = @mysql_connect($db_host,$db_user,$db_pass) or die('无法与数据库握手，请确认数据库名称是否正确');

mysql_query("SET NAMES 'utf8'");
mysql_select_db($db_name,$link);
session_start();
?>