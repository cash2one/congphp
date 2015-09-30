<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="keywords" content="<?php echo $config['keywords'];?>">
    <meta name="description" content="<?php echo $config['description'];?>">
    <?php include THEMES_ROOT.'/common.php';?>
    <link href="/resource/js/ligerui/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
    <script src="/resource/js/ligerui/js/core/base.js" type="text/javascript"></script>
    <script src="/resource/js/ligerui/js/plugins/ligerGrid.js" type="text/javascript"></script>
    <script src="/resource/js/ligerui/js/plugins/ligerResizable.js" type="text/javascript"></script>
    <script src="/resource/js/ligerui/js/plugins/ligerDrag.js" type="text/javascript"></script>
    <script type="text/javascript">
        var g;
        $(function ()
        {
            <?php
            echo<<<EOT
var kaoqinData ={Rows:[$kaoqin_data],Total:91};
EOT;
            ?>
            g = $("#maingrid4").ligerGrid({
                columns: [
                    {display: '主键', name: 'id', align: 'left', width: 120 } ,
                    { display: '时间', name: 'record_date', minWidth: 60 }
                ], data: kaoqinData, pageSize: 20, sortName: 'id',
                width: '100%', height: '98%', checkbox: true,rownumbers:true,
                fixedCellHeight:false
            });
            $("#kq_serch").click(function(){
               var serch_value=$("#serch_value").val();
               var serch_type=$("input[type='radio']:checked").val();
               if(serch_value!='' && serch_type!=''){
                   $.ajax({url:"kaoqin.php?action=ajax_serch",type:"POST",data:"serch_value="+serch_value+"&serch_type="+serch_type,dataType:"json",success:function(data){
                    // console.log(data);
                       if(data.flag==false){
                           alert(data.msg);
                       }else if(data.Total>0){
                           g.loadData(data);
                       }
                   }});
               }else{
                   alert('请输入要搜索的学号或班级!');
               }
            });
            $("#pageloading").hide();

        });
    </script>
</head>
<body>
<?php include THEMES_ROOT.'/header.php';?>
<div class="l-loading" style="display: block" id="pageloading">
</div>
<div style="width: 950px;margin: 0px auto;padding: 5px; background-color:#ffffff;">
    <p class="cpath">当前位置：<a href="/">首页</a> | <a href="#">考勤</a></p>
<?php if($_SESSION['groupid']!=2){?>
<div style="height: 30px; line-height: 30px;">
<input type="text" name="serch" id="serch_value" style="height: 20px;line-height: 20px;color:#999999;" value="在这里输出搜索内容" onfocus="if(this.value==&#039;在这里输出搜索内容&#039;) this.value=&#039;&#039;;this.style.color=&#039;#333&#039;" onblur="if(this.value==&#039;&#039;) {this.value=&#039;在这里输出搜索内容&#039;;this.style.color=&#039;#999999&#039;}">
    <input type="radio" id="sk" value="sk" name="stype" checked><label for="sk">学号</label>
    <?php if($_SESSION['groupid']==3){?><input type="radio" id="bz" value="bz" name="stype"><label for="bz">班级</label><?php }?>
    <button value="搜索" id="kq_serch">搜索</button>
</div>
<?php }?>
<div id="maingrid4" style="margin: 0; padding: 0">
</div>
</div>
<div style="display: none;">
</div>
<?php include THEMES_ROOT.'/footer.php';?>
</body>
</html>
