<?php
$seller = \Session::get('seller', false);
if( ! isset($seller->open_logistical) || ! $seller->open_logistical){
    return;
}
?>
<style type="text/css">
    #addressItems .col-xs-10 p{
        margin-bottom: 0px;
    }
</style>
<div class="container-fluid">
    <div class="title">
        <span class="line_orange"></span>
        收货地址
    </div>
    <ul class="list-group" id="addressItems">
        <li class="list-group-item text-center">
            <i class="fa fa-spinner fa-spin"></i> 收货地址加载中...
        </li>
    </ul>
</div>

<!-- Modal -->
<div class="modal fade" id="addressDetailModal" tabindex="-1" role="dialog" aria-labelledby="addressDetailModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addressDetailModalLabel">新增收货地址</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px;">
                <form id="frmAddressDetail">
                    <div class="form-group">
                        <div>
                            <select class="form-control hide" id="country_id" name="country_id">
                            </select>
                            <select class="form-control" id="province_id" name="province_id" style="display: inline; width: 30%;">
                            </select>
                            <select class="form-control" id="city_id" name="city_id" style="display: none; width: 30%;">
                            </select>
                            <select class="form-control" id="county_id" name="county_id" style="display: none; width: 30%;">
                            </select>
                        </div>
                        <div style="margin-top: 10px;">
                            <input type="text" class="form-control" id="address" name="address" placeholder="详细地址" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="邮编" style="width: 120px;">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="收货人姓名">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="手机号码">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="btnSaveAddress">保存</button>
            </div>
        </div>
    </div>
</div>

<script type="text/x-jquery-tmpl" id="addressItem">
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-2" style="padding-right: 0px">
                <input type="radio" name="address_id" value="${id}"/>
            </div>
            <div class="col-xs-10" style="padding-left: 0px">
                <p><i class="fa fa-user"></i> ${name} <i class="fa fa-mobile" style="margin-left: 20px;"></i> ${phone}</p>
                <p><i class="fa fa-map-marker"></i>${province.name} ${city.name} ${address}</p>
            </div>
        </div>
    </li>
</script>

<script type="text/x-jquery-tmpl" id="addNewAddress">
    <li class="list-group-item text-center">
        <a href="javascript:;" style="font-size: 9pt; text-decoration: none;" data-toggle="modal" data-target="#addressDetailModal"><i class="fa fa-plus"></i> 新增收货地址</a>
    </li>
</script>

<?php
    \Asset::js('order/default/part/address.js', [], 'js-files', false);
?>