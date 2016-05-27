<link rel="stylesheet" type="text/css" href="/assets/ace/css/jquery.gritter.css">
<script type="text/javascript" src="/assets/ace/js/jquery.gritter.js"></script>
<script type="text/javascript"> 
    function showResultMessage(title, text, status){
        $.gritter.add({
            title: (status == 'success' ? '<i class="fa fa-check-circle-o" style="font-size: 2em;"></i>' : '<i class="fa fa-times-circle-o" style="font-size: 2em;"></i>') + '<strong style="font-size: 18px; margin-left: 10px;">' + title + '</strong>',
            text: text,
            class_name: 'gritter-' + status + ' gritter-light'
        }); 
    }
</script>

<?php $msg = \Session::get_flash('msg'); ?>
<?php if($msg){ ?>
<script type="text/javascript"> 
<?php
    $error_item = '';
    if(isset($msg["data"]) && $msg["data"]){
        foreach($msg["data"] as $key => $value){
            $error_item .= "{$key}{$value}<br>";
        }
    } 
?>
showResultMessage(<?php echo "'{$msg['msg']}', '{$error_item}'," . ($msg["status"] == "succ" ? "'success'" : "'error'");?>);
</script>
<?php } ?>
