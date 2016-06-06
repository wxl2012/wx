
var _dish_list = [];

$(function () {

    $('#btnMore').click(function () {
        if(_pageIndex > _totalPage){
            $('#btnMore').text('已经没有下一页了');
            return;
        }

        loadData();
    });

    loadData();
    setNavbar();
});

function setNavbar() {
    $('#navTitle').text('我的订单');
    //$('#navRight').html('<a href="/store/finance/cashback_records">明细</a>');
}

function loadData() {
    $.get('/api/order/dish/list.json?access_token=' + _access_token,
        function (data) {
            $('#btnMore').text('点击加载更多');
            if(data.status == 'err'){
                addEmptyDiv();
                return;
            }

            _totalPage = data.total_page;
            _pageIndex = parseInt(data.current_page) + 1;
            
            var items = data.data;
            for (var key in items){
                items[key].created_date = timetodate('Y-m-d H:i:s', items[key].created_at);
                $('#orderItems').append(orderItem, items[key], null);
            }

        }, 'json');
}

function addEmptyDiv() {
    var html = '<div class="row" style="color: #aaa;">' +
        '<div class="col-xs-12 text-center" style="padding-top: 40px; line-height: 50px; font-size: 60pt;"><i class="fa fa-frown-o"></i></div>' +
        '<div class="col-xs-12 text-center" style="line-height: 50px; font-size: 13pt;">您还未购买过任何东西!</div>' +
        '</div>';
    $('#orderItems').append(html);
}