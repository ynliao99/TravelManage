<?php
require_once("../../system/config.php");
require_once("../../system/function.php");
	$json = Array();
	$userinfo=$_SESSION['userinfo'];
	if(!$userinfo) exit("Access Denied.");
	date_default_timezone_set("PRC");
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	$planid = $_GET['id'];
	$_SESSION['current_plan_id']=$_GET['id'];
	$count = 0;
	$sql="select * from `travel_travel_plan` where id='$planid'";
	$result=mysql_fetch_array(mysql_query($sql));
	if($result)
	{
		if($result['admin_id']!=$userinfo['uid']){
			$json[0] = Array("id" => "plan_title", "html" => "你没有权限");
		$json[1] = Array("id" => "plan_detail", "html" => "错误！你不是该项目的管理员！");
		}else{	
		
		
		$head= "
				<table class='table table-hover'>
				<b><h2>项目参与者名单</h2></b>
				<thead>
				<tr>
					<th width=10%>姓名</th>
					<th width=20%>身份证号</th>
					<th width=10%>所在地</th>
					<th width=15%>电子邮件</th>
					<th width=15%>手机号码</th>
					<th width=20%>护照信息</th>
					<th width=10%>性别</th>
					</tr>
				</thead>
				<tbody>
					<tr>
				";
		$sql="select * from `travel_enrol_data` where `travel_plan_id`='$_SESSION[current_plan_id]'";
		$rs=mysql_query($sql);
		while($result=mysql_fetch_array($rs)){ 
		$sql="select * from `travel_member` where `uid`='$result[uid]'";
		$rs1=mysql_query($sql);
		while($enrol_data=mysql_fetch_array($rs1)){
		$body .= "
				
					<td>$enrol_data[realname]</td>
					<td>$enrol_data[id_card]</td>
					<td>$enrol_data[city]</td>
					<td>$enrol_data[email]</td>
					<td>$enrol_data[mobile]</td>
					<td>$enrol_data[passport]</td>
					<td>$enrol_data[sex]</td>
					</tr>
				";
		}}
		$footer= "
				</tbody>	
				</table>
		";
		$table=$head.$body.$footer;
		$json[0] = Array("id" => "plan_title", "html" => "报名名单");
		$json[1] = Array("id" => "plan_detail", "html" => $table);
		
		$json[2] = Array("id" => "enrol_plan_button", "html" => "下载的汇总表格为xls格式，若excel提示不匹配，直接打开即可
	   			<a target='_getdata' href='output_plan_data.php'><button id='enrol_b' type='button' class='btn btn-success'>下载汇总表格</button></a>
				<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>
		");
		}
	}else{
		$json[0] = Array("id" => "plan_title", "html" => '错误');
		$json[1] = Array("id" => "plan_detail", "html" => "<p>错误！id不存在。</p>");
	}
echo json_encode($json);
