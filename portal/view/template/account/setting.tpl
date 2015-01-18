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
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer" class="form-horizontal">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                            <li><a href="#tab-address" data-toggle="tab"><?php echo $tab_address; ?></a></li>
                            <li><a href="#tab-login" data-toggle="tab"><?php echo $tab_login; ?></a></li>
                            <li><a href="#tab-api" data-toggle="tab"><?php echo $tab_api; ?></a></li>
                        </ul>
                        <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <table class="table table-responsive table-striped">
                                <tbody>
                                    <tr>
                                        <td>Account type</td>
                                        <td><?php echo $account_group['name']?></td>
                                    </tr>
                                    <tr>
                                        <td>Account currency</td>
                                        <td><?php echo $currency_code?></td>
                                    </tr>
                                    <tr>
                                        <td>Account language</td>
                                        <td><select name="language_code" id="input-language" class="form-control">
                                                <?php foreach ($languages as $language) { ?>
                                                <?php if ($language['code'] == $language_code) { ?>
                                                <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td>Account holder</td>
                                        <td><?php echo $firstname; ?> <?php echo $lastname; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Account email</td>
                                        <td><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Telephone</td>
                                        <td><?php echo $telephone; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-address">
                            <table class="table table-responsive table-striped">
                                <tbody>
                                <tr>
                                    <td>Country of residence</td>
                                    <td><?php echo $country['name']?></td>
                                </tr>
                                <tr>
                                    <td>Address 1</td>
                                    <td><input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1" class="form-control" />
                                        <?php if ($error_address_1) { ?>
                                        <div class="text-danger"><?php echo $error_address_1; ?></div>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td>Address 2</td>
                                    <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2" class="form-control" /></td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
                                        <?php if ($error_city) { ?>
                                        <div class="text-danger"><?php echo $error_city; ?></div>
                                        <?php  } ?></td>
                                </tr>
                                <tr>
                                    <td>Postcode</td>
                                    <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" /></td>
                                </tr>
                                <tr>
                                    <td>Region / State</td>
                                    <td><?php echo $zone['name']?></td>
                                </tr>
                                <tr>
                                    <td>Timezone</td>
                                    <td><?php echo $gmt_offset?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-login">
                            <table class="table table-responsive table-striped">
                                <tbody>
                                <tr>
                                    <td>Account Username</td>
                                    <td><?php echo $username; ?></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td><input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" autocomplete="off" />
                                        <?php if ($error_password) { ?>
                                        <div class="text-danger"><?php echo $error_password; ?></div>
                                        <?php  } ?></td>
                                </tr>
                                <tr>
                                    <td>Confirm</td>
                                    <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" autocomplete="off" id="input-confirm" class="form-control" />
                                        <?php if ($error_confirm) { ?>
                                        <div class="text-danger"><?php echo $error_confirm; ?></div>
                                        <?php  } ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-api">
                            <p><?php echo $text_api_access?></p>
                            <div class="alert alert-warning">
                                <p><i class="fa fa-exclamation-circle"></i> <?php echo $warning_api_access?></p>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-descriptor"><?php echo $entry_descriptor; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="descriptor" value="<?php echo $descriptor; ?>" placeholder="<?php echo $entry_descriptor; ?>" id="input-descriptor" class="form-control" disabled/>
                                </div>
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
                        </div>
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

    //--></script>
<?php echo $footer; ?>