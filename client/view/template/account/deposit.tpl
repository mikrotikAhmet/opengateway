<?php echo $header?>
<div id="contentpanel-full">
    <div class="box open">
        <div class="box-title">
            <div>
                <?php echo $text_money_upload_step_1?>
            </div>
        </div>
        <form action="<?php echo $card?>" method="post" enctype="multipart/form-data" id="upload-method" class="form-horizontal form-bordered" role="form">
            <div class="box-content tabular-view">
                <div class="panel">
                    <input type="radio" name="upload_method" rel="<?php echo $card?>" id="upload" checked=""> <strong><?php echo $text_card_upload?></strong>
                    <p><?php echo $text_card_upload_info_1?></p>
                    <p><?php echo $text_card_upload_info_2?></p>
                </div>
                <div class="panel">
                    <input type="radio" name="upload_method" rel="<?php echo $manual?>" id="upload"> <strong><?php echo $text_manual_upload?></strong>
                    <p><?php echo $text_manual_upload_info_1?></p>
                </div>
                <div class="panel">
                    <a  href="<?php echo $home?>" class="btn"><i class="icon-arrow-left5"></i> <?php echo $button_back?></a>
                    <a  href="javascript::void()" id="continue" onclick ="$('form[id=\'upload-method\']').submit()" class="btn"><?php echo $button_continue?> <i class="icon-arrow-right5"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>
<script><!--

//--></script>
<?php echo $footer?>