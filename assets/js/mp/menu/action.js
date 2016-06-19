var MPMenuAction = {

    categories: function () {
        var cats = [
            {
                id: 1,
                title: '常规'
            },
            {
                id: 2,
                title: '事件'
            },
            {
                id: 3,
                title: '素材'
            }
        ];
        return cats;
    },

    subcategories: function (cid) {
        var cats = [];
        switch(parseInt(cid)){
            case 1:
                cats = [
                    {id: 'click', title: '关键字', type: 'click'},
                    {id: 'view', title: '网址', type: 'view'},
                ];
                break;
            case 2:
                cats = [
                    {id: 'scancode_push', title: '扫码推事件', type: 'scancode_push'},
                    {id: 'scancode_waitmsg', title: '扫码带提示', type: 'scancode_waitmsg'},
                    {id: 'pic_sysphoto', title: '系统拍照发图', type: 'pic_sysphoto'},
                    {id: 'pic_photo_or_album', title: '拍照或者相册发图', type: 'pic_photo_or_album'},
                    {id: 'pic_weixin', title: '微信相册发图', type: 'pic_weixin'},
                    {id: 'location_select', title: '发送位置', type: 'location_select'},
                ];
                break;
            case 3:
                cats = [
                    {id: 'view_limited', title: '图文链接', type: 'view_limited'},
                    {id: 'media_id', title: '图文素材', type: 'media_id'}
                ];
                break;
            default:
                break;
        }
        return cats;
    },

    showPath: function (cid, subcid) {
        var cname = '';
        var cats = this.categories();
        for(var i = 0; i < cats.length; i ++){
            if(cats[i].id == cid){
                cname = cats[i].title;
                break;
            }
        }

        cats = this.subcategories(cid);
        for(var i = 0; i < cats.length; i ++){
            if(cats[i].id == subcid){
                cname += '/' + cats[i].title;
                break;
            }
        }
        return cname;
    }
}