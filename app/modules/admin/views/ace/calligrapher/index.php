<div class="container">
    <div class="row">
        <div class="col-xs-12" style="padding-top: 20px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>民族</th>
                        <th>籍贯</th>
                        <th>工作单位</th>
                        <th>地址</th>
                        <th>联系电话</th>
                        <th>记录人</th>
                        <th>记录时间</th>
                        <th style="100px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item){ ?>
                        <tr>
                            <td><?php echo $item->id;?></td>
                            <td><?php echo $item->name;?></td>
                            <td><?php echo $item->gender;?></td>
                            <td><?php echo $item->nation;?></td>
                            <td><?php echo $item->native;?></td>
                            <td><?php echo $item->company;?></td>
                            <td><?php echo "{$item->province->name}{$item->city->name}{$item->county->name}{$item->address}";?></td>
                            <td><?php echo $item->tel;?></td>
                            <td><?php echo $item->recorder_id == 1 ? '卞山' : '';?></td>
                            <td><?php echo date('Y-m-d H:i:s', $item->created_at);?></td>
                            <td>
                                <a href="javscript:;" class="btn btn-danger">删除</a>
                                <a href="/admin/calligrapher/save/<?php echo $item->id;?>" class="btn btn-info">编辑</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>