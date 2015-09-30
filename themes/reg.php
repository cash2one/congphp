<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>注册 - <?php echo $config['sitename'];?></title>
<?php include 'common.php';?>
</head>
<body>
<?php include 'header.php';?>
<div id="contain">
<p></p>
<form class="form reg-login" action="user.php?action=user-reg" method="post">
<div class="side-user-tip" style="display:none"></div>
<div class="tit">新用户注册</div>
<label for="username">帐号</label>
<input type="text" name="username" id="username" class="input" />
<label for="email">Email</label>
<input type="text" name="email" id="email" class="input" />
<label for="pass">密码</label>
<input type="password" name="pass" class="input" id="pass" />
<label for="pass_confirm">确认密码</label>
<input type="password" name="pass_confirm" class="input" id="pass_confirm" />
<label for="chinese_name">昵称</label>
<input type="text" name="chinese_name" id="chinese_name" class="input" />
<label for="group_id">用户组：<select name="group_id"><option value="1">家长</option><option value="2">学生</option><option value="3">老师</option></select>
</label>
    <input type="submit" name="submit" value="注册" id="reg-submit" class="right btn" />
<span class="reg-tip">已有帐号？<a href="/login.html">直接登录</a></span>
</form>
</div>
<?php include 'footer.php';?>
</body>
</html>