<?php
	ob_start();
	require_once '../../system/config.php';
	require_once '../../system/function.php';
	ob_end_clean();	
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	$ridinfo=veri_rid($_COOKIE['rid'],$con);
	if (!$ridinfo) exit('<script type="text/javascript">location.href="/"</script>'); //判断是否登录
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	$userinfo=veri_user_here("$ridinfo[ucenter_id]",$con);
	$_SESSION['userinfo']=$userinfo;
 ?>

<!DOCTYPE html>
<html lang="zh-cn">
  <head>
  
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="stylesheet" type="text/css" href="https://travel.lyndons.cn/dist/simditor/styles/simditor.css" />
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/jquery.min.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/module.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/hotkeys.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/uploader.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/simditor.js"></script>

		
	<title>旅游中心 - 旅行管理系统</title>

	<!-- Bootstrap core CSS -->
	<link href="../../dist/css/bootstrap.css" rel="stylesheet">
	<link href="skin.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/js/jquery-ui.js"></script>
	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
	  <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	 
<style>
	.modal-content
	{
		max-width: 100%;
		width: auto;
	}
	</style>

</head>
  <body>
	  

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	  <div class="container">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="/" style="font-family:Microsoft YaHei">旅行管理系统</a>
	</div>
	<div class="navbar-collapse collapse">
	<ul class="nav navbar-nav">
	<li><a href="/">主页</a></li>	  
	<li><a href="/page/about">网站帮助与说明</a></li>
	<li class="active"><a href="#">旅游中心</a></li>
	  </ul>
	
	  <?php 
	echo '<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
	  					<a class="dropdown-toggle" data-toggle="dropdown" href="#">';
					echo $userinfo['username'];
	  			echo "<span class='caret'></span></a>
	<ul class='dropdown-menu'>
					<li role='presentation'><a role='menuitem' tabindex='-1' href='../../page/user'>个人中心</a></li>
					<li role='presentation' class='divider'></li>
					<li role='presentation'><a role='menuitem' tabindex='-1' href='../../page/password/?action=password_reset&rid=$_COOKIE[rid]'>修改密码</a></li>
					<li role='presentation' class='divider'></li>
					<li role='presentation'><a role='menuitem' tabindex='-1' href='../../system/signin.php?out=1'>退出登录</a></li>
  					</ul></li></ul>";
	
	?>
	</div><!--/.navbar-collapse -->
	  </div>
	</div>

	  

	<div class="container bs-docs-container">
	  <div class="row">
	<div class="col-md-3">
	  <div class="bs-sidebar hidden-print" role="complementary">
	<div class="left">   <!-- Main jumbotron for a primary marketing message or call to action -->

	 
	<ul class="nav nav-tabs nav-pills nav-stacked">
  <li class="active"><a href="#home" class="tab-pane" data-toggle="tab"><span class="glyphicon glyphicon-home"></span> 旅行中心</a></li>
  <li><a href="#class" data-toggle="tab"><span class="glyphicon glyphicon-check"></span> 我的旅行</a></li>
  <li><a href="#settings" data-toggle="tab"><span class="glyphicon glyphicon-cog"></span> 个人设置</a></li>
</ul></div>
	  </div>
	</div>
	<div class="col-md-9" role="main">
	  


<div class="bs-docs-section">
	<div class="tab-content">
		<div class="tab-pane fade in active" id="home">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h1 class="panel-title">旅行中心主页</h1>
				</div>
						<div class="panel-body">
							<?php 
							echo '<p>';
							echo $userinfo['username'];
							echo '，你好！欢迎来到旅行中心。这里会显示当前可报名的旅行项目以及一些你需要注意的事项。</p>';
							//以下代码需要大改，三年前水平所限遗留很多非常粗糙而且简陋的处理。。。。
							//总的来说，登录时判断first_edit是否为空，如空则显示首次填写，非空则不显示。任何一次个人设置（含后期修改）均写一次first_Edit。
							//要实现的功能大体有 旅游市场展示所有项目（带查看详情按钮）、报名及创建旅行（上传doc/docx/pdf/xls/xlsx/jpg/png文件，不超过5M；设置旅行暗号）、个人中心的管理旅行（我参加的、我创建的、导出参加人员清单）
					if ($userinfo['first_edit']){ // check if profile first edited
								?>你可以在此报名参加旅行或发起一个旅行。
								<hr />
						<a class="btn btn-success" role="button" href="#" id="enrolButton">报名旅行 &raquo;</a>　　<a class="btn btn-danger" role="button" href="#" id="createButton">创建旅行 &raquo;</a>								
						</div>
						</div>
				<div id="enrol" style="display:none">
						<div class="panel panel-success">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<p>请输入你的旅行项目暗号【发布者会提供给你】：<br />公开的旅行请在下面的项目列表中查找</p>
											<div>
												<div class="input-group" id="plan_id">
												<input name="plan_id" id="plan_id_in" oninput="get_plan(this.value)" type="text" placeholder="项目暗号" class="form-control">
												<span class="input-group-btn">
												<button id="get_plan_submit" onclick="open_plan_detail_byplanid($('#plan_id_in').val(),true)" class="form-control" type="button" disabled>请输入暗号</button>
												</span>
												</div>
											</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="create" style="display:none">
						<div class="panel panel-success">
						
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
											<label for="changecookie">发布旅行</label>
											
											<div class='input-group'>
												<p>旅行标题：<input type='text' id='pre_title' name='pre_title' class='form-control' placeholder='旅行标题' required autofocus></p>
												<p>目的地：<input type='text' id='pre_tgcity' name='pre_tgcity'  class='form-control' placeholder='目的地' required></p>
												<p>出发城市：<input type='text' id='pre_setoff' name='pre_setoff' class='form-control' placeholder='出发城市' required></p>
												<p>行程天数：<input name='email' id='pre_days' name='pre_days' type='text' class='form-control' placeholder='行程天数' required></p>
												<p>出发日期：<input type='text' id='pre_date'  name='pre_date' class='form-control' placeholder='出发日期' required></p>
												<p>人数限制：<input onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" type='text' id='pre_plimit'  name='pre_plimit' class='form-control' placeholder='人数限制' required></p>
												<p>价格预估：<input type='text' id='pre_price'  name='pre_price' class='form-control' placeholder='预计的价格，不含个人单独消费' required></p>
												<p>附加信息：<input type='text' id='pre_other'  name='pre_other' class='form-control' placeholder='其他需要说明的信息，可选'></p>
												</div></div></div><p>行程详情：<textarea id="detail" name="detail"  placeholder="<p>请输入<b>行程详情</b></p>" required></textarea></p>
												<hr />
												<script type="text/javascript">
													var editor = new Simditor({
													textarea: $('#detail')
													});
													</script>
									<div class="row">
									<div class="col-lg-6">
												<div class='input-group'>
												<p>是否公开，如公开请留空，不公开请设置项目暗号<br />项目暗号设置后不可修改</p>
												<div class='input-group'>
												<input name="plan_id_in" id="plan_id_set" oninput="check_plan(this.value)" type="text" placeholder="项目暗号" class="form-control">
												<span class="input-group-btn">
												<button id="check_plan_submit" class="form-control" type="button" disabled>请输入暗号</button>
												</span>
												</div>
												<div id='errmsg_post' style=”font-family:Microsoft YaHei,Arial;color:#E00;margin-top:10px;“></div>
												<br />
												<button id='post_plan_submit' class="btn btn-success btn-lg" onclick="submitData_Postplan()">发　布</button>
												<script type="text/javascript" src="post.js"></script>	    
												</div>
										
								</div>
							</div>
						</div>
						<div class="panel-footer">
						<p>你可以直接将word文档中的行程复制到上面的文本框中，文档格式会保留。<br /><b>关于附件</b>如需使用附件，请先发布旅行，然后到“我的旅行”->“我发布的”->“附件”中添加或删除附件。</p>
					</div>
				</div>
				
				</div>
					
					<div id="travel_list">
										<table class="table table-hover">
											<b><h2><center>旅行项目列表</center></h2></b>
											<thead>
											  <tr>
											<th>旅行项目</th>
											<th>人数限制</th>
											<th>是否公开</th>
													<th>操作</th>
											  </tr>
											</thead>
											<tbody>
											<tr>
													<? 
													$sql="select * from `travel_travel_plan`";
													$rs1=mysql_query($sql);
													while($travel=mysql_fetch_array($rs1)){
													?>
													<td><?=$travel['title']?></td>
													<td><?=$travel['plimit']?></td>
													<td><?php if(!$travel['plan_id']) {echo "是";}else{echo "否";}?></td>
											<td><?php
											if ($travel['plan_id']){
											echo '-';}else{
												echo "<a class='btn btn-primary' role='button' onclick='open_plan_detail($travel[id])'>查看详情 &raquo;</a>";
											}?>
												</td>	
											  </tr>
											</tbody>
													<?}?>
											  </table>
									</div>
								<?php
								}
							/*上面那Part 太愚蠢，html可以直接用echo输出，无需中断php，必须优化*/
							else{
								echo 
								"<p>注意，你尚未填写你的个人资料，请首先完善你的资料。</p></div></div>							
									<div class='panel panel-success'>
									<div class='panel-body'>
									<div class='row'>
  									<div class='col-lg-6'>
									 <div class='input-group' id='modify_data'>
									真实姓名：<input type='text' id='realname' name='realname' class='form-control' placeholder='真实姓名' required autofocus>
									身份证号：<input type='text' id='id_card' name='id_card'  class='form-control' placeholder='18位身份证号' required>
									护照/通行证类型及号码：<input type='text' id='passport' name='passport'  class='form-control' placeholder='多个护照/通行证请以逗号隔开'>
									电话号码：<input type='text' id='mobile' name='mobile' class='form-control' placeholder='电话号码' required>
									电子邮件：<input name='email' id='email' name='email' type='text' class='form-control' placeholder='邮箱' required>
	 								所在城市：<input type='text' id='city' name='city' class='form-control' placeholder='所在城市' required>
									真实性别：<input type='text' id='sex' name='sex' class='form-control' placeholder='性别' required>
									<p>以上除护照外均为<b>必填</b>。</p></div>
									<hr />
									<div id='errmsg' style='font-family:'Microsoft YaHei','Arial';color:#EE0000;'></div>
									<button class='btn btn-default btn-lg' onclick='submitDatafr()'>提交资料</button>
									<script type='text/javascript' src='profile.js'></script>
									<!-- /input-group -->
									 </div><!-- /.col-lg-6 -->
									</div><!-- /.row -->
									</div>
   									 <div class='panel-footer'>请注意：请务必填写你的<b>真实资料</b>，若填写有误请在个人设置修改。 <br />本站确保你的信息安全，但是不保证活动组织者不会泄露，请务必参加你可以信任的人组织的活动。</div>
									</div><!--class='panel panel-success'-->";
							}?>
							<div style="font-family:'Microsoft YaHei','Arial';color:#E00;margin-top:10px;">
							
							
							</div>
			</div>
				<div class="tab-pane fade" id="class"><div class="panel panel-primary">
					<div class="panel-heading">
						<h1 class="panel-title">我的旅行信息</h1>
					</div>
						<div class="panel-body">
							<p>这里为你展示的是你的旅行信息，你可在此管理你的报名以及你发起的旅行。</p>
					</div>
				</div> <div class="list-group bs-team">&nbsp;
	<?php
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	$sql="select * from `travel_enrol_data` where `uid`='$userinfo[uid]'";
	$rs=mysql_query($sql);

	?>
	<table class="table table-hover">
	<b><h2>我参与的</h2></b>
	<thead>
	  <tr>
	<th width=20%>暗号</th>
	<th width=40%>项目</th>
	<th width=20%>目的地</th>
			<th width=20%>详情</th>
	  </tr>
	</thead>
	<tbody>

	<tr>
			<?	while($result=mysql_fetch_array($rs)){ 
			$sql="select * from `travel_travel_plan` where `id`='$result[travel_plan_id]'";
			$rs1=mysql_query($sql);
			while($travel=mysql_fetch_array($rs1)){
			?>
			<td><?if($travel['plan_id']){echo $travel['plan_id'];}else{echo "-";}?></td>
			<td><?=$travel['title']?></td>
			<td><?=$travel['target_city']?></td>
	<td>
		<a href="javascript:void(0);" onclick="open_plan_detail('<?=$travel['id']?>')">查看详情</a> | 
		<a target="_attach" href="attachment/attach.php?id=<?=$travel['id']?>")>附件</a>
		</td>	
	  </tr>
	</tbody>
			<?}}?>
	  </table>
  </div>
  <hr />
  	<table class="table table-hover">
	<b><h2>我发起的</h2></b>
	<thead>
	  <tr>
	<th width=20%>暗号</th>
	<th width=40%>项目</th>
	<th width=20%>人数</th>
			<th width=20%>操作</th>
	  </tr>
	</thead>
	<tbody>

	<tr>
			<?
			$sql="select * from `travel_travel_plan` where `admin_id`='$userinfo[uid]'";
			$rs11=mysql_query($sql);	
			while($result=mysql_fetch_array($rs11)){ 
			$sql="select * from `travel_travel_plan` where `id`='$result[id]'";
			$rs1=mysql_query($sql);
			while($travelgo=mysql_fetch_array($rs1)){
			?>
			<td><?if($travelgo['plan_id']){echo $travelgo['plan_id'];}else{echo "-";}?></td>
			<td><?=$travelgo['title']?></td>
			<td><?php
				echo get_enrol_count($travelgo['id'],$con)."/".$travelgo['plimit'];//这一段代码输出报名人数?></td>
	<td>
		<a target="_edit" href="plan_edit.php?id=<?=$result['id']?>">编辑</a>
		| <a href="javascript:void(0);" onclick="open_plan_edit_panel('<?=$result['id']?>','data')">数据</a>
		| <a target="_attach" href="attachment/?id=<?=$result['id']?>")>附件</a>
		</td>	
	  </tr>
	</tbody>
			<?}}?>
	  </table>
  </div>
		<div class="tab-pane fade" id="settings"><div class="tab-pane" id="mytieba"><div class="panel panel-primary">
			<div class="panel-heading">
				<h1 class="panel-title">功能设置中心</h1>
			</div>
				<div class="panel-body">
					<p>这里为你提供相关功能的设置与控制以及资料修改。</p>	
		<?php if($value!="yes")echo"您尚未首次填写个人资料，请立即填写。</div>";?>
							</div></div>
<div class="panel panel-success">
<div class="panel-body">
<div class="row">
  <div class="col-lg-6">
	<label for="changecookie">修改个人资料：</label>
	<div class='input-group'>
	真实姓名：<input type='text' id='edit_realname' name='edit_realname' value='<?echo $userinfo['realname']; ?>'class='form-control' placeholder='真实姓名' required autofocus>
	身份证号：<input type='text' id='edit_id_card' name='edit_id_card' value='<?echo $userinfo['id_card']; ?>' class='form-control' placeholder='18位身份证号' required>
	护照/通行证类型及号码：<input type='text' id='edit_passport' value='<?echo $userinfo['passport']; ?>' name='edit_passport'  class='form-control' placeholder='多个护照/通行证请以逗号隔开'>
	电话号码：<input type='text' id='edit_mobile' value='<?echo $userinfo['mobile']; ?>'name='edit_mobile' class='form-control' placeholder='电话号码' required>
	电子邮件：<input name='edit_email' id='edit_email' value='<?echo $userinfo['email']; ?>'name='edit_email' type='text' class='form-control' placeholder='邮箱' required>
	所在城市：<input type='text' id='edit_city' value='<?echo $userinfo['city']; ?>' name='edit_city' class='form-control' placeholder='所在城市' required>
	真实性别：<input type='text' id='edit_sex' value='<?echo $userinfo['sex']; ?>' name='edit_sex' class='form-control' placeholder='性别' required>
	<div id='errmsg_eidt' style=”font-family:Microsoft YaHei,Arial;color:#E00;margin-top:10px;“></div>
	</br><button class="btn btn-danger btn-lg" name="change" value="edit" id="submit_button" type="submit">修　改</button>
	<script type="text/javascript" src="edit.js"></script>	    
	</div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</div>
	<div class="panel-footer">请注意：这里的资料默认显示为你已经填写的。
	<br />请按需要修改你需要修改的资料，<b>不需要修改的请保持默认。</b></div>
</div><!--class="panel panel-success"-->
</div>
</div>
</div>
</div>
</div>
</div>
</div>



	  <!--footer-->
	<div class="container">
	  <hr>
		
	  <footer>
	  <? include("../../footer.php");?> 
	</footer></div>
	 <!-- /container -->
<div class="modal fade" id="detail_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="plan_title">加载数据中...</h4>
			</div>
			<div class="modal-body" id="plan_detail">
				请稍后，正在请求数据...
			</div>
			<div class="modal-footer">
	   			<div id="enrol_plan_button"><button type="button" class="btn btn-default" data-dismiss="modal">关闭</button></div>
				
	 		</div>
		</div>
	</div>
</div>


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	
	<script src="../../dist/js/bootstrap.min.js"></script>
	  
  </body>
</html>
<script type='text/javascript' src='edit_plan.js'></script>
<script type="text/javascript">			
	var is_enrol_form= false;
	var is_create_form= false;
	$("#enrolButton").click(function()
	{
	if (is_enrol_form){
		$("#enrol").hide(300);
	is_enrol_form= false;}
	else{
		$("#enrol").show(300);
		is_enrol_form= true;
	}
	});
/*		function docheck()
{
	   alert("此功能暂不开放，请参加现有旅行。");
}*/

$("#createButton").click(function()
	{
	if (is_create_form){
		$("#create").hide(300);
		is_create_form= false;}
	else{
		$("#create").show(300);
		is_create_form= true;
	}
	});

$("#plan_id_in").keydown(
	function(e){
		if(e.keyCode==13)
			if($("#button").attr("disabled")!="true")
				open_plan_detail($("#plan_id_in").val(), true);
	});
	
function open_plan_detail(plan_id)
{
	var modal = $("#detail_modal");
	modal.modal();
	$("#plan_title").html("加载数据中...");
	$("#plan_detail").html("请稍后，正在请求数据...");
	// use JSON to download the data
	$.getJSON("get_plan_detail.php", {"id":plan_id}, function(json)
	{
		$(json).each(function(index, elem)
		{
			$("#"+elem.id).html(elem.html);
		})
	});

}

function open_plan_detail_byplanid(plan_id)
{
	var modal = $("#detail_modal");
	modal.modal();
	$("#plan_title").html("加载数据中...");
	$("#plan_detail").html("请稍后，正在请求数据...");
	// use JSON to download the data
	$.getJSON("get_plan_detail.php?use=planid", {"id":plan_id}, function(json)
	{
		$(json).each(function(index, elem)
		{
			$("#"+elem.id).html(elem.html);
		})
	});

}

function open_plan_edit_panel(plan_id,action)
{
	var editmodal = $("#detail_modal");
	editmodal.modal();
	$("#plan_title").html("加载数据中...");
	$("#plan_detail").html("请稍后，正在请求数据...");
	// use JSON to download the data
		if (action=="data"){
	$.getJSON("get_plan_data.php", {"id":plan_id}, function(json)
	{
		$(json).each(function(index, elem)
		{
			$("#"+elem.id).html(elem.html);
		})
	});
	}
	else{
		$.getJSON("get_plan_edit.php", {"id":plan_id}, function(json)
		{
		$(json).each(function(index, elem)
		{
			$("#"+elem.id).html(elem.html);
		})
		});
	}

}

function quitplan()
{
	$.post("submit.php",{action:"quit"},function(result){
   $("#enrol_plan_button").html(result);
  });
}

function enrol()
{
	$.post("submit.php",{action:"enrol"},function(result){
   $("#enrol_plan_button").html(result);
  });
}



function get_plan(id)
{
	var button = $("#get_plan_submit");
	button.html("查询中");
	button.attr("disabled", "true");
	
	if(id==""){
		button.html("请输入暗号");
	}else{
		$.get("have_plan.php", {"id":id}, function(data)
			{
				if (data == "1") 
				{
					button.removeAttr("disabled");
					button.html("查看详情");
				}
				else
				{
					button.html("不存在");
				}
			})
	}
}
function check_plan(id)
{
	var button = $("#check_plan_submit");
	button.html("查询中");
	button.attr("disabled", "true");
	var postbutton = $("#post_plan_submit");
	
	if(id==""){
		button.html("请输入暗号");
	}else{
		$.get("have_plan.php", {"id":id}, function(data)
			{
				if (data == "1") 
				{
					button.html("不可用");
					postbutton.attr("disabled", "true");
				}
				else
				{
					button.html("可用");
					postbutton.removeAttr("disabled");
				}
	})}
}
</script>