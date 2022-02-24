<?php
	//php+MySQL 用户信息处理解决方案 For Travel Enrolling System 1.1 Alpha Coded by Lyndon 2014.06.01 Done.
	//2017.05.25适配新版程序，Mumu Travel 0.2α.
	require_once("../../system/config.php");
	require_once("../../system/function.php");
	date_default_timezone_set("PRC");
	$con=connectSQL($database_host,$database_port,$database_user,$database_pass,$database_name);
    $time=date('Y-m-d H:i:s');
	$userinfo=$_SESSION['userinfo'];
	if(!$userinfo) exit("Illegal Request.");
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	
	if($_POST['action']=="postplan"){
		//发布旅行 2017.5.28 Coded by Lyndon.
		$title=$_POST['pre_title'];
		$tgcity=$_POST['pre_tgcity'];
		$days=$_POST['pre_days'];
		$date=$_POST['pre_date'];
		$plimit=$_POST['pre_plimit'];
		$detail= htmlspecialchars($_POST['detail'],ENT_QUOTES);
		$other=$_POST['pre_other'];
		$setoff_city=$_POST['pre_setoff'];
		$price=$_POST['pre_price'];
		$plan_id=$_POST['plan_id_in'];
		if($plan_id){
			$sql="select * from `travel_travel_plan` where plan_id='$plan_id'";
			$result=mysql_fetch_array(mysql_query($sql));
			if($result) exit("-1");//检查暗号唯一性
		}
		$sql="INSERT INTO `travel_travel_plan`(`title`, `plan_id`, `admin_id`, `plimit`, `target_city`, `content`, `setoff_city`, `setoff_date`, `days` , `price`, `other`) VALUES ('$title','$plan_id','$userinfo[uid]','$plimit','$tgcity','$detail','$setoff_city','$date','$days','$price','$other')";
		$result=mysql_query($sql,$con);//创建旅行
		
		if(!$result)exit ("-5");
		exit ("0");
		
	}
	elseif($_POST['action']=="editplan"){
		//修改旅行
		$sql="select * from `travel_travel_plan` where `id`='$_SESSION[current_plan_id]'";
		$planinfo=mysql_fetch_array(mysql_query($sql));
		if($userinfo['uid']!=$planinfo['admin_id']) exit ("-1");
		
		$title=$_POST['plan_edit_title'];
		$tgcity=$_POST['plan_edit_tgcity'];
		$days=$_POST['plan_edit_days'];
		$date=$_POST['plan_edit_date'];
		$plimit=$_POST['plan_edit_plimit'];
		
		$other=$_POST['plan_edit_other'];
		$setoff_city=$_POST['plan_edit_setoff'];
		$price=$_POST['plan_edit_price'];
		$detail= htmlspecialchars($_POST['plan_edit_detail'],ENT_QUOTES);
		$sql="UPDATE `travel_travel_plan` SET title = '$title', plimit='$plimit', target_city='$tgcity',content='$detail', setoff_city='$setoff_city', days='$days', price='$price', other='$other', setoff_date='$date' WHERE id = '$_SESSION[current_plan_id]'";
		$result=mysql_query($sql,$con);
			if(!$result) exit ("-5");
			exit ("0");
	}elseif($_POST['action']=="deleteplan"){
		//删除旅行
		$sql="select * from `travel_travel_plan` where `id`='$_SESSION[current_plan_id]'";
		$planinfo=mysql_fetch_array(mysql_query($sql));
		if($userinfo['uid']!=$planinfo['admin_id']) exit ("-1");
		$sql="INSERT INTO travel_deleted_plan select * from travel_travel_plan WHERE id='$_SESSION[current_plan_id]'";
		mysql_query($sql,$con);
		$sql="DELETE FROM `travel_travel_plan` WHERE `id`='$_SESSION[current_plan_id]'";
		$result=mysql_query($sql,$con);
		if(!$result) exit ("-5");
		exit ("0");
	}else{
		
	$realname=$_POST['realname'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$city=$_POST['city'];
	$sex=$_POST['sex'];	
	$passport=$_POST['passport'];
	$id_card=$_POST['id_card'];
	$identy_token = get_phone_veri_code(6);
	$email_token=radom(32);
	
	if($_POST["change"]=="edit"){
	//修改用户资料 2014.5.30 Coded by Lyndon
	$sql="UPDATE `travel_member` SET city = '$city', first_edit='$time', realname='$realname',passport='$passport', email='$email', mobile='$mobile', id_card='$id_card', sex='$sex' WHERE uid = '$userinfo[uid]'";
	$result=mysql_query($sql,$con);
	if(!$result){
	echo "-5";
	exit;
	}else{
		$_SESSION['userinfo']=$result;
		echo "0";
		exit;}
	}
	
	elseif($_POST['action']=='enrol')
	{
		//报名 2017.5oded by Lyndon
		$sql="select * from `travel_enrol_data` where travel_plan_id='$_SESSION[current_plan_id]' and uid='$userinfo[uid]'";
		$result=mysql_fetch_array(mysql_query($sql));
		if($result){
			exit ("
				你报过这个旅游的名啦！
				<button id='cancel' type='button' class='btn btn-danger' onclick='quitplan()'>取消报名</button>
				<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>
			");
			}
				else
				{
					$sql="INSERT INTO `travel_enrol_data`(`travel_plan_id`, `uid`) VALUES ('$_SESSION[current_plan_id]','$userinfo[uid]')";
					$result=mysql_query($sql,$con);
					if(!$result){
						exit ("
						服务器打了个瞌睡，重试一次吧！
						<button id='enrol_b' type='button' class='btn btn-primary' onclick='enrol()'>报名</button>
						<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>
						");
					}else{
					exit ("
							报名成功！刷新页面即可在“我的旅行”看到~
							<button id='cancel' type='button' class='btn btn-danger' onclick='quitplan()'>取消报名</button>
							<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>
							");
							}
				}
			
	}
	elseif($_POST['action']=='quit')
	{
		$sql="DELETE FROM `travel_enrol_data` WHERE `travel_plan_id`='$_SESSION[current_plan_id]' AND `uid`='$userinfo[uid]'";
		$result=mysql_query($sql,$con);
			if(!$result){
				exit ("
				服务器打了个瞌睡，重试一次吧！
				<button id='cancel' type='button' class='btn btn-danger' onclick='quitplan()'>取消报名</button>
				<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>
				");
			}else{
				exit ("
				取消成功！刷新页面即可在“我的旅行”看到~
				<button id='enrol_b' type='button' class='btn btn-primary' onclick='enrol()'>报名</button>
				<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>
				");
				}

	}
	elseif($_POST["action"]=="firstedit"){
	//登记用户资料 2014.5.30 Coded by Lyndon
		$sql="select * from `travel_member` where `uid`='$uid'";
		$result=mysql_fetch_array(mysql_query($sql));
		if($result){
		echo "-3";
		exit;
		}
			$time=date("Y-m-d H:i:s",time()+600);
			$sql="select * from `travel_member` where mobile='$mobile'";
			$result=mysql_fetch_array(mysql_query($sql));
			if($result) exit ("-1");
			//检查手机号唯一性
			$sql="select * from `travel_member` where email='$email'";
			$result=mysql_fetch_array(mysql_query($sql));
			if($result) exit ("-4");
			//检查邮箱唯一性
			if ($_SESSION['userinfo']['first_edit']) exit ("-3");
			//检查是否已经完善
		
		//$sql="INSERT INTO `travel_member`(`uid`, `city`, `realname`, `email`, `mobile`, `id_card`, `activate`, `time`, `identy_token`, `pass`,`sex`,`email_token`,`first_edit`,`passport`) VALUES ('$uid','$city','$realname','$email','$mobile','$id_card','no','$time','$identy_token','no','$sex','$email_token','$time','$passport')";
		$sql="UPDATE `travel_member` SET first_edit='$time', identy_token='$identy_token', email_token='$email_token', city = '$city', realname='$realname',passport='$passport', email='$email', mobile='$mobile', id_card='$id_card', sex='$sex' WHERE uid = '$userinfo[uid]'";
		$result=mysql_query($sql,$con);
		if(!$result){
			echo "-5";
			exit;
	}else{
		$_SESSION['userinfo']=$result;
		echo "0";}
	}
	}
?>