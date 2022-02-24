$.ajaxSetup({ cache: false });
var plan_edit_title=$("#plan_edit_title");
	var plan_edit_tgcity=$("#plan_edit_tgcity");
	var plan_edit_setoff=$("#plan_edit_setoff");
	var plan_edit_days=$("#plan_edit_days");
	var plan_edit_date=$("#plan_edit_date");
	var plan_edit_plimit=$("#plan_edit_plimit");
	var plan_edit_detail=$("#plan_edit_detail");
	var plan_edit_price=$("#plan_edit_price");
	var plan_edit_other=$("#plan_edit_other");
	var plan_mod_errmsg=$("#plan_mod_errmsg");
	var delete_plan_set = false;
$("#save_plan_button").click(save_plan);
function save_plan()
{
	
	plan_mod_errmsg.html("Processing...");
	
		if(dataCheck_Editplan()){
			$("input").attr("disabled","disabled");
			$("#save_plan_button").addClass("disabled");
			$("#save_plan_button").text("提交中...");
			$("#save_plan_button").unbind("click");
		var data={"action":"editplan","plan_edit_title":plan_edit_title.val(),"plan_edit_tgcity":plan_edit_tgcity.val(),"plan_edit_setoff":plan_edit_setoff.val(),"plan_edit_days":plan_edit_days.val(),"plan_edit_date":plan_edit_date.val(),"plan_edit_plimit":plan_edit_plimit.val(),"plan_edit_detail":plan_edit_detail.val(),"plan_edit_other":plan_edit_other.val(),"plan_edit_price":plan_edit_price.val()};
		var url="submit.php";
		var callback=regCallback_Editplan;
		$.post(url,data,callback)};
}

function show_confirm_delete_plan()
{
var r=confirm("确定要删除吗，此操作不可恢复!");
if (r==true)
  {
  delete_plan()
  }
else
  {
 
  }
}

function delete_plan()
{
	
	plan_mod_errmsg.html("Processing...");
			$("input").attr("disabled","disabled");
			$("#delete_plan_button").addClass("disabled");
			$("#delete_plan_button").text("提交中...");
			$("#delete_plan_button").unbind("click");
		var data={"action":"deleteplan"};
		var url="submit.php";
		var callback=regCallback_Editplan;
		$.post(url,data,callback);
		delete_plan_set = true;
}

function regCallback_Editplan(data)
{
		$("input").removeAttr("disabled");
			$("#save_plan_button").removeClass("disabled");
			$("#save_plan_button").text("保存修改");
			$("#save_plan_button").click(save_plan);
	switch(parseInt(data))
		{
			
			case 0:
			showMessage_Editplan("","操作成功！");
			if (delete_plan_set==true){
				CloseWebPage();
			}
			break;
			case -1:
			showMessage_Editplan("","错误，你不是该项目的管理员！");
			break;	
			case -5:
			showMessage_Editplan("","啊噢，服务器打了会儿瞌睡，请重试");
			break;			
		}
	
}
function dataCheck_Editplan()
{
	if(plan_edit_title.val()==""||plan_edit_title.val()==plan_edit_title.attr("placeholder"))
	{
		showMessage_Editplan("错误","旅行项目标题不能为空");
		plan_edit_title.focus();
		return false;
	}
	if(plan_edit_tgcity.val()==""||plan_edit_tgcity.val()==plan_edit_tgcity.attr("placeholder"))
	{
		showMessage_Editplan("错误","目的地不能为空");
		plan_edit_tgcity.focus();
		return false;
	}
	if(plan_edit_setoff.val()==""||plan_edit_setoff.val()==plan_edit_setoff.attr("placeholder"))
	{
		showMessage_Editplan("错误","出发城市不能为空");
		plan_edit_setoff.focus();
		return false;
	}
	if(plan_edit_days.val()==""||plan_edit_days.val()==plan_edit_days.attr("placeholder"))
	{
		showMessage_Editplan("错误","行程天数不能为空");
		plan_edit_days.focus();
		return false;
	}
	if(plan_edit_date.val()==""||plan_edit_date.val()==plan_edit_date.attr("placeholder"))
	{
		showMessage_Editplan("错误","出发日期不能为空");
		plan_edit_date.focus();
		return false;
	}	
	if(plan_edit_plimit.val()==""||plan_edit_plimit.val()==plan_edit_plimit.attr("placeholder"))
	{
		showMessage_Editplan("错误","人数限制不能为空");
		plan_edit_plimit.focus();
		return false;
	}
	if(plan_edit_detail.val()==""||plan_edit_detail.val()==plan_edit_detail.attr("placeholder"))
	{
		showMessage_Editplan("错误","行程详情不能为空");
		return false;
	}
	
return true;
}
function showMessage_Editplan(useless,content)
{
	plan_mod_errmsg.html(content);
}