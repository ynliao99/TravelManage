<?php
	ob_start();
	function GetIP() {
			if ($ip = getenv('HTTP_CLIENT_IP'));
			elseif ($ip = getenv('HTTP_X_FORWARDED_FOR'));
			elseif ($ip = getenv('HTTP_X_FORWARDED'));
			elseif ($ip = getenv('HTTP_FORWARDED_FOR'));
			elseif ($ip = getenv('HTTP_FORWARDED'));
			else    $ip = $_SERVER['REMOTE_ADDR'];
			return  $ip;
			}
			date_default_timezone_set("Asia/Shanghai");
			$fp = fopen("log.txt","a");
			fwrite($fp,"rn".date("Y-m-d H:i:s")."t");
			fwrite($fp,GetIP());
			fwrite($fp,"t");
			fwrite($fp,$_SERVER[HTTP_USER_AGENT]);
			fwrite($fp,"t");
			fclose($fp);
	require_once 'system/config.php';
	require_once 'system/function.php';
	ob_end_clean();	
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	$ridinfo=veri_rid($_COOKIE['rid'],$con);
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	$userinfo=veri_user_here("$ridinfo[ucenter_id]",$con)

 ?>

<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="旅行管理系统。">
    <meta name="author" content="Lyndon">
    <link rel="shortcut icon" href="favicon.ico">

    <title>旅行管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
      <link href="skin/body.css" rel="stylesheet">
	  
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
   
  

      
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
          <a class="navbar-brand" href="#" style="font-family:Microsoft YaHei">旅行管理系统</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <li class="active"><a href="#">主页</a></li>
              
                <li><a href="page/about">网站帮助及说明</a></li>


          </ul>
            
	</div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>木木出行（全功能Demo）</h1>
          <p>在这里，你可以发布一个旅行计划，然后叫上你的小伙伴来报名，通过我们提供的解决方案，你可以快速收集到报名同学的信息或者找到你想去的旅行。<br />　　——HMID账户中心成员网站</p><br />
      <p>
	  <?php
		if($userinfo){
			echo"
			<a class='btn btn-success btn-lg' role='button' href='page/user'>进入用户中心 &raquo;</a>
			";
		}else{
			echo"
			  <a class='btn btn-primary btn-lg' role='button' href='page/login'>立即登录 &raquo;</a>　<a class='btn btn-success btn-lg' role='button' href='page/login/?action=reg'>注册一个账户 &raquo;</a>
			";
		}
	  ?>
	  </p>
	  </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>安全</h2>
          <p>核心数据采用多重加密算法，采用SSL安全链接，用户信息不会泄漏。你还可以为你的旅行计划设置密码，只有知道密码的伙伴才能查看。 </p>
          <!--<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
        </div>
        <div class="col-md-4">
          <h2>高效</h2>
          <p>发布、报名一站式完成，管理员可一键下载参与者的信息。短信通知让你不会错过最新消息。 </p>
          <!--  <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
       </div>
        <div class="col-md-4">
          <h2>方便</h2>
            <p>全程傻瓜操作，就像发布一个调查问卷一样，更有针对毕业游等旅行定制的功能。</p>
          <!--<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
        </div>
      </div>

        

<!-- Modal -->

        
      <hr>
		
      <footer>
          <?php include("footer.php"); ?>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="dist/js/jquery-1.10.2.min.js"></script>
    <script src="/dist/js/bootstrap.min.js"></script>
  </body>
</html>
