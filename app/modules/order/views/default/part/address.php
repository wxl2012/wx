<?php
$seller = \Session::get('seller', false);
if( ! isset($seller->open_logistical) || ! $seller->open_logistical){
    return;
}
?>
<style type="text/css">
    #addressItems .list-group-item{
        padding-top: 2px;
        padding-bottom: 2px;
    }
    #addressItems .col-xs-10 p{
        margin-bottom: 0px;
    }
</style>
<div class="container-fluid">
    <p>
        收货地址
    </p>
    <ul class="list-group" id="addressItems">
        <li class="list-group-item text-center">
            <i class="fa fa-spinner fa-spin"></i> 收货地址加载中...
        </li>
    </ul>
</div>

<script type="text/x-jquery-tmpl" id="addressItem">
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-2" style="padding-right: 0px">
                <input type="radio" name="address_id" value="${id}"/>
            </div>
            <div class="col-xs-10" style="padding-left: 0px">
                <p><i class="fa fa-user"></i> ${name}</p>
                <p><i class="fa fa-map-marker"></i> ${address}</p>
                <p><i class="fa fa-mobile"></i> ${phone}</p>
            </div>
        </div>
    </li>
</script>

<script type="text/x-jquery-tmpl" id="addNewAddress">
    <li class="list-group-item text-center">
        <a href="javascript:;"><i class="fa fa-plus"></i> 新增收货地址</a>
    </li>
</script>