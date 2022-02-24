$.ajaxSetup({ cache: false });
var edit_username=$("#edit_username");
var edit_id_card=$("#edit_id_card");
var edit_change="edit";
var edit_submit=$("#submit_button");
var edit_realname=$("#edit_realname");
var edit_passport=$("#edit_passport");
edit_submit.click(submitData);
var edit_mobile=$("#edit_mobile");
var edit_email=$("#edit_email");
var edit_city=$("#edit_city");
var edit_sex=$("#edit_sex");
var edit_errmsg=$("#errmsg_eidt");
var edit_is_reg_form=false;

function submitData()
{
	edit_errmsg.html("");
	
		if(dataCheck()){
			$("input").attr("disabled","disabled");
			$("#submit_button").addClass("disabled");
			$("#submit_button").text("提交中...");
			$("#submit_button").unbind("click");
		var data={"change":"edit","realname":edit_realname.val(),"mobile":edit_mobile.val(),"id_card":edit_id_card.val(),"email":edit_email.val(),"city":edit_city.val(),"passport":edit_passport.val(),"sex":edit_sex.val()};
		var url="submit.php";
		var callback=regCallback;
		$.post(url,data,callback)};
}

function regCallback(data)
{
		$("input").removeAttr("disabled");
			$("#submit_button").removeClass("disabled");
			$("#submit_button").text("修　改");
			$("#submit_button").click(submitData);
	switch(parseInt(data))
		{
			
			case 0:
			edit_showMessage("","修改完毕~马上点击我的旅游去报名或者参加旅行吧~");
			window.location.reload(true);
			break;
			case -1:
			edit_showMessage("","你所填写的用户名已被注册，请重试");
			edit_realname.focus();
			break;
			case -3:
			edit_showMessage("","你已完善过资料，如需修改请到个人设置修改");
			edit_realname.focus();
			break;
			case -4:
			edit_showMessage("","你所填写的邮箱已被注册，请重试");
			edit_email.focus();
			break;
			case -5:
			edit_showMessage("","啊噢，服务器打了会儿瞌睡，请重试");
			break;			
		}
	
}
function dataCheck()
{
	if(edit_realname.val()==""||edit_realname.val()==edit_realname.attr("placeholder"))
	{
		edit_showMessage("错误","真实姓名不能为空");
		edit_realname.focus();
		return false;
	}
	if(edit_email.val()==""||edit_email.val()==edit_email.attr("placeholder"))
	{
		edit_showMessage("错误","电子邮件不能为空");
		edit_email.focus();
		return false;
	}
	if(edit_mobile.val()==""||edit_mobile.val()==edit_mobile.attr("placeholder"))
	{
		edit_showMessage("错误","手机号码不能为空");
		edit_mobile.focus();
		return false;
	}
	if(edit_city.val()==""||edit_city.val()==edit_city.attr("placeholder"))
	{
		edit_showMessage("错误","所在城市不能为空");
		edit_city.focus();
		return false;
	}
	if(edit_sex.val()==""||edit_sex.val()==edit_sex.attr("placeholder"))
	{
		edit_showMessage("错误","请提供性别以便安排住房");
		edit_sex.focus();
		return false;
	}	
	edit_reg=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
	if(!edit_reg.test(edit_email.val()))
	{
		edit_showMessage("错误","电子邮件格式错误");
		edit_email.focus();
		return false;
	}
	edit_reg=/[0-9]{8,11}/;
	if(!edit_reg.test(edit_mobile.val()))
	{
		edit_showMessage("错误","手机号码格式错误");
		edit_mobile.focus();
		return false;
	}
	edit_reg=/[0-9]{17}([0-9]|X)/;
	if(!edit_reg.test(edit_id_card.val()))
	{
		edit_showMessage("错误","身份证号码格式错误");
		edit_id_card.focus();
		return false;
	}
return true;
}
function edit_showMessage(useless,content)
{
	edit_errmsg.html(content);
}
$("#modify_data input").keydown(
	function(e){
		if(e.keyCode==13)
			submitData();
	});