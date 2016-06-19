<style type="text/css">
    body{
        background: url('/assets/img/vote_bg.jpg');
    }
    .top{
        padding-top: 20px;
        color: #88684f;
        font-family: 黑体;
        font-size: 14pt;
        font-weight: 900;
    }
    .bottom{
        position: fixed;
        background-color: #88684f;
        color: #fff;
        height: 80px;
        bottom: 0px;
    }
    th, td{
        color: #88684f;
        text-align: center;
    }
</style>

<div class="top text-center">
    <p>第二届全国万人书法、硬笔书法大赛</p>
    <p>网络评选排名榜</p>
</div>

<div class="container" style="background-color: #FAFAF9; margin-bottom: 80px;">
    <div class="row">
        <div class="col-xs-12" style="padding-top: 10px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>排名</th>
                        <th>编号</th>
                        <th>姓名</th>
                        <th>票数</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $index = 0; ?>
                    <?php foreach ($items as $item){ ?>
                        <?php $index ++; ?>
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $item->no; ?></td>
                            <td><?= $item->title; ?></td>
                            <td><?= $item->total_gain; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="bottom">
    <img src="/assets/img/eaves.png" alt="" style="width: 100%;"/>
    <p class="text-center" style="padding-top: 20px;">
        中国硬笔书法协会办学指导中心
    </p>
</div>
