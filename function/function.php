<?php
# ================================================================
# 程序函数库
# @core     yuur.net
# @author   biejun
# @update   2014.06.04
# @notice   您只能在不用于商业目的的前提下对程序代码进行修改和使用
# ================================================================


# HTML标签清除
function strip($str){
    $str = preg_replace('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i','$1',$str);
    return str_replace("<br />","",$str);
}
# 文本过滤
function html($str){
    $pattern="/(.*?)/iUs";
    preg_match_all($pattern, $str, $matches);
    $str=htmlspecialchars_decode($str);
    $str=stripslashes($str);
    if($matches[1]){
        foreach($matches[1] as $v){
            $replace[]= addslashes(htmlspecialchars(trim($v)));
        }
        $str = str_replace($matches[1], $replace, $str);
    } else{
        $str=strip_tags($str,"<img> <a> <strong> <font> <span> <em> <embed>");
    }
    $str = nl2br($str);
    $str = autoImg($str);
    if(strpos($str, 'player.youku.com')){
        $str = preg_replace('/http:\/\/player.youku.com\/player.php\/sid\/([a-zA-Z0-9\=]+)\/v.swf/', '<embed src="http://player.youku.com/player.php/sid/\1/v.swf" quality="high" width="600" height="492" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $str);
    }   
    if(strpos($str, 'v.youku.com')){
        $str = preg_replace('/http:\/\/v.youku.com\/v_show\/id_([a-zA-Z0-9\=]+)(\/|.html?)?/', '<embed src="http://player.youku.com/player.php/sid/\1/v.swf" quality="high" width="600" height="492" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $str);
    }
    if(strpos($str, 'www.tudou.com')){
        if(strpos($str, 'programs/view')){
            $str = preg_replace('/http:\/\/www.tudou.com\/(programs\/view|listplay)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<embed src="http://www.tudou.com/v/\2/" quality="high" width="600" height="420" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $str);
        }elseif(strpos($str, 'albumplay')){
            $str = preg_replace('/http:\/\/www.tudou.com\/(albumplay)\/([a-zA-Z0-9\=\_\-]+)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<embed src="http://www.tudou.com/a/\2/" quality="high" width="600" height="420" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $str);
        }else{
            $str = preg_replace('/http:\/\/www.tudou.com\/(programs\/view|listplay)\/([a-zA-Z0-9\=\_\-]+)(\/|.html?)?/', '<embed src="http://www.tudou.com/l/\2/" quality="high" width="600" height="420" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>', $str);
        }
    }
    for($i=0;$i<80;$i++){
        $str=str_replace("[e:".$i."]","<img src=\"/common/emot/".$i.".gif\" alt=\"\" align=\"absmiddle\"/>",$str);
    }
    $str = preg_replace_callback("/\@([^[:punct:]\s]{3,39})([\s]+)/",'atName', $str." ");
    $str = autoUrl($str); # 2014.06.25 新增

    return $str;
}
# @昵称加粗
function atName($str){
    return '<strong>@'.$str[1].'</strong>'.$str[2];
}
# 自动匹配图片
function autoImg($str){
    if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches)){
        for ($i = 0; $i < count($matches['0']); $i++){
            $period = '';
            if (preg_match("|\.$|", $matches['6'][$i])){
                $period = '.';
                $matches['6'][$i] = substr($matches['6'][$i], 0, -1);
            }
            $img_ext = array('jpg','png','gif','jpeg');
            $file_ext=strtolower(end(explode(".",$matches['0'][$i])));
            if(in_array($file_ext,$img_ext)){
                $str = str_replace(
                	$matches['0'][$i],
                    $matches['1'][$i].'<img src="http'.
                    $matches['4'][$i].'://'.
                    $matches['5'][$i].
                    $matches['6'][$i].'" alt="">'.
                    $period, $str);
            }
        }
    }
    return $str;
}
# 自动匹配链接
function autoUrl($str){
    return preg_replace("/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp):\/\/)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+)/i",'<a href="\\1\\3" target="_blank">\\1\\3</a>'," ".$str);
}
# 获取系统
function getOS($AGENT){
    if(strpos($AGENT,"Windows NT 5.1"))$os="Windows XP";
    elseif(strpos($AGENT,"Windows NT 6.1"))$os="Windows 7";
    elseif(strpos($AGENT,"Windows NT 6.2"))$os="Windows 8";
    elseif(strpos($AGENT,"unix"))$os="Unix";
    elseif(strpos($AGENT,"linux"))$os="Linux";
    elseif(strpos($AGENT,"iPhone"))$os="iPhone";
    elseif(strpos($AGENT,"iPad"))$os="iPad";
    elseif(strpos($AGENT,"Mac"))$os="Apple Mac";
    elseif(stripos($AGENT,"samsung"))$os="Samsung";
    elseif(strpos($AGENT,"Huawei"))$os="华为";
    elseif(stripos($AGENT,"HTC"))$os="HTC";
    elseif(stripos($AGENT,"SONY"))$os="SONY";
    elseif(stripos($AGENT,"xiaomi"))$os="小米";
    elseif(strpos($AGENT,"Android"))$os="Android";
    else $os="遇见网页版";
    return $os;
}
function http_404($url='/'){
    header("HTTP/1.1 404 Not Found");
    Header( "Location:$url");
    exit();
}



# ================================================
# 程序核心部分
# @core     yckit.com
# @author   jinzhe
# ================================================

# 获取文件后缀名
function get_ext($filename){
    if(!empty($filename)){
        $tmp_name=explode(".",strtolower($filename));
        return end($tmp_name);
    }
}
# 清除缓存
function clear_cache($filename=''){
    $dirs=array();
    $dirs[]=ROOT.'/data/cache/';
    if(empty($filename)){
        foreach ($dirs AS $dir){
            $folder = @opendir($dir);
            if ($folder === false){
                continue;
            }
            while ($file = readdir($folder)){
                if ($file == '.'||$file=='..'||$file=='index.htm'){
                    continue;
                }
                if (is_file($dir.$file)){
                     @unlink($dir . $file);
                }
            }
            closedir($folder);
        }
    }else{
        foreach ($dirs AS $dir){
            $folder = @opendir($dir);
            if ($folder === false){
                continue;
            }
            if (is_file($dir.$filename)){
                 @unlink($dir . $filename);
            }
            closedir($folder);
        }
    }
}
# 检查提交
function check(){
    if(empty($_SERVER['HTTP_REFERER'])||(preg_replace("/https?:\/\/([^\:\/]+).*/i","\\1",$_SERVER['HTTP_REFERER'])!=preg_replace("/([^\:]+).*/", "\\1",$_SERVER['HTTP_HOST']))){
        @header("HTTP/1.0 404 Not Found");
        exit();
    }
}
function remove_slashes($s){
    if(is_array($s)){
        foreach ($s as $k=>$v)$s[$k]=remove_slashes($v);
    }else{
        $s=stripslashes($s);
    }
    return $s;
}
# 创建文件夹
function mk_dir($dir,$mode=0777,$index=true) {
    if(!is_dir($dir)) {
        mk_dir(dirname($dir));
        mkdir($dir);
        if($index)@file_put_contents($dir.'/index.htm','');
    }
}
# 删除文件夹
function rm_dir($dir){
    $dh=opendir($dir);
    while($file=readdir($dh)){
        if($file!="."&&$file!=".."){
            $fullpath=$dir."/".$file;
            if(!is_dir($fullpath)){
                unlink($fullpath);
            }else{
                rm_dir($fullpath);
            }
        }
    }
    closedir($dh);
    if(rmdir($dir)){
        return true;
    }else{
        return false;
    }
}
# 上传文件
function upload($upload,$target='./',$exts='jpg,jpeg,gif,png,bmp,torrent,zip,rar,7z,doc,docx,xls,xlsx,ppt,pptx,csv,mp3,wma,swf,flv,txt',$size=20,$rename=''){
    mk_dir($target);
    if(is_array($upload['name'])){
        $return=array();
        foreach ($upload["name"] as $k=>$v){
            if (!empty($upload['name'][$k])){
                $ext=get_ext($upload['name'][$k]);
                if (strpos($exts,$ext)!==false&&upload_check($upload['tmp_name'][$k],$ext)==$ext&&$upload['size'][$k]<$size*1024*1024){
                    $name=empty($rename)?upload_name($ext):upload_rename($rename,$ext);
                    if (upload_move($upload['tmp_name'][$k],$target.$name)){
                        $return[]=$name;
                    }
                }
            }
        }
        return $return;
    }else{
        $return='';
        if (!empty($upload['name'])){
            $ext=get_ext($upload['name']);
            if(strpos($exts,$ext)!==false&&upload_check($upload['tmp_name'],$ext)==$ext&&$upload['size']<$size*1024*1024){
                $name=empty($rename)?upload_name($ext):upload_rename($rename,$ext);
                if (upload_move($upload['tmp_name'],$target.$name)){
                    $return=$name;
                }
            }
        }
    }
    return $return;
}
function upload_name($ext){
    $name=date('YmdHis');
    for ($i=0; $i < 3; $i++){
        $name.= chr(mt_rand(97, 122));
    }
    $name=strtoupper(md5($name)).".".$ext;
    return (string)$name;
}
function upload_rename($rename,$ext){
    $name=$rename.".".$ext;
    return (string)$name;
}
# 移动上传文件
function upload_move($from, $target= ''){
    if (function_exists("move_uploaded_file")){
        if (move_uploaded_file($from, $target)){
            @chmod($target,0755);
            return true;
        }
    }elseif (copy($from, $target)){
        @chmod($target,0755);
        return true;
    }
    return false;
}
# 检查上传文件
function upload_check($name,$ext){
    $str=$format='';
    $file=@fopen($name, 'rb');
    if ($file){
        $str=@fread($file, 0x400);
        @fclose($file);
        if (strlen($str) >= 2 ){
            if (substr($str, 0, 4)=='MThd' && $ext != 'txt'){
                $format='mid';
            }elseif (substr($str, 0, 4)=='RIFF' && $ext=='wav'){
                $format='wav';
            }elseif (substr($str ,0, 3)=="\xFF\xD8\xFF"){
                $format='jpg';
            }elseif (substr($str ,0, 4)=='GIF8' && $ext != 'txt'){
                $format='gif';
            }elseif (substr($str ,0, 8)=="\x89\x50\x4E\x47\x0D\x0A\x1A\x0A"){
                $format='png';
            }elseif (substr($str ,0, 2)=='BM' && $ext != 'txt'){
                $format='bmp';
            }elseif ((substr($str ,0, 3)=='CWS' || substr($str ,0, 3)=='FWS') && $ext != 'txt'){
                $format='swf';
            }elseif (substr($str ,0, 4)=="\xD0\xCF\x11\xE0"){   // D0CF11E==DOCFILE==Microsoft Office Document
                if (substr($str,0x200,4)=="\xEC\xA5\xC1\x00" || $ext=='doc'){
                    $format='doc';
                }elseif (substr($str,0x200,2)=="\x09\x08" || $ext=='xls'){
                    $format='xls';
                }elseif (substr($str,0x200,4)=="\xFD\xFF\xFF\xFF" || $ext=='ppt'){
                    $format='ppt';
                }
            }elseif (substr($str ,0, 2)=="7z"){
                $format='7z';
            }elseif (substr($str ,0, 4)=="PK\x03\x04"){
                $format='zip';
            }elseif (substr($str ,0, 4)=='Rar!' && $ext != 'txt'){
                $format='rar';
            }elseif (substr($str ,0, 4)=="\x25PDF"){
                $format='pdf';
            }elseif (substr($str ,0, 3)=="\x30\x82\x0A"){
                $format='cert';
            }elseif (substr($str ,0, 4)=='ITSF' && $ext != 'txt'){
                $format='chm';
            }elseif (substr($str ,0, 4)=="\x2ERMF"){
                $format='rm';
            }elseif ($ext=='sql'){
                $format='sql';
            }elseif ($ext=='txt'){
                $format='txt';
            }elseif ($ext=='htm'){
                $format='htm';
            }elseif ($ext=='html'){
                $format='html';
            }elseif (substr($str ,0, 3)=='FLV'){
                $format='flv';
            }else{
                $format=$ext;
            }
        }
    }
    return $format;
}
# 获取PHP_SELF
function get_self(){
    return isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:$_SERVER['SCRIPT_NAME'];
}
# 获取虚拟绝对路径
function get_url(){
    $php_self=get_self();
    $self=explode('/',$php_self);
    $self_count=count($self);
    $url='http://'.$_SERVER['SERVER_NAME'];
    if($self_count>1){
        $url.=str_replace('/'.$self[$self_count-1],'',$php_self);
    }
    if(substr($url,-1)!='/'){
        $url.='/';
    }
    return $url;
}
# 分页 $page_name 页面文件 $page_parameters 页面参数 $page_current 页面当前页面 $page_size 页面显示各数 $count 总数据
function pager($page_name,$page_parameters='',$page_current,$page_size,$count){
    parse_str($page_parameters);
    $page_count     =ceil($count/$page_size);
    $page_start     =$page_current-4;#开始
    $page_end       =$page_current+4;#结束
    if($page_current<=6){
        $page_start =1;
        $page_end   =9;
    }
    if($page_current>$page_count-4){
        $page_start =$page_count-8;
        $page_end   =$page_count;
    }
    if($page_start<1)$page_start=1;
    if($page_end>$page_count)$page_end=$page_count;
    $html="";
    $html.="<div id=\"pager\">";
    if($page_current!=1){
        $html.="<a href='".$page_name."?".$page_parameters."page=1'>‹</a>";
    }
    for($i=$page_start;$i<=$page_end;$i++){
        if($i==$page_current){
            $html.="<a href=\"#\" class=\"hover\">".$i."</a>";
        }else{
            $html.="<a href='".$page_name."?".$page_parameters."page=".$i."'>".$i."</a>";
        }
    }
    if($page_current!=$page_count){
        $html.="<a href='".$page_name."?".$page_parameters."page=".$page_count."'>›</a>";
    }
    $html.="</div>";
    return $html;
}
# 格式化时间戳
function format_time($time){
	$dur=$_SERVER['REQUEST_TIME']-$time;
	if($dur < 60)return $dur.'秒前';
	if($dur < 3600)return floor($dur/60).'分钟前';
	if($dur < 86400)return floor($dur/3600).'小时前';
	if($dur < 259200)return floor($dur/86400).'天前';
	return date('Y年m月d日',$time);
}
# 检查EMAIL合法性
function is_email($user_email){
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false){
        if (preg_match($chars, $user_email)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
#查询单行数据，返回数组
function row($sql){
	$temp;
	$result=query($sql);
    if ($result){
		$temp=mysql_fetch_array($result);
		mysql_free_result($result);
	}else{
		$temp=false;
	}
	return $temp;
}
#执行SQL
function query($sql){
	return mysql_query($sql);
}
#查询数据，返回数组
function result($sql){
	$temp=false;
    $result=query($sql);
    if($result){
        $array = array();
        while ($row = mysql_fetch_assoc($result)){
            $array[] = $row;
        }
        $temp=$array;
		mysql_free_result($result);
    }
	return $temp;
}
#获取指定字段返回数组
function value($table,$field,$where=''){
	if(empty($table)||empty($field))return false;
	$result=row("SELECT ".$field." FROM ".$table." WHERE ".$where."");
	return $result[0];
}
#获取指定字段返回布尔值
function repeat($table,$field,$value){
	$row=row("SELECT $field FROM $table WHERE $field='$value' LIMIT 1");
	return $row?true:false;
}
#获取新插入ID
function id(){
	global $db_host,$db_user,$db_pass;
	$link = @mysql_connect($db_host,$db_user,$db_pass) or die('无法与数据库握手');
    return mysql_insert_id($link);
}
#获取IP
function get_ip(){
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
#有提示跳转
function alert($text,$url=''){
	echo"<script type='text/javascript'>";
	echo"alert('$text');";
	if($url!=''){
		echo"location.href='$url';";
	}else{
		echo"history.back();";
	}
	echo"</script>";
	exit;
}
# 判断是否已登录
function is_login(){
    return isset($_SESSION['user_id'])?true:false;
}
# 无提示跳转
function redirect($url=""){
    echo"<script>location.href='$url';</script>";
    exit;
}

#调用模板文件
function display($template_dir) {
    $showpc = true;

    if ($_GET['mod']=="pc") {
        $showpc=true;
    }
    else if ($_GET['mod']=="mobile") {
        $showpc = false;
    }
    else if (isMobile()) {
        $showpc = false;
    }

    if ($showpc) // 电脑端访问
    {
        include THEMES_ROOT."/".$template_dir;
    }
    else {
        if(file_exists(THEMES_ROOT."/mobile/".$template_dir)) {
            include THEMES_ROOT."/mobile/".$template_dir;
        }
        else {
            include THEMES_ROOT."/".$template_dir;
        }
    }
}


function isMobile(){
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';

    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser',
        'UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');
    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) || CheckSubstrs($mobile_token_list,$useragent);
    if ($found_mobile){
        return true;
    }else{
        return false;
    }
}
if (isMobile()){
//echo 'Mobile';
    header('HTTP/1.1 404 Not Found');
    header('location: /404.html');
    exit();
}else{
//echo 'PC';
}

function CheckSubstrs($substrs,$text){
    foreach($substrs as $substr)
        if(false!==strpos($text,$substr)){
            return true;
        }
    return false;
}

@set_magic_quotes_runtime(0);
if(@get_magic_quotes_gpc()){
    $_GET=remove_slashes($_GET);
    $_POST=remove_slashes($_POST);
    $_COOKIE=remove_slashes($_COOKIE);
}
?>