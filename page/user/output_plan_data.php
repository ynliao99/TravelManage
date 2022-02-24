<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	header('Content-Type: text/xls');
    header("Content-type:application/vnd.ms-excel;charset=utf-8");
    $str = mb_convert_encoding("enrol_data_export", 'gbk', 'utf-8');
    header('Content-Disposition: attachment;filename="' . $str . '.xls"');
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header("Content-Transfer-Encoding:binary");
	
	require_once("../../system/config.php");
	require_once("../../system/function.php");
	
	$json = Array();
	$userinfo=$_SESSION['userinfo'];
	if(!$userinfo) exit("Access Denied.");
	date_default_timezone_set("PRC");
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	$count = 0;
	$sql="select * from `travel_travel_plan` where id='$_SESSION[current_plan_id]'";
	$result=mysql_fetch_array(mysql_query($sql));
	if($result)
	{
		if($result['admin_id']!=$userinfo['uid']){
		exit ("错误！你不是该项目的管理员！");
		}else{	
		
		
		
		
		?>
				<table>
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
		<?
		$sql="select * from `travel_enrol_data` where `travel_plan_id`='$_SESSION[current_plan_id]'";
		$rs=mysql_query($sql);
		while($result=mysql_fetch_array($rs)){ 
		$sql="select * from `travel_member` where `uid`='$result[uid]'";
		$rs1=mysql_query($sql);
		while($enrol_data=mysql_fetch_array($rs1)){
		?>
				
					<td><?= (string)$enrol_data[realname]?></td>
					<td><?= (string)$enrol_data[id_card]?></td>
					<td><?= (string)$enrol_data[city]?></td>
					<td><?= (string)$enrol_data[email]?></td>
					<td><?= (string)$enrol_data[mobile]?></td>
					<td><?= (string)$enrol_data[passport]?></td>
					<td><?= (string)$enrol_data[sex]?></td>
					</tr>
		<?
		}}
		?>
				</tbody>	
				</table>
		<?
		
		}
	}else {
		?>
			该项目不存在
		<?
		}
		?>