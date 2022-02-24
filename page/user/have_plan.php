<?php
// connect to mysql
require_once("../../system/config.php");
require_once("../../system/function.php");
	date_default_timezone_set("PRC");
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
$planid = $_GET['id'];
$json = Array();
$count = 0;
$sql="select * from `travel_travel_plan` where plan_id='$planid'";
$result=mysql_fetch_array(mysql_query($sql));
if($result)
{
echo "1";
exit;
}
echo "0";