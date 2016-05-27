<script type="text/javascript" src="/assets/ace/js/bootbox.js"></script>
<script type="text/javascript">
$('a[data-target="#confirmModal"]').on(ace.click_event, function() {
	a = $(this);
	bootbox.confirm({
		message: "您确定要删除该记录?",
		locale: 'zh_CN',
		buttons: {
		  confirm: {
			 label: "确定",
			 className: "btn-primary btn-sm",
		  },
		  cancel: {
			 label: "取消",
			 className: "btn-sm",
		  }
		},
		callback: confirmDelete
	  }
	);
});
</script>