
<style type="text/css">
.ace-thumbnails-active{
    border: 2px solid green !important;
}
</style>
<div class="modal fade" id="modal-upload" style="display: none;" aria-hidden="true">
  	<div class="modal-dialog" style="width: 745px; height:350px;">
    	<div class="modal-content">
    		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4>文件上传</h4>
      		</div>
		    <div class="modal-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="navTabs">
                        <li class="active">
                            <a data-toggle="tab" href="#location" aria-expanded="true">
                                <i class="green ace-icon fa fa-home bigger-120"></i>
                                本地上传
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#fileStore" aria-expanded="false">
                                图片空间
                                <span class="badge badge-danger" id="selectNum"></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" style="padding-bottom: 0px;">
                        <div id="location" class="tab-pane fade active in">
                            <form id="frmUpload" class="form-horizontal" method="POST" action="/file/upload">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input multiple="" type="file" name="files[]" id="upload-files" />
                                        <!-- /section:custom/file-input -->
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div id="fileStore" class="tab-pane fade">
                            <div id="fileStoreLoadDiv"><i class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>数据加载中...</div>
                            <div>
                                <ul id="gallery" class="ace-thumbnails clearfix">
                                    
                                </ul>
                            </div>
                            <div id="pagination" style="text-align: right; margin-top: 10px;">
                                
                            </div>
                        </div>
                    </div>
                </div>
		    </div>
		    <div class="modal-footer">
                <button class="btn btn-sm btn-primary" id="btnUpload" onclick="javascript:$('frmSubmit').submit();">上传</button>
                <button class="btn btn-sm btn-primary" id="btnSelect" style="display:none;" data-dismiss="modal" aria-hidden="true">确认选择</button>
		        <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true">关闭</button>
		    </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<script type="text/javascript" src="/assets/third-party/jquery-tmpl-master/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="/assets/third-party/jquery-tmpl-master/jquery.tmplPlus.min.js"></script>

<script type="text/x-jquery-tmpl" id="galleryLi">
<li style="border: 2px dashed #aaa;" data-id="${id}">
    <div>
        <img style="width:90px; height: 90px;" alt="60x60" src="${url}">
        <div class="text">
            <div class="inner">
                <span>图片标题</span>

                <br>
                <a href="${url}" data-rel="colorbox" class="cboxElement" target="_blank">
                    <i class="ace-icon fa fa-search-plus"></i>
                </a>

                <a href="#" role="select">
                    <i class="ace-icon fa fa-check"></i>
                </a>
            </div>
        </div>
    </div>
</li>
</script>

<script type="text/javascript" src="http://wx.ttcjt.tv/public/home/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="/assets/js/tools.js"></script>
<script type="text/javascript">
var file_manager_select_images = [];

$(function(){
    
    refreshGallery('/admin/file/list?type=image');

    //分页点击事件
    $('#pagination').delegate('ul li a', 'click', function(){
        refreshGallery($(this).attr('data-href'));
    });

    //选项卡事件
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        $('#btnSelect,#btnUpload').hide();
        if($(e.target).attr('href') == '#fileStore'){
            $('#btnSelect').show();
        }else{
            $('#btnUpload').show();
        }

    });

    $('#btnSelect').click(function(){
        gallery_select_callback(file_manager_select_images);
    });

    //选图事件
    $('#fileStore').delegate('a[role=select]', 'click', function(){
        var li = $(this).parents('li');
        $(li).addClass('ace-thumbnails-active');
        $(this).attr('role', 'unselect').find('i').removeClass('fa-check').addClass('fa-times');

        file_manager_select_images[file_manager_select_images.length] = $(li).attr('data-id');
        $('#selectNum').text(file_manager_select_images.length);
    });

    //移除选图事件
    $('#fileStore').delegate('a[role=unselect]', 'click', function(){
        var li = $(this).parents('li');
        $(li).removeClass('ace-thumbnails-active');
        $(this).attr('role', 'select').find('i').removeClass('fa-times').addClass('fa-check');

        for (var i = 0; i < file_manager_select_images.length; i++) {
            if(file_manager_select_images[i] == $(li).attr('data-id')){
                file_manager_select_images.remove(i);
                break;        
            }
        }

        $('#selectNum').text(file_manager_select_images.length < 1 ? '' : file_manager_select_images.length);
    });

    <?php $timestamp = time();?>
    $('#btnUpload').click(function(){
        $.ajaxFileUpload({
            url: "/file/fuel_upload",
            //需要链接到服务器地址
            secureuri: false,
            fileElementId: 'upload-files',
            //文件选择框的id属性
            dataType: 'json',
            data:{
                timestamp: <?php echo $timestamp;?>,
                token: '<?php echo md5('unique_salt' . $timestamp);?>',
                module: (typeof(upload_module)==='undefined') ? 4 : upload_module,
                path: (typeof(path)==='undefined') ? 0 : path
            },
            //也可以是json
            success: upload_callback,
            error: function(data, status, e) {
                alert(e);
            }
        });
    });
    
    $('#upload-files').ace_file_input({
        style:'well',
        btn_choose:'拖放文件至此或单击选择文件',
        btn_change:null,
        no_icon:'ace-icon fa fa-cloud-upload',
        droppable:true,
        thumbnail:'small'//large | fit
        //,icon_remove:null//set null, to hide remove/reset button
        /**,before_change:function(files, dropped) {
            //Check an example below
            //or examples/file-upload.html
            return true;
        }*/
        ,before_remove : function() {
            return true;
        },
        preview_error : function(filename, error_code) {
            //name of the file that failed
            //error_code values
            //1 = 'FILE_LOAD_FAILED',
            //2 = 'IMAGE_LOAD_FAILED',
            //3 = 'THUMBNAIL_FAILED'
            //alert(error_code);
            alert(error_code);
        }

    }).on('change', function(){

        console.log($(this).data('ace_input_files'));
        console.log($(this).data('ace_input_method'));
    });
});

//刷新图库数据
function refreshGallery(url){
    $('#fileStoreLoadDiv').show();
    $.get(url, 
        function(data, status){
            $('#fileStoreLoadDiv').hide();
            if(data.status == 'err'){
                return;
            }
            var items = data.data;
            $('#gallery').empty();
            for (var i = 0; i < items.length; i++) {
                $('#gallery').append(galleryLi, items[i], null);
            }
            if(data.pagination.length > 1){
                $('#pagination').html(data.pagination);
            }
        }, 'json');
}
</script>