<?php 
	header("Content-type: text/html; charset=utf-8");
	echo 'Redirecting... Please wait...';
	require_once '../../system/config.php';
	require_once '../../system/function.php';
	//↓获取cookie
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
	$sys_key=get_sys_key($con);
	
	//是否已登录
	if($_COOKIE['rid']){
		//echo $_COOKIE['rid'];
		$userinfo=veri_rid($_COOKIE['rid'],$con);
		if($userinfo){		
			echo '</br>您已登录，正在跳转到用户中心...';
			echo "<script language='javascript' type='text/javascript'>window.location.href='https://travel.lyndons.cn/page/user'</script>";
			exit;	
		}
	}
	
	//设置cookie
		$rid=getrid(get_decode_src($con));
		$time=date("Y-m-d H:i:s",time()+31536000);
		setcookie('rid', $rid, time()+31536000,"/");
		$cookie_set =mysql_query("INSERT INTO travel_cookie (cookie, exp_date) VALUES ('$rid', '$time')");
		//sqlinsert("travel_cookie","'cookie','v_date','exp_date'","'$rid','$nowtime','$time'",$con);
		if($cookie_set){
			$action="login";
			if($_GET['action']) $action=$_GET['action'];
			echo "<script language='javascript' type='text/javascript'>window.location.href='https://api.lyndons.cn/member/?sys_key=$sys_key&action=$action'</script>";
		}else{
			echo '系统错误，请重试。';
			echo "<script language='javascript' type='text/javascript'>window.location.href='https://travel.lyndons.cn'</script>";
		exit;
		}