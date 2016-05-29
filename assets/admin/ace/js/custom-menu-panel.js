var current_menu;

$(function(){

	$(document).delegate('input', 'click', function(){
		current_menu = $(this);
		var data = {
			'name': $(this).val(),
			'category': $(this).attr('category'),
			'level': $(this).parent().is('li') ? '二级菜单' : '一级菜单',
			'action': $(this).attr('action') == undefined ? '' : $(this).attr('action'),
			'content': $(this).attr('content') == undefined ? '' : $(this).attr('content')
		};
		window.parent.updateCurrent(data);
	});

	$(document).delegate('input', 'keydown', function(e){
		var data = {
			'name': $(this).val(),
			'category': $(this).attr('category'),
			'level': $(this).parent().is('li') ? '二级菜单' : '一级菜单',
			'action': $(this).attr('action') == undefined ? '' : $(this).attr('action'),
			'content': $(this).attr('content') == undefined ? '' : $(this).attr('content')
		};
		window.parent.updateCurrent(data);

		var num = getStringBytesCount($(this).val());

		if(e.keyCode == 8 || e.keyCode == 46){
			return;
		}
		if(current_menu.parent().is('li')){
			if(num > 40){
				alert('子菜单项名字必须小于40字节(20汉字)');
				return false;
			}
		}else if(current_menu.parent().is('div')){
			if(num > 16){
				alert('一级菜单项名字必须小于10字节(5汉字)');
				return false;
			}
		}
	});

});

//给菜单项添加操作及响应值
function addAction(action, value){
	if(value == null || value.trim().length < 1){
		return;
	}
	current_menu.attr(action, value);
}

//发布菜单
function publish(){
	var subItemTpl = '{"type" : "{0}", "name" : "{1}", "{2}" : "{3}", "category" : "{4}"},';
	var menuItemTpl = '{"name" : "{0}", "sub_button" : [{1}], "category" : "{2}"},';
	var menuTpl = '{"button" : [{0}]}'

	var flag = false;
	var menu = '';
	var num = 0;

	$('#menu-item').find('div').each(function(index, menuItem){
		var subItems = '';
		$('#submenuItem' + index).find('ul li').each(function(i, subItem){
			var item = $(subItem).find('input');
			if(item.val().trim().length < 1){
				return;
			}
			num = getStringBytesCount(item.val());
			if(num > 40){
				flag = true;
				alert('子菜单：' + item.val() + ' 名字长度过长。\n子菜单最多20个汉字(包含字符)。');
				return;
			}else if(item.attr('action') == undefined || item.attr('action').trim().length < 1){
				flag = true;
				alert('子菜单：' + item.val() + ' 动作类型未设置。\n请选择该菜单的触发动作。');
				return;
			}else if(item.attr('content') == undefined || item.attr('content').trim().length < 1){
				flag = true;
				alert('子菜单：' + item.val() + ' 未设置响应值。\n请填写该菜单' + (item.attr('action') == 'click' ? '触发的关键字。' : '打开的网址。') );
				return;
			}
			var type = item.attr('action') == 'click' ? 'key' : 'url';
			var jsonItem = subItemTpl.format(item.attr('action'), item.val(), type, item.attr('content'), item.attr('category'));
			subItems += jsonItem;
		});

		item = $(menuItem).find('input');
		num = getStringBytesCount(item.val());
		if(num > 16){
			flag = true;
			alert('菜单：' + item.val() + ' 名字长度过长。\n子菜单最多5个汉字(包含字符)。');
		}

		if(subItems.trim().length < 1){
			if(item.attr('action') == undefined || item.attr('action').trim().length < 1){
				flag = true;
				alert('菜单：' + item.val() + ' 动作类型未设置。\n请选择该菜单的触发动作。');
				return;
			}else if(item.attr('content') == undefined || item.attr('content').trim().length < 1){
				flag = true;
				alert('菜单：' + item.val() + ' 未设置响应值。\n请填写该菜单' + (item.attr('action') == 'click' ? '触发的关键字。' : '打开的网址。') );
				return;
			}
			menu += subItemTpl.format(item.attr('action'), item.val(), item.attr('action') == 'click' ? 'key' : 'url', item.attr('content'), item.attr('category'));
		}else{
			menu += menuItemTpl.format(item.val(), subItems.substring(0, subItems.length - 1), item.attr('category'));
		}
	});

	menu = menuTpl.format(menu.substring(0, menu.length - 1));
	if(flag){
		return;
	}

	window.parent.setPublishStatus('数据正在提交...');
	window.parent.setDisplay('show');
	$.post('/admin/mp/function/menu_save/' + wx_account_id, 
		{
			'menu' : menu
		}, 
		function(data, status){
			if(data.status == 'succ'){
				window.parent.setPublishStatus('数据已提交成功！菜单将于24小时内生效。');
				alert('菜单已发布成功。\n菜单将于24小时内生效。如急需查看，请您重新关注公众帐户即可查看新菜单。');
				/*if(confirm('菜单已保存成功，是否现在发布菜单？\n注：菜单发布24小时后自动生效。或重新关注公众帐户查看效果。')){
					$.post('/app/menus/create', 
						function(data, status){
							window.parent.setDisplay('hide');
							if(data.errcode == 0){
								alert('菜单已发布成功。\n菜单将于24小时内生效。如急需查看，请您重新关注公众帐户即可查看新菜单。');
							}else{
								alert(data.errmsg);
							}
						}, 'json');
				}else{
					window.parent.setDisplay('hide');
				}*/
			}else{
				window.parent.setDisplay('hide');
			}
		}, 'json');
}

//移除菜单项
function removeMenuItem(){
	if(current_menu == undefined){
		alert('请先选择需要删除的菜单项!');
		return;
	}
	if(current_menu.parent().is('li')){
		current_menu.val('');
	}
	if(current_menu.parent().is('div')){
		var count = current_menu.parent().parent().find('div').length;
		if(count < 2){
			alert('至少保留1项菜单项,如果不想使用自定义菜单请点“关闭自定义菜单”。');
			return;
		}

		var index = 0;
		var id = current_menu.parent().attr('id');
		id = id.substring(id.length - 1);

		var current;
		if(id < 2){
			current = $('#menuItem' + id).next();
			sub_current = $('#submenuItem' + id).next();
		}
		$('#menuItem' + id).remove();
		$('#submenuItem' + id).remove();
		for(i = id;i < count - 1; i ++){
			new_id = current.attr('id').substring(current.attr('id').length - 1);
			current.attr('id',  "menuItem" + (new_id - 1));
			current = current.next();

			sub_current.attr('id',  "submenuItem" + (new_id - 1));
			sub_current = sub_current.next();
		}
	}
	current_menu = undefined;
	autoAdjust(0);
}

//添加菜单项
function addMenuItem(text){
	var count = $('#menu-item').find('div').length;
	if(count >= 3){
		alert('最多只允许添加3个菜单项');
		return;
	}
	$('#menu-item').append(
		'<div class="col-xs-12 tac" id="menuItem' + count + '" action="menu-item" style="padding: 0px;">'
		+ '<input type="text" value="' + text + '" placeholder="一级菜单" />' 
		+ '</div>');
	$('#submenu-item').append('<div class="col-xs-12" id="submenuItem' + count + '" style="padding:0px; margin-top: 90px">' 
		+ '<ul class="list-group">'
		+ '<li class="list-group-item"><input type="text" value="" placeholder="子菜单1"></li>'
		+ '<li class="list-group-item"><input type="text" value="" placeholder="子菜单2"></li>'
		+ '<li class="list-group-item"><input type="text" value="" placeholder="子菜单3"></li>'
		+ '<li class="list-group-item"><input type="text" value="" placeholder="子菜单4"></li>'
		+ '<li class="list-group-item list-group-item-last"><input type="text" value="" placeholder="子菜单5"></li>'
		+ '</ul></div>');

	autoAdjust(1);
}

//判断菜单项布局
function autoAdjust(action){
	var search, str;
	if($('#menu-item').find('div').length == 2){
		search = action == 1 ? 12 : 4;
		str = action == 1 ? 6 : 6;
	}else if($('#menu-item').find('div').length == 3){
		search = 6;
		str = 4;
	}else if($('#menu-item').find('div').length == 1){
		search = 6;
		str = 12;
	}

	$('#menu-item').find('div:last').prev().addClass('br');
	$('#menu-item').find('div').removeClass('col-xs-' + search);
	$('#menu-item').find('div').addClass('col-xs-' + str);
	$('#submenu-item').find('div').removeClass('col-xs-' + search);
	$('#submenu-item').find('div').addClass('col-xs-' + str);
}