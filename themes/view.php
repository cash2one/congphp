<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $row['title']?> - <?php echo $config['sitename'];?></title>
<?php include 'common.php';?>
</head>
<body>
<script type="text/javascript">
	YUUR.update_click(<?php echo $row['tid']?>);
	YUUR.getComment(<?php echo $row['tid']?>);
</script>
<?php include 'header.php';?>

<div id="contain">
	<div class="leftC">
	<a class="topicBack" href="/">返回话题列表</a>
	<a class="topicTl" href="/topic/tid-<?php echo $row['tid']?>.html"><?php echo $row['title']?></a>
	<ul class="topicUl">
	<li class="topic">
		<div class="name">
			<?php if($row['user_id']){?>
			<?php $user=mysql_fetch_assoc(query("SELECT user_point,user_avatar FROM jy_member WHERE user_id =".$row['user_id'])); ?>
			<a href="/user.php?action=zone&card=<?php echo $row['user_id']?>"  title="查看会员名片" class="avatar">
			<?php if($row['user_id']==1){?>
			<span class="verifty" title="站长认证"></span>
			<?php }else if($user['user_point']>887){?>
			<span class="verifty" title="遇见达人认证"></span>
			<?php }?>
			<img src="<?php if($user['user_avatar']!=''){ ?><?php echo $user['user_avatar']?><?php }else{ ?>/common/avatar.jpg<?php }?>"/>
			</a>
			<?php }else{ ?>
			<img class="avatar" src="http://www.gravatar.com/avatar/<?php echo md5($row['email'])?>"/>
			<?php }?>
		</div>
		<div class="post">
		<span class="top" onClick="YUUR.topictid(<?php echo $row['tid']?>);">推 贴</span>
			<span class="author"><?php echo $row['nickname']?></span> <span class="time"><?php echo format_time($row['time'])?></span> <a class="time" href="javascript:;" onclick="replyAt('<?php echo $row['nickname']?>');">回复</a>
			<div class="post-info">
			<span class="right">楼主</span> <a id="click_count"><?php echo $row['click']?></a> 人浏览过
			</div>
		</div>
		<div class="topic-content">
		<?php echo $row['content']?>
		</div>
		<ul class="topic-share">
		<li><a class="share-icon weibo" href="http://service.weibo.com/share/share.php?title=<?php echo $row['title']?>&url=http://<?php echo $_SERVER['SERVER_NAME'];?>/topic/tid-<?php echo $row['tid']?>.html" target="_blank" rel="nofollow" title="分享到新浪微博"></a></li>
		<li><a class="share-icon qqweibo" href="http://v.t.qq.com/share/share.php?title=<?php echo $row['title']?>&url=http://<?php echo $_SERVER['SERVER_NAME'];?>/topic/tid-<?php echo $row['tid']?>.html" target="_blank" rel="nofollow" title="分享到腾讯微博"></a></li>
		<li><a class="share-icon douban" href="http://www.douban.com/recommend/?url=http://<?php echo $_SERVER['SERVER_NAME'];?>/topic/tid-<?php echo $row['tid']?>.html&title=<?php echo $row['title']?>" target="_blank" rel="nofollow" title="分享到豆瓣"></a></li>
		<li><a class="share-icon qzone" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://<?php echo $_SERVER['SERVER_NAME'];?>/topic/tid-<?php echo $row['tid']?>.html&title=<?php echo $row['title']?>" target="_blank" rel="nofollow" title="分享到QQ空间"></a></li>
		</ul>
		<div class="clear"></div>
	</li>
	</ul>
	<div id="comment" name="comment">
	<ul>
	<?php if($comment){?>
		<?php foreach($comment as $row){ ?> 
		<li id="comment-<?php echo $row['pid']?>" class="topic">
			<div class="name">
			<?php if($row['user_id']){?>
			<?php $user=mysql_fetch_assoc(query("SELECT user_point,user_avatar FROM jy_member WHERE user_id =".$row['user_id'])); ?>
			<a href="/card-<?php echo $row['user_id']?>.html"  title="查看会员名片" class="avatar">
			<?php if($row['user_id']==1){?>
			<span class="verifty" title="站长认证"></span>
			<?php }else if($user['user_point']>887){?>
			<span class="verifty" title="达人认证"></span>
			<?php }?>
			<img src="<?php if($user['user_avatar']!=''){ ?><?php echo $user['user_avatar']?><?php }else{ ?>/common/avatar.jpg<?php }?>"/>
			</a>
			<?php }else{ ?>
			<img class="avatar" src="http://www.gravatar.com/avatar/<?php echo md5($row['email'])?>"/>
			<?php }?>
			</div>
			<div class="post">
			<span class="author"><?php echo $row['nickname']?></span> <span class="time"><?php echo format_time($row['lastdate'])?></span>
				<div class="post-info">
				<span class="right"><?php if($no==2){?>沙发<?php }elseif($no==3){?>板凳<?php }else{?> #<?php echo $no ?><?php }?></span>来自 <?php echo getOS($row['agent'])?>
				</div>
			</div>
			<div class="topic-content">
			<?php echo $row['content']?>
			</div>
		</li>
		<?php $no++;?>
		<?php }?> 

		<?php }else{?>
		<li class="topic">
			<div class="center topicTl">沙发空缺中~</div>
		</li>
	<?php }?>  
	</ul>
	</div><!--评论结束 -->
	</div><!--左边盒子结束 -->

	<div class="rightC">
		<div class="box">
			<h3 class="boxhead">他们在说</h3>
			<?php foreach($best_comments as $row){ ?> 
			<div class="side-comment-list">
				<div class="side-comment-avatar">
				
				<?php $avatar=mysql_fetch_assoc(query("SELECT user_avatar FROM jy_member WHERE user_id =".$row['user_id'])); ?>
				<a href="/topic/tid-<?php echo $row['tid']?>.html"  title="<?php echo $row['nickname']?>">
				<?php if($row['user_id']){?>
				<img class="side-avatar" src="<?php if($avatar['user_avatar']!=''){ ?><?php echo $avatar['user_avatar']?><?php }else{ ?>/common/avatar.jpg<?php }?>"/>
				<?php }else{ ?>
				<img class="side-avatar" src="http://www.gravatar.com/avatar/<?php echo md5($row['email'])?>" title="<?php echo $row['nickname']?>"/>
				<?php }?>
				</a>
				</div>
				<div class="side-comment">
					<?php echo $row['content']?>
				<span class="side-comment-time">来自 <?php echo getOS($row['agent'])?> · <?php echo format_time($row['lastdate'])?></span>
				</div>
			</div>
			<?php }?> 
		</div>
	</div><!-- right end -->
	</div>
<div class="clear"></div>
<?php include 'footer.php';?>
</body>
</html>