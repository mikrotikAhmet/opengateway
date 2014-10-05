<?php echo $header?>
<div id="contentpanel-full">
    <?php if ($error_warning) { ?>
    <p class="msg-error">
            <?php echo $error_warning?>
            <?php echo $notification_remove?>
    </p>
    <?php } ?>
    <div class="box open">
        <div class="box-title">
            <div>
                <?php echo $text_card_upload_step_2?>
            </div>
        </div>
        <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" id="upload-money" class="form-horizontal form-bordered" role="form">
            <div class="box-content tabular-view">
                <div class="left" style="width: 30%">
                    <div class="cards">
                        <?php if ($cards) { ?>
                        <?php foreach ($cards as $card) { ?>
                        <div class="panel">
                            <input type="radio" name="card"  id="card" value="<?php echo $card['customer_card_id']?>"> <?php echo strtoupper($card['cardholder'])?> - <?php echo strtoupper($card['card_number'])?><br/><img src="<?php echo $card['image']?>">
                        </div>
                        <?php } ?>
                        <?php } else { ?>
                        <?php echo $error_no_card?>
                        <?php } ?>
                    </div>
                </div>
                <div class="right" style="width: 70%">
                    <div class="panel">
                        <h2><?php echo $entry_amount?></h2>
                        <p>
                            <input type="text" name="amount" value="">
                            <cite class="hint"><?php echo $text_amount_help?></cite>
                        </p>
                    </div>
                    <div class="panel">
                        <a  href="<?php echo $back?>" class="btn"><i class="icon-arrow-left5"></i> <?php echo $button_back?></a>
                        <button   id="continue"  class="btn"><?php echo $button_continue?> <i class="icon-arrow-right5"></i></button>
                    </div> 
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'currency_code\']').trigger('change');
    //--></script> 
<?php echo $footer?>