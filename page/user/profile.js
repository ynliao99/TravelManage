$.ajaxSetup({ cache: false });
var username=$("#username");
var id_card=$("#id_card");
var submitfr=$("#first_submit_button");
var realname=$("#realname");
submitfr.click(submitDatafr);
var reg_enter=$("#reg_enter");
var reg_tishi=$("#reg_tishi");
var mobile=$("#mobile");
var email=$("#email");
var passport=$("#passport");
var city=$("#city");
var sex=$("#sex");
var errmsg=$("#errmsg");

function submitDatafr()
{
	errmsg.html("");
	
		if(dataCheckfr()){
			$("input").attr("disabled","disabled");
			$("#first_submit_button").addClass("disabled");
			$("#first_submit_button").text("提交中...");
			$("#first_submit_button").unbind("click");
		var data={"realname":realname.val(),"mobile":mobile.val(),"id_card":id_card.val(),"email":email.val(),"city":city.val(),"passport":passport.val(),"sex":sex.val(),"action":"firstedit"};
		var url="submit.php";
		var callback=regCallbackfr;
		$.post(url,data,callback)};
}

function regCallbackfr(data)
{
		$("input").removeAttr("disabled");
			$("#first_submit_button").text("完成");
			$("#first_submit_button").click(submitDatafr);
	switch(parseInt(data))
		{
			
			case 0:
			showMessage("","完善好了~马上点击我的旅游去报名或者参加旅行吧~");
			window.location.reload(true);
			break;
			
			case -1:
			showMessage("","手机已被使用过，请重试");
			mobile.focus();
			break;
			
			case -3:
			showMessage("","你已完善过资料，如需修改请到个人设置修改");
			window.location.href="#";
			break;
			
			case -4:
			showMessage("","邮箱已被使用过了，请更换，有疑问请联系网站服务人员");
			email.focus();
			break;
			
			case -5:
			showMessage("","啊噢，服务器打了会儿瞌睡，请重试");
			break;			
		}
	
}
function dataCheckfr()
{
	if(realname.val()==""||realname.val()==realname.attr("placeholder"))
	{
		showMessage("错误","真实姓名不能为空");
		realname.focus();
		return false;
	}
	if(email.val()==""||email.val()==email.attr("placeholder"))
	{
		showMessage("错误","电子邮件不能为空");
		email.focus();
		return false;
	}
	if(mobile.val()==""||mobile.val()==mobile.attr("placeholder"))
	{
		showMessage("错误","手机号码不能为空");
		mobile.focus();
		return false;
	}
	if(city.val()==""||city.val()==city.attr("placeholder"))
	{
		showMessage("错误","所在城市不能为空");
		city.focus();
		return false;
	}
	if(sex.val()==""||sex.val()==sex.attr("placeholder"))
	{
		showMessage("错误","请提供性别以便安排住房");
		sex.focus();
		return false;
	}	
	reg=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
	if(!reg.test(email.val()))
	{
		showMessage("错误","电子邮件格式错误");
		email.focus();
		return false;
	}
	reg=/[0-9]{8,11}/;
	if(!reg.test(mobile.val()))
	{
		showMessage("错误","手机号码格式错误");
		mobile.focus();
		return false;
	}
	reg=/[0-9]{17}([0-9]|X)/;
	if(!reg.test(id_card.val()))
	{
		showMessage("错误","身份证号码格式错误");
		id_card.focus();
		return false;
	}
return true;
}
function showMessage(useless,content)
{
	errmsg.html(content);
}
$("input").keydown(
	function(e){
		if(e.keyCode==13)
			submitData();
	});