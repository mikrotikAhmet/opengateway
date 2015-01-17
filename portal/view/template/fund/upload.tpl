<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $text_upload_step_1?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="radio" name="method" value="<?php echo $card?>" <?php echo (!$hasCard ? 'disabled' : '')?>><b><?php echo $text_card?></b>
                            <?php echo $text_card_info?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="radio" name="method" value="<?php echo $wire?>" checked="checked"><b><?php echo $text_wire?></b>
                            <div class="row">
                                <?php echo $text_wire_info?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="<?php echo $back?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_back?></a>
                        <a href="" class="btn btn-primary" id="button-continue"><?php echo $button_continue?> <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('input[name=\'method\']').on('change', function() {
        $('#button-continue').attr('href',this.value);
    });

    $('input[name=\'method\']:checked').trigger('change');
    //--></script>
<?php echo $footer; ?>