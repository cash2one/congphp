<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>学生首页</title>
    <?php include THEMES_ROOT.'/common.php';?>
</head>
<body>
<div class="jy_h_content">
<div class="jy_h_top">
    <div class="jy_h_top_nav"><a href="kaoqin.php?action=jiazhang_checklist">考勤</a>&nbsp;|&nbsp;<a href="#">班级</a>&nbsp;|&nbsp;<a href="/user.php?action=logout">退出</a>&nbsp;&nbsp; </div>
    <dl class="user_pic">
        <dt> <a href="home.php?mod=space&uid=$_G[uid]"><img src="<?php if($row['face']!=''){ ?><?php echo $row['face']?><?php }else{ ?>/resource/images/jy_home/pic.jpg<?php }?>" width="77" height="66" alt="头像" /></a> </dt>
        <dd> <a href="/user.php?action=profile"><?php echo $_SESSION['chinese_name'];?></a><br />
            欢迎您! 登陆学生端 </dd>
    </dl>
</div>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" class="jy_portal">
  <tr>
    <td colspan="3" width="305"><a href="#"><img src="/resource/images/jy_home/xuesheng_03.jpg"  height="147" alt="我的班级"></a></td>
    <td width="45">&nbsp;</td>
    <td width="300"><a href="#"><img src="/resource/images/jy_home/xuesheng_05.jpg" width="300" height="147" alt="作业本"></a></td>
    <td width="12">&nbsp;</td>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_07.jpg" width="299" height="147" alt="自我测评"></a></td>
  </tr>
  <tr>
    <td height="15" colspan="7"></td>
  </tr>
  <tr>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_14.jpg" width="146" height="146" alt="我的邮箱"></a></td>
    <td width="12">&nbsp;</td>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_16.jpg" width="146" height="146" alt="我的问答"></a></td>
    <td>&nbsp;</td>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_12.jpg" width="300" height="146" alt="走进课堂"></a></td>
    <td>&nbsp;</td>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_13.jpg" width="299" height="146" alt="资源库"></a></td>
  </tr>
  <tr>
    <td height="15" colspan="7"></td>
  </tr>
  <tr>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_21.jpg" width="146" height="146" alt="总结反思"></a></td>
    <td>&nbsp;</td>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_22.jpg" width="146" height="146" alt="学习计划"></a></td>
    <td>&nbsp;</td>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_23.jpg" width="300" height="146" alt="学情跟踪"></a></td>
    <td>&nbsp;</td>
    <td><a href="#"><img src="/resource/images/jy_home/xuesheng_24.jpg" width="299" height="146" alt="云端课教学软件"></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php include THEMES_ROOT.'/footer.php';?>
</body>
</html>