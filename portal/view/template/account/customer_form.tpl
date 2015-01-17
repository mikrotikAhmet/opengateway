<?php echo $header; ?>
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-md-8">
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $text_form?></div>
                <div class="panel-body">
                    <div class="alert alert-danger" id="error-message" style="display: none">
                        <i class="fa fa-exclamation-circle"></i> <span id="charge-error-message"></span><button type="button" class="close"  onclick="$('#error-message').hide()">×</button>
                    </div>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer" class="">
                        <fieldset>
                            <legend><i class="fa fa-user fw"></i> <?php echo $text_customer_information?></legend>
                            <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_firstname?></label>
                                            <input type="text" name="customer[firstname]" value="<?php echo $firstname?>" class="form-control"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_lastname?></label>
                                            <input type="text" name="customer[lastname]" value="<?php echo $lastname?>" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><?php echo $entry_company?></label>
                                            <input type="text" name="customer[company]" value="<?php echo $company?>" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_address_1?></label>
                                            <input type="text" name="customer[address_1]" value="<?php echo $address_1?>" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><?php echo $entry_address_2?></label>
                                            <input type="text" name="customer[address_2]" value="<?php echo $address_2?>" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_country?></label>
                                            <select name="customer[country_id]" style="width: auto" class="form-control">
                                                <?php foreach ($countries as $country) { ?>
                                                <?php if ($country_id == $country['country_id']) { ?>
                                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label><span id="required">*</span> <?php echo $entry_city?></label>
                                            <input type="text" name="customer[city]" value="<?php echo $city?>" class="form-control"/>
                                        </div>
                                        <div class="col-sm-4">
                                            <label><?php echo $entry_zone?></label>
                                            <select name="customer[zone_id]" style="width: auto" class="form-control">
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label><?php echo $entry_postcode?></label>
                                            <input type="text" name="customer[postcode]" value="<?php echo $postcode?>" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label><span id="required">*</span> <?php echo $entry_telephone?></label>
                                            <input type="text" name="customer[telephone]" value="<?php echo $telephone?>" class="form-control phone"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label><span id="required">*</span> <?php echo $entry_email?></label>
                                            <input type="email" name="customer[email]" value="<?php echo $email?>" class="form-control" <?php echo (!$customer_id ? '' : 'disabled')?>/>
                                        </div>
                                    </div>
                                </div>
                        </fieldset>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="<?php echo $cancel?>" class="btn" id="button-cancel"><?php echo $button_cancel?></a>
                        <button type="button" class="btn btn-primary" data-loading-text="Saving..." id="button-save" onclick="$('#form-customer').submit()"><?php echo $button_save?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'customer[country_id]\']').on('change', function() {
        $.ajax({
            url: 'index.php?route=account/customer/country&token=<?php echo $token; ?>&country_id=' + this.value,
            dataType: 'json',
            beforeSend: function() {
                $('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
            },
            complete: function() {
                $('.fa-spin').remove();
            },
            success: function(json) {
                $('.fa-spin').remove();

                html = '<option value=""><?php echo $text_select; ?></option>';

                if (json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                        if (json['zone'][i]['zone_id'] == '<?php echo $zone_id?>') {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                }

                $('select[name=\'customer[zone_id]\']').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name=\'customer[country_id]\']').trigger('change');
    //--></script>
<?php echo $footer; ?>