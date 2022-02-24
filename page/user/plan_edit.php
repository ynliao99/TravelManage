<?php
require_once("../../system/config.php");
require_once("../../system/function.php");
	
	$userinfo=$_SESSION['userinfo'];
	if(!$userinfo) exit("Access Denied.");
	date_default_timezone_set("PRC");
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	$planid = $_GET['id'];
	$count = 0;
	$sql="select * from `travel_travel_plan` where id='$planid'";
	$result=mysql_fetch_array(mysql_query($sql));
	if(!$result) exit('<script type="text/javascript">location.href="/"</script>');
	if($result['admin_id']!=$userinfo['uid']) exit('<script type="text/javascript">location.href="/"</script>');
			
		$target_city=$result['target_city'];
		$title=$result['title'];
		$setoff_city=$result['setoff_city'];
		$content=htmlspecialchars_decode($result['content'],ENT_QUOTES);
		$days=$result['days'];
		$price=$result['price'];
		$other=$result['other'];
		$setoff_date=$result['setoff_date'];
		$plimit=$result['plimit'];
		$_SESSION['current_plan_id']=$_GET['id'];
	
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

    <title>编辑旅行项目 - 旅行管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="/dist/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://travel.lyndons.cn/dist/simditor/styles/simditor.css" />
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/jquery.min.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/module.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/hotkeys.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/uploader.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/simditor/script/simditor.js"></script>
    <!-- Custom styles for this template -->
      <link href="/skin/body.css" rel="stylesheet">
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="https://travel.lyndons.cn/dist/js/jquery-ui.js"></script>
  
<style>
body{font-family:"ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","WenQuanYi Micro Hei",sans-serif;}
h1, .h1, h2, .h2, h3, .h3, h4, .h4, .lead {font-family:"ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","Microsoft YaHei UI","Microsoft YaHei","WenQuanYi Micro Hei",sans-serif;}
pre code { background: transparent; }
@media (min-width: 768px) {
    .bs-docs-home .bs-social, 
    .bs-docs-home .bs-masthead-links {
      margin-left: 0;
    }
}

.bs-docs-section p {
	line-height: 2;
}

.bs-docs-section p.lead {
	line-height: 1.4;
}
body {
  padding-top: 60px;
  
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
              
              <li><a href="/page/about">网站帮助及说明</a></li>
    		<li class="active"><a href="#">编辑旅行项目</a></li>

          </ul>
            
        </div><!--/.navbar-collapse -->
      </div>
    </div>	
	 <div class="container">
      <div class="row">
	  <div class="col-md-3">
	<div class="bs-sidebar hidden-print" role="complementary">
    <ul class="nav bs-sidenav">
     <li>
	<a href="javascript:CloseWebPage();">关闭页面 </a>
	</li>
	</ul>
    </div></div>
	<div class="col-md-9" role="main">
	<div class="bs-docs-section">
  <div class="page-header">
    <h1 id="info">编辑旅行——<?=$title?></h1>
  </div></div>
							<div class='panel-body'>
								<div class='row'>
									<div class='col-lg-6'>
										<?php echo "	
												<p>旅行标题：<input type='text' id='plan_edit_title' name='plan_edit_title' value='$title' class='form-control' placeholder='旅行标题' required autofocus></p>
												
												<p>目的地：<input type='text' id='plan_edit_tgcity'  class='form-control' placeholder='目的地' value='$target_city' required></p>
												
												<p>出发城市：<input type='text' id='plan_edit_setoff' class='form-control' placeholder='出发城市' value='$setoff_city' required></p>
												
												<p>行程天数：<input id='plan_edit_days'  type='text' class='form-control' placeholder='行程天数' value='$days' required></p>
												
												<p>出发日期：<input type='text' id='plan_edit_date'  class='form-control' placeholder='出发日期' value='$setoff_date' required></p>
												<p>人数限制：<input onkeyup=this.value=this.value.replace(/\D/g,'') onafterpaste=this.value=this.value.replace(/\D/g,'') type='text' id='plan_edit_plimit'  class='form-control' placeholder='人数限制' value='$plimit' required></p>
												
												<p>价格预估：<input type='text' value='$price' id='plan_edit_price' ' class='form-control' placeholder='预计的价格，不含个人单独消费' required></p>
												
												<p>附加信息：<input type='text' value='$other' id='plan_edit_other'  class='form-control' placeholder='其他需要说明的信息，可选'></p>
												
												</div></div>
												<p>行程详情：<textarea id='plan_edit_detail' name='plan_edit_detail'  placeholder='<p>请输入<b>行程详情</b></p>' required>$content</textarea></p>
												<hr />";?>
												<script type='text/javascript'>
													var editor = new Simditor({
													textarea: $('#plan_edit_detail')
													});
													</script>
						</div>
						<div class='panel-footer'>
						<p>你可以直接将word文档中的行程复制到上面的文本框中，文档格式会保留。<br /><b>关于附件</b>如需使用附件，请先保存旅行，然后到“我的旅行”->“我发布的”->“附件”中添加或删除附件。</p>
					</div>
				
		
	
				<div id='plan_mod_errmsg'></div>
				<button id='save_plan_button' type='button' class='btn btn-success' onclick='save_plan()'>保存修改</button>
				<button id='delete_plan_button' type='button' class='btn btn-danger' onclick='show_confirm_delete_plan()'>删除旅行</button>
				<a href='javascript:CloseWebPage();'><button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button></a>
				<script type='text/javascript' src="edit_plan.js"></script>
				</div>
				</div></div></div>
				</body>
				<hr>
				 <div class="container">
	 <footer>
          <? include("../../footer.php");?> 
      </footer>
	</div>
			<script type="text/javascript">
		function CloseWebPage(){
 		if (navigator.userAgent.indexOf("MSIE") > 0) {
  		if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
  		 window.opener = null;
 		  window.close();
		  } else {
  		 window.open('', '_top');
		   window.top.close();
		  }
 		}
		 else if (navigator.userAgent.indexOf("Firefox") > 0) {
		  window.location.href = 'about:blank ';
		 } else {
  		window.opener = null;
 		 window.open('', '_self', '');
  		window.close();
 		}
		}
		</script>
		</html>