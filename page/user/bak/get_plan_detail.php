<?php
$json = Array();
require_once("../../system/config.php");
require_once("../../system/function.php");
	date_default_timezone_set("PRC");
	$realname=$_POST["realname"];
	$mobile=$_POST["mobile"];
	$email=$_POST["email"];
	$city=$_POST["city"];
	$sex=$_POST["sex"];	
    $time=date('Y-m-d H:i:s');
	$uid=$_COOKIE['user_uid'];
	$id_card=$_POST["id_card"];
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
$planid = $_GET['id'];
$count = 0;
$sql="select * from `travel_travel_plan` where plan_id='$planid'";
$result=mysql_fetch_array(mysql_query($sql));
if($result)
{
	$target_city=$result['target_city'];
	$title=$result['title'];
	$setoff_city=$result['setoff_city'];
	$content=$result['content'];
	$days=$result['days'];
	$price=$result['price'];
	$other=$result['other'];
	$enrol="1";
	$json[0] = Array("id" => "plan_title", "html" => $title);
	$json[1] = Array("id" => "plan_detail", "html" => "<p>目的地：$target_city</p>
		<p>说明：$content</p>
		<p>费用：$price</p>
		<p>其他信息：$other</p>");
	mysql_close();

}
echo json_encode($json);
