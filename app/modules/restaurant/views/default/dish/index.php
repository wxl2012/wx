<style type="text/css">
    .pr3{
        padding-right: 3px;
    }
    .pl3{
        padding-left: 3px;
    }
    .pl3 dl{
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>

<div class="container-fluid">
    <div class="list-group">
        <?php for($i = 0; $i < 10; $i ++){ ?>
            <div class="list-group-item">
                <div class="row">
                    <div class="col-xs-5 pr3">
                        <img style="width: 100%;" src="http://file109.mafengwo.net/s6/M00/41/7E/wKgB4lOVp9yAFiC3AAGmw5EsOWU73.jpeg?imageMogr2%2Fthumbnail%2F%211360x940r%2Fgravity%2FCenter%2Fcrop%2F%211360x940%2Fquality%2F90" alt="" />
                    </div>
                    <div class="col-xs-7 pl3">
                        <dl>
                            <dt>三明治咖啡</dt>
                            <dd>三明汉两个,咖啡一杯</dd>
                            <dd>￥ 50元</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="list-group-item text-right">
                <div class="row">
                    <div class="col-xs-3">
                    </div>
                    <div class="col-xs-3">
                    </div>
                    <div class="col-xs-6">
                        <div class="input-group">
                            <span class="input-group-addon" role="minus">-</span>
                            <input type="text" class="form-control text-center" value="0">
                            <span class="input-group-addon" role="plus">+</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>