
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>数据字典</title>

    <!-- Bootstrap core CSS -->
    <link href="http://lib.sinaapp.com/js/bootstrap/v3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        th{
            text-align: center;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
    </div>
</nav>

<div class="container" style="margin-top: 60px;">

    <?php
        $index = 0;
        $tables = \DB::list_tables();
        foreach ($tables as $table){
    ?>
        <div class="row">
            <div class="col-md-12" style="font-weight: 700; font-size: 18px;">
                <?php echo ++ $index;?>、表名: [<?php echo $table; ?>] 注释:
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 200px;">字段</th>
                            <th style="width: 200px;">类型</th>
                            <th style="width: 80px;">为空</th>
                            <th style="width: 200px;">额外</th>
                            <th style="width: 100px;">默认</th>
                            <th style="width: 90px;">整理</th>
                            <th>备注</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $columns = \DB::list_columns($table);
                        foreach ($columns as $column){
                        ?>

                        <?php
                            $count ++;
                            $length = '';
                            if($column['data_type'] == 'int'){
                                $length = "({$column['display']})";
                            }else if($column['data_type'] == 'varchar'){
                                $length = "({$column['character_maximum_length']})";
                            }else if($column['data_type'] == 'decimal'){
                                $length = "({$column['numeric_precision']},{$column['numeric_scale']})";
                            }else if($column['data_type'] == 'enum'){
                                $length = '(' . implode(', ', $column['options']) . ')';
                            }
                        ?>
                        <tr>
                            <td><?php echo $column['name']; ?></td>
                            <td style="width: 200px; max-width: 200px; WORD-WRAP: break-word;"><?php echo "{$column['data_type']}{$length}"; ?></td>
                            <td class="text-center"><?php echo $column['null'] ? 'Yes' : 'False'; ?></td>
                            <td><?php echo $column['extra']; ?></td>
                            <td><?php echo $column['default']; ?></td>
                            <td><?php echo isset($column['collation_name']) ? $column['collation_name'] : ''; ?></td>
                            <td><?php echo $column['comment']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>


    <hr>

    <footer>
        <p>&copy; Company 2014</p>
    </footer>
</div> <!-- /container -->


<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://lib.sinaapp.com/js/bootstrap/v3.0.0/js/bootstrap.min.js"></script>
</body>
</html>
