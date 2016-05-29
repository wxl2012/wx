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
                    {id: 1, title: '关键字'},
                    {id: 2, title: '网址'},
                ];
                break;
            case 2:
                cats = [
                    {id: 1, title: '扫码推事件', value: 'scancode_push'},
                    {id: 2, title: '扫码带提示', value: 'scancode_waitmsg'},
                    {id: 3, title: '系统拍照发图', value: 'pic_sysphoto'},
                    {id: 4, title: '拍照或者相册发图', value: 'pic_photo_or_album'},
                    {id: 5, title: '微信相册发图', value: 'pic_weixin'},
                    {id: 6, title: '发送位置', value: 'location_select'},
                ];
                break;
            case 3:
                cats = [
                    {id: 1, title: '图文素材', value: 'view_limited'},
                    {id: 2, title: '永久素材', value: 'media_id'},
                    {id: 3, title: '临时素材', value: 'keyword'},
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