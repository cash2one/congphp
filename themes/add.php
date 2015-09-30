<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>发表话题 - <?php echo $config['sitename'];?></title>
<?php include 'common.php';?>
<link rel="stylesheet" href="/common/jquery.uploader.css" />
<script src="/common/jquery.uploader.js"></script>
</head>
<body>
<?php include 'header.php';?>
<div id="contain">
<div class="leftC">
<a class="topicTl" href="/"><span class="right">返回首页</span> 发表话题</a>
<form class="form" method="post" action="/?action=addtopic" id="topic-form">
	<label for="title">主题</label>
	<input type="text" name="title" id="title" placeholder="主题不能少于3个字"/>
	<?php if(isset($_SESSION['user_id'])){ ?>
	<input type="hidden" name="name" id="name" value="<?php echo $_SESSION['user_name'];?>" />
	<input type="hidden" name="email" id="email" value="<?php echo $_SESSION['user_email'];?>" />
	<?php }else{ ?>
	<label for="name">昵称</label>
	<input type="text" name="name" id="name" value="" />
	<label for="email">邮箱</label>
	<input type="text" name="email" id="email" value="" placeholder="留下您的邮箱，方便回帖邮件提醒您"/>
	<?php }?>
	<label>[提示]在内容框里粘帖图片地址即可发图 支持[新浪相册]  发视频直接粘贴视频地址即可 支持[优酷][土豆]</label>
	<textarea name="content" cols="20" rows="5" onkeydown="if(event.ctrlKey&&event.keyCode==13 || Key&&event.keyCode==10){document.getElementById('topic-submit').click();return false};" id="content" placeholder="说点儿什么吧"></textarea>
	<input type="hidden" name="picture" id="picture" value="" />
	<div id="emot-tool"></div>
	<div id="emot" style="bottom:30px;">
	</div>
	<a id="file_upload" class="btn" style="margin-left:20px;">选择一张图片</a>
	<script type="text/javascript">
	$(function(){
		$("#topic-form").submit(function(){
			var title=$("#title"),
				name=$("#name"),
				email=$("#email"),
				content=$("#content");
			var reg=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;
			if($.trim(title.val())==''||title.val().length<3){
				tip("主题不能少于3个字哦~");
				title.focus();
				return false;
			}
			if($.trim(name.val())==''){
				tip("昵称不能空着哦~");
				name.focus();
				return false;
			}
			if($.trim(email.val())==''){
				tip("邮箱不能空着哦~");
				email.focus();
				return false;
			}
			if(!reg.test(email.val())){
				tip("亲，邮箱的格式没填对哦");
				email.focus();
				return false;
			}
			if($.trim(content.val())==''||content.val().length<10){
				tip("内容太少了，亲~");
				content.focus();
				return false;
			}
			$("#topic-submit").val("提交中...");
			return true;
		});
		$('#file_upload').uploader({
		    action:'/?action=upload',
		   	swf:'/common/uploader.swf',
		    multi: false,
		    auto: true,
		    showQueue:false,
		    fileSizeLimit: '2M',
		    fileTypeDesc: '选择图片',
		    fileTypeExts: 'jpg',
			onProgress: function(e){
			    $('#file_upload').html('正在上传中...');
			},
		    onSuccess: function(e){
	        	$('#file_upload').html('上传成功！');
		    	editorInsert("http://<?php echo $_SERVER['SERVER_NAME'];?>/data/img/"+e.data+" ");
		    	$('#picture').val(e.data);
		    }
		});
		var emojiImg=YUUR.emoji();
		$("#emot").html(emojiImg).find("img").each(function(i){
			$(this).on("click",function(e){
				e.preventDefault();
				editorInsert('[e:'+i+']');
				$("#emot").fadeOut();
			});
		});
		$("#emot-tool").on("click",function(event){
			event.stopPropagation();
			$("#emot").fadeIn();
		});
	});
	$(document).click(function(){ 
		$("#emot").hide();
	});
	function editorInsert(content){
		var o=document.getElementById('content');
	        o.focus();
	    if(typeof document.selection!="undefined"){
	        document.selection.createRange().text=content; 
	    }else{
	    	var l=o.value.length;
	        o.value=o.value.substr(0,o.selectionStart)+content+o.value.substring(o.selectionStart,l);
	    }         
	}
	</script>
<input type="submit" name="submit" value="发表话题(Ctrl+Enter)" id="topic-submit" class="right btn" />
</form>
</div>
<div class="rightC">
	<?php if(isset($_SESSION['user_id'])){ ?>
	<?php if(empty($_SESSION['user_email'])){ ?>
	<div class="box">
		<div class="side-user-tip">亲爱的QQ用户，还需要<a href="/user.php?action=profile">绑定您的邮箱</a>才可以发帖哦</div>
	</div>
	<?php }?>
	<?php }?>
	<div class="box">
		<h3 class="boxhead">热门话题</h3>
		<ul class="list-topic">
		<?php foreach($hot_topics as $row){ ?> 
		<li><a href="/topic/tid-<?php echo $row['tid']?>.html" title="<?php echo $row['title']?>"><?php echo $row['title']?></a></li>
		<?php }?> 
		</ul>
	</div>
</div>
</div>
<div class="clear"></div>
<?php include 'footer.php';?>
</body>
</html>