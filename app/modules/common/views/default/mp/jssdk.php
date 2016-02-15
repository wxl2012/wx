<?php $account = \Session::get('WXAccount', false); ?>
<?php if($account){ ?>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        $(function(){
            load_wx();
        });

        function load_wx(){
            if(typeof(wx) == 'undefined'){
                return;
            }
            <?php $params = \handler\mp\Tool::getJssdkConfig(); ?>
            wx.config(<?php echo json_encode($params); ?>);

            wx.ready(function(){
                wx.onMenuShareTimeline({
                    title: _share_title,
                    link: _share_url,
                    imgUrl: _share_img,
                    success: function(){
                        if(wechat_share_timeline === 'function'){
                            wechat_share_timeline();
                        }
                    },
                    cancel: function(){ },
                    fail: function(){ }
                });

                wx.onMenuShareAppMessage({
                    title: _share_title,
                    desc: _share_desc,
                    link: _share_url,
                    imgUrl: _share_img,
                    type: typeof(_share_type) == 'undefined' ? 'link' : _share_type,
                    dataUrl: _share_src,
                    success: function () {
                        if(wechat_share_app_message === 'function'){
                            wechat_share_app_message();
                        }
                    },
                    cancel: function () { },
                    fail: function(){ }
                });
            });

            wx.error(function(res){
            });

            wx.hideMenuItems({
                menuList: ['menuItem:jsDebug', 'menuItem:editTag', 'menuItem:delete',
                    'menuItem:copyUrl', 'menuItem:originPage', 'menuItem:readMode',
                    'menuItem:openWithQQBrowser', 'menuItem:openWithSafari', 'menuItem:share:email', 'menuItem:share:brand']
            });
        }
    </script>
<?php } ?>