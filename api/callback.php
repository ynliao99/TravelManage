<?php

	require_once '../system/config.php';
	require_once '../system/function.php';

	//处理非法访问
	if(!$_GET['token']) exit('Illegal Request. API STRING NOT FOUND.');
	if(!$_COOKIE['rid']) exit('Illegal Request. PRELOGIN STRING NOT FOUND.');
	
	//验证token有效性
	//……
	//只可意会不可言传……
	//不想写……
	//懒得下笔……
	//好晚了……
	//现在是2017年5月20日 00:12:42……
	
	//现在是2017年5月21日16:39:03 用obstart和endclean解决了不明输出，终于可以解析json了
	if($_GET['action']=='login'){
	$token=$_GET['token'];
	//echo $token.'<br>';
	$checktoken=request_by_curl("https://api.lyndons.cn/class/checktoken.php","**********=$token");
	//print_r($checktoken);
	$result=json_decode($checktoken,true);	

	
	
	if($result['status']!='ok')	echo "<script type=text/javascript>location.href='https://travel.lyndons.cn/?islogin=fail'</script>";
	if($result['status']=='ok'){
		$exp_time=date("Y-m-d H:i:s",time()+31536000);
		$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
		if(!sqlfetch("SELECT * FROM `travel_api_bind` WHERE `rid`='$_COOKIE[rid]'",$con)) mysql_query("INSERT INTO travel_api_bind (rid,ucenter_id,username,exp_date) VALUES ('$_COOKIE[rid]', '$result[uid]','$result[username]','$exp_time')");//检查rid是否已与token绑定，如是，直接跳转，如否，添加一行
		if(!veri_user_here("$result[uid]",$con)) mysql_query("INSERT INTO travel_member (ucenter_id,username) VALUES ('$result[uid]','$result[username]')");//判断用户是否已在本站首次登录，如否则在本站注册
		echo 'Login with: ',$result['username'].'　正在跳转...';
		echo "<script type=text/javascript>location.href='/page/user'</script>";
	}
	}