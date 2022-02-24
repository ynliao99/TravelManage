$.ajaxSetup({ cache: false });
var pre_title=$("#pre_title");
var pre_tgcity=$("#pre_tgcity");
var pre_setoff=$("#pre_setoff");
var pre_days=$("#pre_days");
var pre_date=$("#pre_date");
var pre_plimit=$("#pre_plimit");
var detail=$("#detail");
var plan_id_in=$("#plan_id_set");
var pre_price=$("#pre_price");
var pre_other=$("#pre_other");
var errmsg_post=$("#errmsg_post");
var is_reg_form=false;

function submitData_Postplan()
{
	errmsg_post.html("Processing...");
	
		if(dataCheck_Postplan()){
			$("input").attr("disabled","disabled");
			$("#post_plan_submit").addClass("disabled");
			$("#post_plan_submit").text("提交中...");
			$("#post_plan_submit").unbind("click");
		var data={"action":"postplan","pre_title":pre_title.val(),"pre_tgcity":pre_tgcity.val(),"pre_setoff":pre_setoff.val(),"pre_days":pre_days.val(),"pre_date":pre_date.val(),"pre_plimit":pre_plimit.val(),"detail":detail.val(),"pre_price":pre_price.val(),"pre_other":pre_other.val(),"plan_id_in":$('#plan_id_set').val()};
		var url="submit.php";
		var callback=regCallback_Postplan;
		$.post(url,data,callback)};
}

function regCallback_Postplan(data)
{
		$("input").removeAttr("disabled");
			$("#post_plan_submit").removeClass("disabled");
			$("#post_plan_submit").text("发　布");
			$("#post_plan_submit").click(submitData_Postplan);
	switch(parseInt(data))
		{
			
			case 0:
			showMessage_Postplan("","发布成功，马上告诉你的小伙伴吧！");
			window.location.reload(true);
			break;
			case -1:
			showMessage_Postplan("","项目暗号已被使用或被保留，请更换！");
			plan_id_in.focus();
			break;
			case -5:
			showMessage_Postplan("","啊噢，服务器打了会儿瞌睡，请重试");
			break;			
		}
	
}
function dataCheck_Postplan()
{
	if(pre_title.val()==""||pre_title.val()==pre_title.attr("placeholder"))
	{
		showMessage_Postplan("错误","旅行项目标题不能为空");
		pre_title.focus();
		return false;
	}
	if(pre_tgcity.val()==""||pre_tgcity.val()==pre_tgcity.attr("placeholder"))
	{
		showMessage_Postplan("错误","目的地不能为空");
		pre_tgcity.focus();
		return false;
	}
	if(pre_setoff.val()==""||pre_setoff.val()==pre_setoff.attr("placeholder"))
	{
		showMessage_Postplan("错误","出发城市不能为空");
		pre_setoff.focus();
		return false;
	}
	if(pre_days.val()==""||pre_days.val()==pre_days.attr("placeholder"))
	{
		showMessage_Postplan("错误","行程天数不能为空");
		pre_days.focus();
		return false;
	}
	if(pre_date.val()==""||pre_date.val()==pre_date.attr("placeholder"))
	{
		showMessage_Postplan("错误","出发日期不能为空");
		pre_date.focus();
		return false;
	}	
	if(pre_plimit.val()==""||pre_plimit.val()==pre_plimit.attr("placeholder"))
	{
		showMessage_Postplan("错误","人数限制不能为空");
		pre_plimit.focus();
		return false;
	}
	if(pre_price.val()==""||pre_price.val()==pre_price.attr("placeholder"))
	{
		showMessage_Postplan("错误","价格预估不能为空");
		pre_price.focus();
		return false;
	}
	if(detail.val()==""||detail.val()==detail.attr("placeholder"))
	{
		showMessage_Postplan("错误","行程详情不能为空");
		detail.focus();
		return false;
	}
	
return true;
}
function showMessage_Postplan(useless,content)
{
	errmsg_post.html(content);
}