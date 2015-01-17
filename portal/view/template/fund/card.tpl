<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $text_upload_step_2?></div>
                <div class="panel-body">
                    <?php foreach ($cards as $card) { ?>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="radio" name="card" value="<?php echo $card['card_id']?>"> <?php echo strtoupper($card['type'])?> - <b><?php echo $card['card_num']?></b>
                            <p><?php echo $text_fingerprint?> <b><?php echo $card['fingerprint']?></b></p>
                            <?php if ((empty($card['token']) && $card['verified'])) { ?>
                                <p><?php echo $text_status?> <b><span><?php echo $card['text_verified'];?></span></b></p>
                            <?php } elseif ((empty($card['token']) && !$card['verified'])) { ?>
                            <p><?php echo $text_status?> <b><span onclick="verifyCard(this,'<?php echo $card['card_id']?>')"><?php echo $card['text_verified'];?></span></b></p>
                            <?php } else { ?>
                            <p><?php echo $text_status?> <button class="btn btn-primary" onclick="doVerification(this,'<?php echo $card['card_id']?>')">Verify now</button></p>
                            <?php } ?>
                            <input type="hidden" name="card_<?php echo $card['card_id']?>" id="card-info" data-card="<?php echo $card['card_id']?>" value="<?php echo $card['verified']?>"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                    <?php } ?>
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="<?php echo $back?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_back?></a>
                        <button type="button" class="btn btn-primary" id="button-deposit" data-link=""><?php echo $button_continue?> <i class="fa fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('input[name=\'card\']').on('change', function() {
        $('#button-deposit').attr('data-link',this.value);
        $('#button-deposit').attr('data-rel',$(this).attr('data-content'));
    });
    //--></script>
<?php echo $footer; ?>