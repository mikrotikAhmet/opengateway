<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account"
                      class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-address" data-toggle="tab"><?php echo $tab_address; ?></a></li>
                        <li><a href="#tab-login" data-toggle="tab"><?php echo $tab_login; ?></a></li>
                        <li><a href="#tab-processor" data-toggle="tab"><?php echo $tab_processor; ?></a></li>
                        <li><a href="#tab-api" data-toggle="tab"><?php echo $tab_api; ?></a></li>
                        <li><a href="#tab-ip" data-toggle="tab"><?php echo $tab_ip; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-account-group"><?php echo $entry_account_group; ?></label>
                                <div class="col-sm-10">
                                    <select name="account_group_id" id="input-account-group" class="form-control">
                                        <?php foreach ($account_groups as $account_group) { ?>
                                        <?php if ($account_group['account_group_id'] == $account_group_id) { ?>
                                        <option value="<?php echo $account_group['account_group_id']; ?>" selected="selected"><?php echo $account_group['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $account_group['account_group_id']; ?>"><?php echo $account_group['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-currency"><?php echo $entry_currency; ?></label>
                                <div class="col-sm-10">
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
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-language"><?php echo $entry_language; ?></label>
                                <div class="col-sm-10">
                                    <select name="language_code" id="input-language" class="form-control">
                                        <?php foreach ($languages as $language) { ?>
                                        <?php if ($language['code'] == $language_code) { ?>
                                        <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
                                    <?php if ($error_firstname) { ?>
                                    <div class="text-danger"><?php echo $error_firstname; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
                                    <?php if ($error_lastname) { ?>
                                    <div class="text-danger"><?php echo $error_lastname; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                                    <?php if ($error_email) { ?>
                                    <div class="text-danger"><?php echo $error_email; ?></div>
                                    <?php  } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control phone" />
                                    <?php if ($error_telephone) { ?>
                                    <div class="text-danger"><?php echo $error_telephone; ?></div>
                                    <?php  } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="status" id="input-status" class="form-control">
                                        <?php if ($status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-livemode"><?php echo $entry_livemode; ?></label>
                                <div class="col-sm-10">
                                    <select name="livemode" id="input-livemode" class="form-control">
                                        <?php if ($livemode) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-address">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
                                <div class="col-sm-10">
                                    <select name="country_id" id="input-country" class="form-control">
                                        <?php foreach ($countries as $country) { ?>
                                        <?php if ($country['country_id'] == $country_id) { ?>
                                        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <?php if ($error_country_id) { ?>
                                    <div class="text-danger"><?php echo $error_country_id; ?></div>
                                    <?php  } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-address-1"><?php echo $entry_address_1; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1" class="form-control" />
                                    <?php if ($error_address_1) { ?>
                                    <div class="text-danger"><?php echo $error_address_1; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-address-2"><?php echo $entry_address_2; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
                                    <?php if ($error_city) { ?>
                                    <div class="text-danger"><?php echo $error_city; ?></div>
                                    <?php  } ?>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
                                <div class="col-sm-10">
                                    <select name="zone_id" id="input-zone" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-gmt_offset"><?php echo $entry_gmt_offset; ?></label>
                                <div class="col-sm-10">
                                    <select name="gmt_offset" id="input-gmt_offset" class="form-control">
                                        <option value="0"><?php echo $text_select?></option>
                                        <?php foreach ($time_zones as $key=>$time_zone) { ?>
                                        <?php if ($gmt_offset == $time_zone) { ?>
                                        <option value="<?php echo $time_zone; ?>" selected="selected"><?php echo $key; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $time_zone; ?>"><?php echo $key; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-login">
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_username; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-firstname" class="form-control" />
                                    <?php if ($error_username) { ?>
                                    <div class="text-danger"><?php echo $error_username; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" autocomplete="off" />
                                    <?php if ($error_password) { ?>
                                    <div class="text-danger"><?php echo $error_password; ?></div>
                                    <?php  } ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
                                <div class="col-sm-10">
                                    <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" autocomplete="off" id="input-confirm" class="form-control" />
                                    <?php if ($error_confirm) { ?>
                                    <div class="text-danger"><?php echo $error_confirm; ?></div>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-processor">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-processor-id"><?php echo $entry_processor_id; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="merchantID" value="<?php echo $processor_id; ?>" placeholder="<?php echo $entry_processor_id; ?>" id="input-processor-id" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-processor-guid"><?php echo $entry_processor_guid; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="merchantGUID" value="<?php echo $processor_guid; ?>" placeholder="<?php echo $entry_processor_guid; ?>" id="input-processor-guid" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-processor-id"><?php echo $entry_processor_id_amex; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="merchantID_amex" value="<?php echo $processor_id_amex; ?>" placeholder="<?php echo $entry_processor_id_amex; ?>" id="input-processor-id" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-processor-guid"><?php echo $entry_processor_guid_amex; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="merchantGUID_amex" value="<?php echo $processor_guid_amex; ?>" placeholder="<?php echo $entry_processor_guid_amex; ?>" id="input-processor-guid" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-api">
                            <p><?php echo $text_api_access?></p>
                            <div class="alert alert-warning">
                                <p><i class="fa fa-exclamation-circle"></i> <?php echo $warning_api_access?></p>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-api-id"><?php echo $entry_api_id; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="api_id" value="<?php echo $api_id; ?>" placeholder="<?php echo $entry_api_id; ?>" id="input-api-id" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-secret-key"><?php echo $entry_secret_key; ?></label>
                                <div class="col-sm-10">
                                    <textarea name="secret_key" placeholder="<?php echo $entry_secret_key; ?>" rows="5" id="input-secret-key" class="form-control"><?php echo $secret_key; ?></textarea>
                                    <br />
                                    <button type="button" id="button-generate" class="btn btn-primary" data-loading-text="Generating Keys..."><i class="fa fa-refresh"></i> <?php echo $button_generate; ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-ip">
                            <div id="ip"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'country_id\']').on('change', function() {
        $.ajax({
            url: 'index.php?route=account/account/country&token=<?php echo $token; ?>&country_id=' + this.value,
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

                        if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                }

                $('select[name=\'zone_id\']').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name=\'country_id\']').trigger('change');
    //--></script>
<script type="text/javascript"><!--
    $('select[name=\'account_group_id\']').on('change', function() {
       // do something
    });

    $('select[name=\'customer_group_id\']').trigger('change');
    //--></script>
<script type="text/javascript"><!--
    $('#ip').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#ip').load(this.href);
    });

    $('#ip').load('index.php?route=account/account/ip&token=<?php echo $token; ?>&account_id=<?php echo $account_id; ?>');
//--></script>
<?php echo $footer; ?>