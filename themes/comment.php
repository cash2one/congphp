<ul>
	<?php if($comment){?>
		<?php foreach($comment as $row){ ?> 
		<li id="comment-<?php echo $row['pid']?>" class="topic">
			<div class="name">
			<?php if($row['user_id']){?>
			<?php $user=mysql_fetch_assoc(query("SELECT user_point,user_avatar FROM jy_member WHERE user_id =".$row['user_id'])); ?>
			<a href="/user.php?action=zone&card=<?php echo $row['user_id']?>"  title="查看会员名片" class="avatar">
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
			<span class="author"><?php echo $row['nickname']?></span> <span class="time"><?php echo format_time($row['lastdate'])?></span> <a class="time" href="javascript:void(0)" onclick="replyAt('<?php echo $row['nickname']?>','<?php echo $row['email']?>');">回复</a>
				<div class="post-info">
				<span class="right">
				<?php if(isset($_SESSION['user_id'])){?>
				<?php if($_SESSION['user_id']==$row['user_id']||$_SESSION['user_id']==1){?>
				<a href="javascript:void(0)" onclick="YUUR.replyDel('<?php echo $row['pid']?>','<?php echo $row['tid']?>')">删除</a>
				<?php }?>
				<?php }?>
				<?php if($no==2){?>沙发<?php }elseif($no==3){?>板凳<?php }else{?> #<?php echo $no ?><?php }?>
				</span>
				来自 <?php echo getOS($row['agent'])?>
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
<div class="comment">
	<?php if(isset($_SESSION['user_id'])){ ?>
	<input type="hidden" name="nickname" id="nickname" value="<?php echo $_SESSION['user_name'];?>" />
	<input type="hidden" name="email" id="email" value="<?php echo $_SESSION['user_email'];?>" />
	<?php }else{ ?>
	<div class="showinput">
	<label for="name">昵称</label>
	<input type="text" name="nickname" id="nickname" value="" class="first-ipt" />
	<label for="email">邮箱</label>
	<input type="text" name="email" id="email" value="" />
	</div>
	<div id="welcome"></div>
	<?php }?>
	<input type="hidden" name="emailTo" id="emailTo" value="" />
	<textarea name="content" id="content" onkeydown="if(event.ctrlKey&&event.keyCode==13 || Key&&event.keyCode==10){document.getElementById('comment-submit').click();return false};" placeholder="我来说一句"></textarea>
	<div id="emot-tool"></div>
	<div id="emot">
	</div>
	<script type="text/javascript">
	$(function(){
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
	function replyAt(uname,emailTo){
		var content=$('textarea[name=content]');
		$('#emailTo').val(emailTo);
		content.focus();
		content.val(content.val().replace("@"+uname+" ","")+"@"+uname+" ");
	}
	</script>
	<input type="submit" value="回应" id="comment-submit" class="right btn" />
	<div class="clear"></div>
</div>