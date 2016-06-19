<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <form method="post">
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="真实姓名" value="<?php echo $item ? $item->name : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="nation">性别</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="男"<?php echo $item && $item->gender == '男' ? ' selected' : ''; ?>>男</option>
                        <option value="女"<?php echo $item && $item->gender == '女' ? ' selected' : ''; ?>>女</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nation">民族</label>
                    <input type="text" class="form-control" id="nation" name="nation" placeholder="所属民族" value="<?php echo $item ? $item->nation : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="native">籍贯</label>
                    <input type="text" class="form-control" id="native" name="native" placeholder="所在籍贯" value="<?php echo $item ? $item->native : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="aptitude">资质</label>
                    <input type="text" class="form-control" id="aptitude" name="aptitude" placeholder="相产资质" value="<?php echo $item ? $item->aptitude : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="company">工作单位</label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="所在工作单位名称" value="<?php echo $item ? $item->company : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="tel">电话</label>
                    <input type="text" class="form-control" id="tel" name="tel" placeholder="联系电话" value="<?php echo $item ? $item->tel : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="birthday">出生日期</label>
                    <input type="text" class="form-control" id="birthday" name="birthday" placeholder="出生日期,格式:yyyy-mm-dd(如:<?php echo date('Y-m-d');?>)" value="<?php echo $item ? date('Y-m-d', $item->birthday) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="province_id">所在地</label>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-xs-3">
                            <select id="province_id" name="province_id" class="form-control">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <select id="city_id" name="city_id" class="form-control col-xs-4">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <select id="county_id" name="county_id" class="form-control col-xs-4">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                        </div>
                    </div>
                    <input type="text" class="form-control" id="address" name="address" placeholder="详细地址" value="<?php echo $item ? $item->address : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="recorder_id">记录人</label>
                    <select id="recorder_id" name="recorder_id" class="form-control">
                        <option value="1"<?php echo $item && $item->recorder_id == 1 ? ' selected' : ''; ?>>卞山</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="read_total">浏览量</label>
                    <input type="number" class="form-control" id="read_total" name="read_total" value="<?php echo $item ? $item->read_total : 0; ?>" placeholder="浏览量">
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var _provinceValue = <?php echo $item ? $item->province_id : '0'; ?>;
    var _cityValue = <?php echo $item ? $item->city_id : '0'; ?>;
    var _countyValue = <?php echo $item ? $item->county_id : '0'; ?>;
    $(function () {

        $('#province_id').change(function(){
            var provinceName = $('#province_id').find('option:selected').text();
            if(provinceName.indexOf('市')){
                $('#city_id').empty()
                    .append('<option value="0">请选择</option>')
                    .append('<option value="' + $(this).val() + '">' + provinceName + '</option>');
            }else{
                loadOptions($('#city_id'), $(this).val(), _cityValue);
            }

        });

        $('#city_id').change(function(){
            loadOptions($('#county_id'), $(this).val(), _countyValue);
        });

        loadOptions($('#province_id'), 0, _provinceValue);

    });

    function loadOptions(element, id, defaultValue){
        $.get('/region' + (id != 0 ? '?id=' + id : ''),
            function(data){
                if(data.status == 'err'){
                    return;
                }
                addOptions(element, data.data, defaultValue);
            }, 'json');
    }

    function addOptions(element, items, defaultValue){
        $(element).empty().append('<option value="0">请选择</option>');
        for (var i = 0;i < items.length; i ++){
            $(element).append('<option value="' + items[i].id + '"' + (defaultValue == items[i].id ? ' selected' : '') + '>' + items[i].name + '</option>')
        }
        /*if($(element).attr('id') == 'province_id'){
            $('#province_id').val(_provinceValue);
        }*/
    }
</script>
