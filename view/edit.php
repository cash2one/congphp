<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>编辑话题 - <?php echo $config['sitename'];?></title>
<?php include 'common.php';?>
</head>
<body>
<?php include 'header.php';?>
<div id="contain">
<div class="leftC">
<a class="topicTl" href="./">返回首页</a>
<form class="form" method="post" action="?action=editpost">
<input type="hidden" name="tid" value="<?php echo $row['tid']?>"/>
<label for="title">主题</label>
<input type="text" name="title" value="<?php echo $row['title']?>"/>
<input type="hidden" name="nickname" value="<?php echo $row['nickname'] ?>"/>
<input type="hidden" name="email" id="email" value="<?php echo $row['email'] ?>" />
<label>[提示]在内容框里粘帖图片地址即可发图 支持[新浪相册]  发视频直接粘贴视频地址即可 支持[优酷][土豆]</label>
<textarea name="content" rows="5"><?php echo strip($row['content'])?></textarea>
<input type="submit" name="submit" value="修改话题" class="right btn" />
</form>
</div>
</div>
</body>
</html>