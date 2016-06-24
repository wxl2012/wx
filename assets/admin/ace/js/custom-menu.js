var actions = undefined;

$(function(){

	$.get('/admin/mp/function/menus_actions',
		function(data, status){
			if(data.status == 'succ'){
				actions = data.data;
			}
		}, 'json');

	$('input[type="radio"]').on('ifChecked', function(event){
		//alert($(this).val());
	});

	$('#btnAddMenuItem').click(function(){
		document.getElementById('menu-panel').contentWindow.addMenuItem('');
	});

	$('#btnRemoveMenuItem').click(function(){
		document.getElementById('menu-panel').contentWindow.removeMenuItem();
		$('#select-category').hide();
		$('#content-input').hide();
		$('#login-radio').hide();
		$('#select-message').hide();
	});

	$('#btnPublish').click(function(){
		document.getElementById('menu-panel').contentWindow.publish();
	});

	$('#btnCloseMenu').click(function(){
		
	});

	$('#value').change(function(){
		setAttriber('action', $(this).attr('action'));
		setAttriber('content', $(this).val());
	});

	$('#category').change(function(){
		$('#content-input').hide();
		$('#login-radio').hide();
		$('#select-message').hide();
		setAttriber('action', 'click');

		if($('#category').val() == 'function'){
			$('#input').iCheck('check');
			$('#login-radio').show();
			setAttriber('action', 'view');
			setAttriber('content', $('#action').val());
		}else if($('#category').val() == 'other'){
			$('#select-message').show();
		}else if($('#category').val() == 'normal'){
			$('#content-input').show();
			setAttriber('content', '');
		}

		$('#action').empty();
		if(actions == undefined){
			//alert('未获取合法数据');
			return;
		}
		for (var i = 0; i < actions.length; i++) {
			if(actions[i].category == $(this).val()){
				var items = actions[i].data;
				for (var index = 0; index < items.length; index++) {
					var item = items[index];
					$('#action').append("<option value=" + item.value + ">" + item.text + "</option>");
				}
			}
		}

		if($('#category').val() == 'function'){
			setAttriber('content', $('#action').val());
		}
	});

	$('#action').change(function(){

		if($('#action').val() == 'click'){
			$('#labelTip').text('关键字：');
			$('#value').attr('action', 'click');
			setAttriber('action', 'click');
		}else if($('#action').val() == 'category'){
			$.get('/category?id=' + article_id,
				function(data, status){
					var select = "<select id='article_category_id'>";
					if(data.status == 'succ'){
						select += data.data;
					}
					select += "</select>";
					$(select).insertAfter($('#action'));
				}, 'json');
		}else if($('#action').val() == 'vote'){
			$.get('/manager/vote?',
				function(data, status){
					var select = "<select id='votes_id'>";
					if(data.status == 'succ'){
						for(var i = 0; i < data.data.length; i ++){
							select += '<option value="' + data.data[i].id + '">' + data.data[i].title + '</option>';
						}
						select += data.data;
					}
					select += "</select>";
					$(select).insertAfter($('#action'));
				}, 'json');
		}else if($('#action').val() == 'view'){
			$('#labelTip').text('网址：');
			$('#value').attr('action', 'view');
			setAttriber('action', 'view');
		}else if($('#category').val() == 'function'){
			setAttriber('action', 'view');
			setAttriber('content', $('#action').val());
		}else if($('#category').val() == 'event'){
			setAttriber('action', $('#action').val());
		}else if($('#category').val() == 'other'){
		}
	});

	$('div').delegate('#article_category_id', 'change', function(){
		console.log('设置分类');
		//alert($(this).val());
	});

	$('div').delegate('#votes_id', 'change', function(){
		console.log('设置投票ID');
		//alert($(this).val());
	});

});

function setAttriber(action, value){
	document.getElementById('menu-panel').contentWindow.addAction(action, value);
	if($('#category').val().trim().length > 0){
		document.getElementById('menu-panel').contentWindow.addAction('category', $('#category').val());
	}		
}

function setDisplay(style){
	$('#process').modal(style);
}

function setPublishStatus(text){
	$('#status_text').text(text);
}

function updateCurrent(data){
	if($('#select-category').is(":hidden")){
		$('#select-category').show();
		$('#content-input').show();
	}

	if(data.action == undefined || data.action.trim().length < 1){
		$('#category').val('normal');
		$('#category').change();
		$('#value').val('');
	}else{
		$('#category').val(data.category);
		$('#category').change();

		if(data.category == 'function'){
			$('#action').val(data.content);
		}else if(data.category == 'normal'){
			$('#value').val(data.content);
			$('#value').attr('action', data.action);
			$('#action').val(data.action);
			$('#labelTip').text(data.action == 'view' ? '网址：' : '关键字：');
		}
		$('#action').change();	
	}

	$('#current_menu_name').text(data.name);
	$('#current_menu_level').text(data.level);
	$('#current_menu_action').text(data.action);
	$('#current_menu_content').text(data.content);
}