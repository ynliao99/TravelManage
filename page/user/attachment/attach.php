<?php 
			ob_start();
			require_once '../../../system/config.php';
			require_once '../../../system/function.php';
			ob_end_clean();
			if(!$_SESSION['userinfo']) exit ("Access Denied.");
			if(!$_GET['id']) exit("Access Denied.");
			$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
			$sql="select * from `travel_travel_plan` where `id`='$_GET[id]'";
			$planinfo=mysql_fetch_array(mysql_query($sql));
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

    <title>查看附件 - 旅行管理系统</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

      <link href="css/body.css" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/blueimp-gallery.min.css">
<link rel="stylesheet" href="css/jquery.fileupload.css">
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
	<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>

  

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
                <li><a href="/page/user">用户中心</a></li>
              
              <li class="active"><a href="?id=<?=$_GET['id']?>">附件管理</a></li>
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
          </div>
        </div>
        <div class="col-md-9" role="main">
<!-- History
================================================== -->
<div class="bs-docs-section">
  <div class="page-header">
    <h1 id="info">查看附件——<?=$planinfo['title']?></h1>
  </div>
  <?php
  $sql="select * from `travel_enrol_data` where `uid`='$userinfo[uid]' and `travel_plan_id`='$_GET[id]'";
  $result=mysql_query($sql);
  if($result)
  {
	 $_SESSION['plan_dir']=$planinfo['id'];?>  
	<!--上传核心jquery文件-->
  <div id="attach">
	
    <form id="fileupload" action="//travel.lyndons.cn/" method="POST" enctype="multipart/form-data">
        <noscript><input type="hidden" name="redirect" value="https://travel.lyndons.cn"></noscript>
  
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">处理中...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                
            {% } %}
            {% if (!i) { %}
                
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">错误</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}><i class="glyphicon glyphicon-download"></i>点击下载</a>
                
            {% } else { %}
                
            {% } %}
        </td>
    </tr>
{% } %}
</script>
  <!-- 主体部分 -->
  </div><!--附件管理-->
  <!-- 引入各类脚本文件 -->
		<script src="js/jquery.min.js"></script>
		<script src="js/vendor/jquery.ui.widget.js"></script>
		<script src="js/tmpl.min.js"></script>
		<script src="js/load-image.all.min.js"></script>
		<script src="js/canvas-to-blob.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.blueimp-gallery.min.js"></script>
		<script src="js/jquery.iframe-transport.js"></script>
		<script src="js/jquery.fileupload.js"></script>
		<script src="js/jquery.fileupload-process.js"></script>
		<script src="js/jquery.fileupload-image.js"></script>
		<script src="js/jquery.fileupload-audio.js"></script>
		<script src="js/jquery.fileupload-video.js"></script>
		<script src="js/jquery.fileupload-validate.js"></script>
		<script src="js/jquery.fileupload-ui.js"></script>
		<script src="js/main.js"></script>
  
  <?php
  }else
  {
	  echo "你没有参加这个旅行！";
  }
  ?>
</div>
        </div>
      </div>
    
 
      <footer>
          <? include("../../../footer.php");?> 
      </footer>
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
		
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
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
  </body>
</html>
