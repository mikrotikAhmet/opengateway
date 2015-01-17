<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3><b><?php echo $text_balance?></b></h3>
            <p><?php echo $text_available?></p>
            <div class="buttons clearfix">
                <div class="pull-left">
                    <a href="<?php echo $upload?>" class="btn btn-sm btn-primary"><i class="fa fa-arrow-up"></i> <?php echo $button_upload?></a>
                    <a href="<?php echo $withdraw?>" class="btn btn-sm btn-primary" <?php echo ($balance < $min_withdraw ? 'disabled' : '')?>><i class="fa fa-arrow-down"></i> <?php echo $button_withdraw?></a>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a href="<?php echo $send?>" class="btn btn-sm btn-warning" <?php echo ($balance < $min_transfer ? 'disabled' : '')?>><i class="fa fa-arrow-right"></i> <?php echo $button_send_money?></a>
        </div>
    </div>
</div>