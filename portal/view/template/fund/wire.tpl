<?php echo $header; ?>
<hr/>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $text_upload_step_2?></div>
                <div class="panel-body">
                    <fieldset>
                        <legend><?php echo $text_upload_step_2_1?></legend>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <select name="currency_code" id="input-currency" class="form-control">
                                    <?php foreach ($currencies as $currency) { ?>
                                    <?php if ($currency['code'] == $currency_code) { ?>
                                    <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['code']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend><?php echo $text_upload_step_2_2?></legend>
                        <div id="bank-account">

                        </div>
                    </fieldset>
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="<?php echo $back?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_back?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <p><?php echo $text_withdraw_information?></p>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'currency_code\']').on('change', function() {
        $.ajax({
            url : 'index.php?route=fund/wire/banks&token=<?php echo $token?>&currency_code='+this.value,
            type: 'post',
            dataType: 'html',
            data: 'currency_code=' + encodeURIComponent(this.value),
            success : function(html){
                $('#bank-account').html(html);
            },
        error : function(){
            alert('error');
        }
        });
    });

    $('select[name=\'currency_code\']').trigger('change');
    //--></script>
<?php echo $footer; ?>