<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                问卷调查
            </div>
        </div>
    </div>
</nav>

<div style="height: 55px;"></div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php $i = 1; ?>
            <?php foreach ($bank->questions as $question) { ?>
                <p><?php echo $i ++; ?>. <?php echo $question->title; ?></p>
                <ul class="list-group">
                <?php foreach ($question->answers as $answer) { ?>
                    <li class="list-group-item">
                        <input type="radio" id="answer<?php echo $answer->id; ?>" name="answer<?php echo $question->id; ?>" value="<?php echo $answer->id; ?>">
                        <label for="answer<?php echo $answer->id; ?>"><?php echo $answer->body; ?></label>
                    </li>
                <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>
<?php

?>