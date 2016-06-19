<style type="text/css">
    .list-group .list-group-item{
        background-color: transparent;
        border-top: 0px;
        border-left: 0px;
        border-right: 0px;
        text-align: left;
    }
    .list-group .list-group-item:first-child{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .list-group .list-group-item:first-child{
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    a{
        color: #333;
        text-decoration: none;
    }
    a:hover{
        color: red;
        text-decoration: none;
    }
</style>
<div class="container-fluid">
    <div class="text-center" style="padding: 20px;">
        <img src="<?= $item->photo_url; ?>" alt="" style="max-width: 90%;"/>
    </div>

    <div style="background-color: #F1E9E1; margin: 20px; padding: 15px;">
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-6">
                        姓名: <?= $item->name; ?>
                    </div>
                    <div class="col-xs-6">
                        性别: <?= $item->gender; ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-6">
                        民族: <?= $item->nation; ?>
                    </div>
                    <div class="col-xs-6">
                        籍贯: <?= $item->native; ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        出生日期: <?= date('Y年m月d日', $item->birthday); ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        相关资质: <?= $item->aptitude; ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        工作单位: <?= $item->company; ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        联系地址: <?= $item->address; ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        联系方式: <?= $item->tel; ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        记&nbsp;&nbsp;录&nbsp;&nbsp;员: <?= $item->recorder ? "{$item->recorder->first_name}{$item->recorder->last_name}" : ''; ?>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="text-center" style="padding: 20px;">
        <img src="<?= $item->piece_url; ?>" alt="" style="max-width: 90%;"/>
    </div>

    <div class="text-center" style="padding: 20px;">
        <?= $item->read_total; ?>人访问
    </div>
</div>