<footer>
  <div class="container">
    <p class="pull-left"><?php echo $powered; ?><br/><?php echo $version; ?></p>
      <p class="pull-right"><div class="credit_card_footer_seal"></div></p>
  </div>
</footer>
<!-- add card Form modal -->
<div id="add_card_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-credit-card fw"></i> <?php echo $text_add_card?></h4>
            </div>

            <!-- Form inside modal -->
            <form id="add-card" role="form">
                <div class="alert alert-danger" id="error-message" style="display: none">
                    <i class="fa fa-exclamation-circle"></i> <span id="card-error-message"></span><button type="button" class="close"  onclick="$('#error-message').hide()">×</button>
                </div>
                <div class="modal-body with-padding">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?php echo $text_accepted_cards?></h6>
                        <div id="credit-cards"></div>
                    </div>
                    <div class="form-group">
                        <label><?php echo $entry_card_number?></label>
                        <input type="text" name="card_num" value="" class="form-control cc"/>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label><?php echo $entry_expire_date?></label>
                                <select name="month" style="width: auto" class="form-control">
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

                            <div class="col-sm-6">
                                <label class="control-label">&nbsp;</label>
                                <select name="year" style="width: auto" class="form-control">
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
                            <div class="col-sm-4">
                                <label><?php echo $entry_cvv?></label>
                                <input type="text" name="cvv" value="" class="form-control cvv"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $button_cancel?></button>
                    <button type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-add-verify"><?php echo $button_save_verify?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /add card form modal -->
<!-- deposit Form modal -->
<div id="deposit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-money fw"></i> <?php echo $text_make_deposit?></h4>
            </div>

            <!-- Form inside modal -->
            <form id="makeDeposit" role="form">
                <div class="alert alert-danger" id="error-message2" style="display: none">
                    <i class="fa fa-exclamation-circle"></i> <span id="card-error-message2"></span><button type="button" class="close"  onclick="$('#error-message2').hide()">×</button>
                </div>
                <div class="modal-body with-padding">
                    <div class="block-inner text-danger">
                        <h4 class="heading-hr" style="display: none" id="verification"> <?php echo $text_card_unverified?></h4>
                        <small id="deposit-limit" ><?php echo $text_unverified_information?></small>
                    </div>
                    <div class="form-group">
                        <label><?php echo $entry_amount?></label>
                        <input type="text" name="amount" value="" class="form-control amount"/>
                        <input type="hidden" name="card_id" value=""/>
                        <input type="hidden" name="verification" value=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $button_cancel?></button>
                    <button type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-make-deposit"><?php echo $button_make_deposit?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /deposit form modal -->
<!-- verification Form modal -->
<div id="verification_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-shield fw"></i> Credit / Debit card verification</h4>
            </div>

            <!-- Form inside modal -->
            <form id="startVerification" role="form">
                <div class="alert alert-danger" id="error-verification" style="display: none">
                    <i class="fa fa-exclamation-circle"></i> <span id="verification-error-message"></span><button type="button" class="close"  onclick="$('#error-verification').hide()">×</button>
                </div>
                <div class="modal-body with-padding">
                    <div class="block-inner text-danger">
                    </div>
                    <div class="form-group">
                        <label>Verification code</label>
                        <input type="text" name="code" placeholder="XXXX" value="" class="form-control verification"/>
                        <input type="hidden" name="verification_card_id" value=""/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $button_cancel?></button>
                    <button type="button" class="btn btn-primary" data-loading-text="Loading..." id="button-do-verification"> Verify card now</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /verification form modal -->
</body>
</html>