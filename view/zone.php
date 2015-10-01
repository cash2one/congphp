<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $row['chinese_name']?></title>
<?php include 'common.php';?>
</head>
<body>
<?php include 'header.php';?>
<div id="contain">
	<div class="user-card">
		<div class="card-top">
			<img src="<?php if($row['face']!=''){ ?><?php echo $row['face']?><?php }else{ ?>/resource/images/jy_home/pic.jpg<?php }?>" class="card-avatar"/>
			<div class="card-nickname"><?php echo $row['chinese_name'];?></div>
			<?php if($row['user_sex']==0){?>男<?php }elseif($row['user_sex']==1){?>女<?php }?>
		</div>
		<ul class="card-info">
			<li class="card-profile"><span>昵称</span> <?php echo $row['chinese_name'];?></li>
			<li class="card-lable"></li>
			<li class="card-profile"><span>微信号</span> <?php echo $row['weixin'];?></li>
			<li class="card-lable"></li>
			<li class="card-profile"><span>微博</span> <?php echo $row['weibo'];?></li>
			<li class="card-lable"></li>
			<li class="card-profile"><span>积分</span> <?php echo $row['point'];?></li>
			<li class="card-lable"></li>
			<li class="card-profile"><span>个性签名</span> 
			<?php if($row['user_sign']!=''){?>
			<?php echo $row['user_sign'];?>
			<?php }else{?>
				<?php if($row['sex']==0){?>
				喜欢清新可爱的女生
				<?php }elseif($row['sex']==1){?>
				喜欢阳光帅气的男生
				<?php }?>
			<?php }?>
			</li>
		</ul>
	</div>
</div>
<?php include 'footer.php';?>
</body>
</html>