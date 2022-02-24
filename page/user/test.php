<?php
require_once("../../system/config.php");
require_once("../../system/function.php");
	$json = Array();

	date_default_timezone_set("PRC");
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	$planid = $_GET['id'];
	$count = 0;

		$target_city=$result['target_city'];
		$title=$result['title'];
		$setoff_city=$result['setoff_city'];
		$content=htmlspecialchars_decode($result['content'],ENT_QUOTES);
		$days=$result['days'];
		$price=$result['price'];
		$other=$result['other'];
		$sql="select * from `travel_enrol_data` where `uid`='$userinfo[uid]' and `travel_plan_id`='$result[id]'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$json[0] = Array("id" => "plan_title", "html" => $title);
		$json[1] = Array("id" => "plan_detail", "html" => "<p>目的地：$target_city</p>
		<p>行程详情：<br />你可以编辑以方便复制<textarea id='view_detail' name='view_detail'   disabled>$content</textarea></p>
		<hr />
		<script type='text/javascript'>
		var editor = new Simditor({
			textarea: $('#view_detail')
			});
		</script>
		<p>人数限制：$result[plimit]</p>
		<p>费用：$price</p>
		<p>其他信息：$other</p>");
	
		$json[2] = Array("id" => "enrol_plan_button", "html" => "
				<button id='cancel' type='button' class='btn btn-danger' onclick='quitplan()'>取消报名</button>
				<a href=attachment/attach.php?id=$result[id] target=_attach><button type='button' class='btn btn-success' >查看附件</button></a>
				<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>
		");
		

echo json_encode($json);
