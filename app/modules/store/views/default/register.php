<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-3" style="line-height: 50px;">
                <a href="javascript:history.back(-1);"><i class="fa fa-angle-left" style="font-size: 1.5em;"></i></a>
            </div>
            <div class="col-xs-6 text-center" style="line-height: 50px;">
                申请开店
            </div>
            <div class="col-xs-3">
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 60px;">
    <div class="row">
        <div class="col-xs-12">
            <form method="post">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="store_name">店铺名称</span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="店铺名称" aria-describedby="store_name" value="<?php echo $store ? $store->name : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="tel">店铺电话</span>
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="店铺座机" aria-describedby="tel" value="<?php echo $store ? $store->tel : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="phone">店铺手机</span>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="店铺手机号码" aria-describedby="phone" value="<?php echo $store ? $store->phone : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="manager_name">负责人姓名</span>
                        <input type="text" id="manager_name" name="manager_name" class="form-control" placeholder="姓名" aria-describedby="manager_name" value="<?php echo $people ? "{$people->first_name}{$people->last_name}" : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="work_tel">负责人电话</span>
                        <input type="text" id="work_tel" name="work_tel" class="form-control" placeholder="电话" aria-describedby="work_tel" value="<?php echo $employee ? $employee->work_tel : ($people ? $people->tel : ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="work_phone">负责人手机</span>
                        <input type="text" id="work_phone" name="work_phone" class="form-control" placeholder="手机" aria-describedby="work_phone" value="<?php echo $employee ? $employee->work_phone :  ($people ? $people->phone : ''); ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-info" style="width: 100%;"><?php echo $store ? '修改店铺资料' : '申请开店'; ?></button>
            </form>
        </div>
    </div>
</div>