<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Send money via Semite Payments</div>
                <div class="panel-body">
                    <div class="alert alert-danger" id="error-send-message" style="display: none">
                        <i class="fa fa-exclamation-circle"></i> <span id="send-error-message"></span><button type="button" class="close"  onclick="$('#error-send-message').hide()">×</button>
                    </div>
                    <form action="" enctype="multipart/form-data" class="form-horizontal" id="send-money">
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-amount"><?php echo $entry_amount; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="amount" value="" placeholder="<?php echo $entry_amount; ?>" id="input-amount" class="form-control amount" />
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="<?php echo $back?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel?></a>
                        <button type="button" class="btn btn-primary" id="button-send-money" data-link=""><?php echo $button_send_money?> <i class="fa fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <p><?php echo $text_attention?></p>
            <span class="alert alert-info">
                <i class="fa fa-exclamation-circle"></i> <?php echo $text_info?>
            </span>
        </div>
    </div>
</div>

<?php echo $footer; ?>