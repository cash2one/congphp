<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>个人资料 - <?php echo $config['sitename'];?></title>
<?php include 'common.php';?>
</head>
<body>
<?php include 'header.php';?>
<div id="contain">
<a class="topicTl" href="/user.php?action=profile">个人资料</a>
<form class="form" method="post" action="user.php?action=profile">
<label for="avatar">头像 (仅支持jpg格式，且文件小于1M,建议尺寸 200*200)</label>
<div class="center" id="avatar-layout">
<img src="<?php if($row['face']!=''){ ?><?php echo $row['face']?><?php }else{ ?>/resource/images/jy_home/pic.jpg<?php }?>"/><br /><br />
<a id="file_upload" class="btn">上传头像</a>
</div>
<br />
<div id="cropbox"></div>
<?php if(empty($row['email'])){?>
<label for="email">邮箱 <font color="red">(请完善您的邮箱地址)</font></label>
<input type="text" name="email" value="<?php echo $row['email'];?>"/>
<?php }else{?>
<input type="hidden" name="email" value="<?php echo $row['email'];?>"/>
<?php }?>
<label for="name">昵称</label>
<input type="text" name="chinese_name" value="<?php echo $row['chinese_name'];?>"/>
<label for="sex">性别</label>
<input type="radio" name="user_sex" value="0" <?php if($row['sex']==0){?>checked<?php }?>/> 男
<input type="radio" name="user_sex" value="1" <?php if($row['sex']==1){?>checked<?php }?>/> 女
<label for="weixin">微信号</label>
<input type="text" name="user_weixin" value="<?php echo $row['weixin'];?>" />
<label for="weibo">微博</label>
<input type="text" name="user_weibo" value="<?php echo $row['weibo'];?>" />
<input type="submit" name="submit" value="修改保存" class="btn" />
</form>
</div>
<br/>
<div class="clear"></div>
<?php include 'footer.php';?>
<link rel="stylesheet" href="/resource/js/jQuery/jquery.uploader.css" />
<link rel="stylesheet" href="/resource/js/jQuery/jquery.crop.css" />
<script src="/resource/js/jQuery/jquery.uploader.js"></script>
<script src="/resource/js/jQuery/jquery.crop.js"></script>
<script>
$(function(){
	$('#file_upload').uploader({
	    action:'/user.php?action=avatar&do=upload',
	   	swf:'/resource/swf/uploader.swf',
	    multi: true,
	    auto: true,
	    showQueue:false,
	    fileSizeLimit: '1024kb',
	    fileTypeDesc: '选择图片',
	    fileTypeExts: 'jpg',
	    onSuccess: function(e){
	    	$("#avatar-layout").hide();
	       crop_image("/data/cache/"+e.data);
	    }
	});
})
function crop_image(image){
	var html='<div style="margin:auto;width:200px;">'+
		'<img  src="'+image+'" id="croper" />'+
		'<input type="hidden" id="x"  class="input" style="width:50px" readonly/>'+
		'<input type="hidden" id="y"  class="input"style="width:50px"  readonly/>'+
		'<input type="hidden" id="w"  class="input" style="width:50px"  readonly/>'+
		'<input type="hidden" id="h" class="input" style="width:50px" readonly />'+
		'</div>'+
		'<div class="mr10 center"><input class="btn" type="button" value=" 裁剪 " id="crop_submit"/></div>';
	$('#cropbox').html(html);
	$('#croper').crop({
		aspectRatio: 1,
		allowSelect:false,
		allowResize:true,
		boxWidth:200,
		boxheight:200,
		setSelect:[0,0,100,100],
		onSelect:function(coords){
			$('#x').val(coords.x);
			$('#y').val(coords.y);
			$('#w').val(coords.w);
			$('#h').val(coords.h);
			//crop_image_preview(coords);
		},
		onChange:function(coords){
			$('#x').val(coords.x);
			$('#y').val(coords.y);
			$('#w').val(coords.w);
			$('#h').val(coords.h);
			//crop_image_preview(coords);
		}
	});
	$('#crop_submit').click(function(){
		var x=$('#x').val();
		var y=$('#y').val();
		var w=$('#w').val();
		var h=$('#h').val();
		$.get('/user.php?action=avatar&do=crop&image='+image+'&x='+x+'&y='+y+'&w='+w+'&h='+h,function(image){
			 window.location.href="/user.php?action=profile";
		})
	});
}
</script>
</body>
</html>