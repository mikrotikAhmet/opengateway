<?php echo $header; ?>
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">New Transaction</div>
                <div class="panel-body">
                    <div class="alert alert-danger" id="error-message" style="display: none">
                        <i class="fa fa-exclamation-circle"></i> <span id="charge-error-message"></span><button type="button" class="close"  onclick="$('#error-message').hide()">×</button>
                    </div>
                    <form id="new-transaction" role="form">
                        <fieldset>
                            <legend><i class="fa fa-credit-card fw"></i> <?php echo $text_card_information?></legend>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><span id="required">*</span> <?php echo $entry_amount?></label>
                                        <input type="text" name="amount" value="" class="form-control amount"/>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><span id="required">*</span> <?php echo $entry_card_number?></label>
                                    <input type="text" name="card_num" value="" class="form-control cc"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label><span id="required">*</span> <?php echo $entry_expire_date?></label>
                                    <select name="exp_month" style="width: auto" class="form-control">
                                        <option value="01" <?php echo ($currentMonth == "01")?"selected":""; ?>><?php echo $month_january?></option>
                                        <option value="02" <?php echo ($currentMonth == "02")?"selected":""; ?>><?php echo $month_february?></option>
                                        <option value="03" <?php echo ($currentMonth == "03")?"selected":""; ?>><?php echo $month_march?></option>
                                        <option value="04" <?php echo ($currentMonth == "04")?"selected":""; ?>><?php echo $month_april?></option>
                                        <option value="05" <?php echo ($currentMonth == "05")?"selected":""; ?>><?php echo $month_may?></option>
                                        <option value="06" <?php echo ($currentMonth == "06")?"selected":""; ?>><?php echo $month_june?></option>
                                        <option value="07" <?php echo ($currentMonth == "07")?"selected":""; ?>><?php echo $month_july?></option>
                                        <option value="08" <?php echo ($currentMonth == "08")?"selected":""; ?>><?php echo $month_august?></option>
                                        <option value="09" <?php echo ($currentMonth == "09")?"selected":""; ?>><?php echo $month_september?></option>
                                        <option value="10" <?php echo ($currentMonth == "10")?"selected":""; ?>><?php echo $month_october?></option>
                                        <option value="11" <?php echo ($currentMonth == "11")?"selected":""; ?>><?php echo $month_november?></option>
                                        <option value="12" <?php echo ($currentMonth == "12")?"selected":""; ?>><?php echo $month_december?></option>
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <label class="control-label">&nbsp;</label>
                                    <select name="exp_year" style="width: auto" class="form-control">
                                        <?php
                                    $i = $currentYear;
                                    while ($i <= ($currentYear+6)) // this gives you six years in the future
                                    {
                                    ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                    $i++;
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label><span id="required">*</span> <?php echo $entry_cvv?></label>
                                    <input type="text" name="cvv" value="" class="form-control cvv"/>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                        <fieldset>
                            <legend><i class="fa fa-user fw"></i> <?php echo $text_customer_information?></legend>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="fa fa-info"></i> <?php echo $text_information?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label><?php echo $entry_existing?></label>
                                        <select name="customer_id" style="width: auto" class="form-control"">
                                            <option value=""><?php echo $text_select?></option>
                                            <?php foreach ($customers as $customer) { ?>
                                                <option value="<?php echo $customer['customer_id']?>"><?php echo $customer['firstname'].' '.strtoupper($customer['lastname'])?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div id="customer-add" style="display: none">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_firstname?></label>
                                            <input type="text" name="customer[firstname]" value="" class="form-control"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_lastname?></label>
                                            <input type="text" name="customer[lastname]" value="" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><?php echo $entry_company?></label>
                                            <input type="text" name="customer[company]" value="" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_address_1?></label>
                                            <input type="text" name="customer[address_1]" value="" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><?php echo $entry_address_2?></label>
                                            <input type="text" name="customer[address_2]" value="" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><span id="required">*</span> <?php echo $entry_country?></label>
                                            <select name="customer[country_id]" style="width: auto" class="form-control">
                                                <?php foreach ($countries as $country) { ?>
                                                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label><span id="required">*</span> <?php echo $entry_city?></label>
                                            <input type="text" name="customer[city]" value="" class="form-control"/>
                                        </div>
                                        <div class="col-sm-4">
                                            <label><?php echo $entry_zone?></label>
                                            <select name="customer[zone_id]" style="width: auto" class="form-control">
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label><?php echo $entry_postcode?></label>
                                            <input type="text" name="customer[postcode]" value="" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label><span id="required">*</span> <?php echo $entry_telephone?></label>
                                            <input type="text" name="customer[telephone]" value="" class="form-control phone"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label><span id="required">*</span> <?php echo $entry_email?></label>
                                            <input type="email" name="customer[email]" value="" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <label><?php echo $entry_description?></label>
                                        <textarea name="additionalInfo[description]" rows="7" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="<?php echo $cancel?>" class="btn" id="button-cancel"><?php echo $button_cancel?></a>
                        <button type="button" class="btn btn-primary" data-loading-text="Charging..." id="button-charge"><?php echo $button_charge?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'customer[country_id]\']').on('change', function() {
        $.ajax({
            url: 'index.php?route=fund/charge/country&token=<?php echo $token; ?>&country_id=' + this.value,
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
<script type="text/javascript"><!--
    $('select[name=\'customer_id\']').on('change', function() {

        var customer = this;

        if (!customer.value){
            $('#customer-add').show();
        } else {
            $('#customer-add').hide();
        }
    });

    $('select[name=\'customer_id\']').trigger('change');
    //--></script>
<?php echo $footer; ?>