<div class="jy_h_top">
    <?php
    if(!empty($_SESSION['user_id'])){
    ?>
        <div class="jy_h_top_nav"><a href="kaoqin.php?action=jiazhang_checklist">考勤</a>&nbsp;|&nbsp;<a href="/card-<?php echo $_SESSION['user_id']?>.html">我的名片</a>&nbsp;|&nbsp;<a href="/user.php?action=logout">退出</a>&nbsp;&nbsp; </div>
        <dl class="user_pic">
            <dt> <a href="/user.php?action=profile"><img src="<?php if($_SESSION['face']!=''){ echo $_SESSION['face'];?><?php }else{ ?>/resource/images/jy_home/pic.jpg<?php }?>" width="77" height="66" alt="头像" /></a> </dt>
            <dd> <a href="/user.php?action=profile"><?php echo $_SESSION['chinese_name'];?></a><br />
                欢迎您! 登陆<?php if($_SESSION['groupid']==1){echo '家长端';}elseif($_SESSION['groupid']==2){echo '学生端';}else{echo '老师端';} ?> </dd>
        </dl>
    <?php }?>
</div>
