<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $_SESSION['user_name']?> - <?php echo $config['sitename'];?> - 基于匿名社交的聊天社区</title>
<?php include 'common.php';?>
<script type="text/javascript">
$.ajax({
	type:'GET',
	url:'/user.php?action=clnotice',
	success:function(result){
		$(".notice").html(result);
	}
});
</script>
</head>
<body>
<?php include 'header.php';?>

<div id="contain">
	<div class="leftC">
	<h3 class="topicTl"><a class="panel" href='./?action=add'>我来冒泡</a> 我的话题</h3>
	<ul class="topicUl">
	<?php if($user_topic){?>
	<?php foreach($user_topic as $row){ ?> 
		<li class="topic">
			<div class="name">
			<?php if($row['user_id']){?>
			<?php $avatar=mysql_fetch_assoc(query("SELECT user_avatar FROM jy_member WHERE user_id =".$row['user_id'])); ?>
			<img class="avatar" src="<?php if($avatar['user_avatar']!=''){ ?><?php echo $avatar['user_avatar']?><?php }else{ ?>/common/avatar.jpg<?php }?>"/>
			<?php }else{ ?>
			<img class="avatar" src="http://www.gravatar.com/avatar/<?php echo md5($row['email'])?>"/>
			<?php }?>
			</div>
			<div class="post">
				<a class="title" href="/topic/tid-<?php echo $row['tid']?>.html"><?php echo $row['title']?></a>
				<div class="post-info">
				<span class="right">
				<?php if(isset($_SESSION['user_id'])&&$_SESSION['user_id']==$row['user_id']){?>
				<a href="./?action=edit&id=<?php echo $row['tid']?>">编辑</a>
				<a href="./?action=delete&id=<?php echo $row['tid']?>">删除</a>
				<?php }?>
				</span>

				<?php echo $row['comments']?> 回复 <span><?php echo $row['click']?> 浏览</span> <span><?php echo format_time($row['time'])?></span> <span><a href="/topic/tid-<?php echo $row['tid']?>.html#comment">查看详细</a></span>
				<?php if($row['comments']!=0){ ?>
				<span class="best"><?php echo $row['comments']?></span>
				<?php }?>
				</div>
			</div>
		</li>
	<?php }?> 
<?php }else{?>
<div class="center topicTl">没有话题 <u><a href='./?action=add'>发表话题</a></u></div>
<?php }?>  
	</ul>
	</div>
</div>
<div class="clear"></div>
<?php include 'footer.php';?>
</body>
</html>