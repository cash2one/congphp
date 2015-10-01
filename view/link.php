<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>链接管理 - <?php echo $config['sitename'];?></title>
<?php include ROOT.'/themes/common.php';?>
</head>
<body>
<?php include 'header.php';?>
<div id="contain">
<div class="leftC">
<a class="topicTl" href="/?action=link">返回链接管理</a>
<?php if($mode=='add'){?>
	<form class="form" method="post" action="?action=link&do=link_add">
	<input type="hidden" name="link_id" value=""/>
	<label for="title">链接名称</label>
	<input type="text" name="link_name" value=""/>
	<label for="title">链接描述</label>
	<input type="text" name="link_text" value=""/>
	<label for="title">链接地址(请以 http:// 开头)</label>
	<input type="text" name="link_url" value=""/>
	<input type="submit" name="submit" value="添加链接" class="btn" />
	</form>
<?php }elseif($mode=='edit'){?>
	<form class="form" method="post" action="?action=link&do=link_edit&link_id=<?php echo $row['link_id']?>">
	<label for="title">链接名称</label>
	<input type="text" name="link_name" value="<?php echo $row['link_name']?>"/>
	<label for="title">链接描述</label>
	<input type="text" name="link_text" value="<?php echo $row['link_text']?>"/>
	<label for="title">链接地址(请以 http:// 开头)</label>
	<input type="text" name="link_url" value="<?php echo $row['link_url']?>"/>
	<input type="submit" name="submit" value="修改保存" class="btn"/>
	</form>
<?php }elseif($mode==''){?>
	<table class="table">
		<thead>
		<tr>
		<th class="center" width="30">ID</th>
		<th class="center">链接名称</td>
		<th class="center">链接描述</td>
		<th class="center">链接地址</td>
		<th class="center">操作</td>
		</tr>
		</thead>
		<tbody>
		<?php foreach($links as $row){ ?> 
		<tr>
		<td align="center"><?php echo $row['link_id']?></td>
		<td align="center">
			<?php echo $row['link_name']?>
		</td>
  		<td align="center">
  			<?php echo $row['link_text']?>
  		</td>
		<td align="center">
			<?php echo $row['link_url']?>
		</td>
  		<td align="center">
  			<a href="/?action=link&do=link_edit&link_id=<?php echo $row['link_id']?>" title="">编辑</a>
  			<a href="/?action=link_delete&link_id=<?php echo $row['link_id']?>" title="">删除</a>
  		</td>
		</tr>
		<?php }?> 
		</tbody>
	</table>
	<a href="/?action=link&do=link_add" title="添加链接" class="btn mr10 right">添加链接</a>
<?php }?> 
</div>
</div>
<div class="clear"></div>
</body>
</html>