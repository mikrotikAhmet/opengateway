<?php echo $header; ?>
<div class="container">
    <div class="row">
        <?php if ($transaction){ ?>
        <div class="col-lg-12">
            <div class="pull-right">
                <a href="<?php echo $back?>" class="btn btn-info"><i class="fa fa-reply"></i> Back to dashboard</a>
            </div>
            <fieldset>
                <legend>Transaction Details</legend>
                <h4>Details for transaction#<?php echo $transaction['general']['transaction_id']?></h4>
                <table class="table table-responsive table-hover table-striped">
                    <tr>
                        <td width="15%">Amount</td>
                        <td><?php echo $transaction['general']['amount']?>
                            <?php if (($transaction['general']['charged'] || $transaction['general']['captured']) && $transaction['authorization']['external_transaction_id'] && $transaction['authorization']['transaction_state']) { ?>
                                <button type="button" class="btn btn-xs btn-link" onclick="makeRefund(this,'<?php echo $transaction['general']['transaction_id']?>')"><i class="fa fa-reply fw"></i> Make Refund</button>
                            <?php } ?>
                            <?php if ($transaction['general']['authorized'] && $transaction['authorization']['external_transaction_id']) { ?>
                            <button type="button" class="btn btn-xs btn-primary" onclick="makeCapture(this,'<?php echo $transaction['general']['transaction_id']?>')"><i class="fa fa-check fw"></i> Capture</button>
                            <button type="button" class="btn btn-xs btn-info" onclick="makeVoid(this,'<?php echo $transaction['general']['transaction_id']?>')"><i class="fa fa-close fw"></i> Void</button>
                            <?php } ?>
                            <?php if ($transaction['general']['refunded']) { ?>
                                <span class="text-muted">Refunded</span>
                            <?php } elseif ($transaction['general']['voided']) { ?>
                            <span class="text-muted">Voided</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction date</td>
                        <td><?php echo $transaction['general']['transaction_date']?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <?php if (!$transaction['authorization']['external_transaction_id'] || !$transaction['authorization']['transaction_state']) { ?>
                        <td><span class="text-danger"><?php echo $transaction['general']['status']?></span></td>
                        <?php } else { ?>
                        <td><span class="text-success"><?php echo $transaction['general']['status']?></span></td>
                        <?php } ?>
                    </tr>
                    <?php if (isset($transaction['general']['card_number']) && !empty($transaction['general']['card_type'])) { ?>
                    <tr>
                        <td>Card number</td>
                        <td><?php echo $transaction['general']['card_number']?> <img src="view/image/cards/<?php echo $transaction['general']['card_type']?>.png" style="width: 45px;bottom: 5px;position: relative;"/></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>Gateway</td>
                        <td><a href="#"><?php echo $transaction['general']['gateway']?></a></td>
                    </tr>
                    <tr>
                        <td colspan="1">
                            <p>Description</p>
                        </td>
                        <td>
                            <pre>
                                <?php if (isset($transaction['general']['additionalInfo']['description'])) { ?>
                                <i class="fa fa-shopping-cart"></i> <?php echo $transaction['general']['additionalInfo']['description']?>
                                <?php } else { ?>
                                <i class="fa fa-shopping-cart"></i> <?php echo $transaction['authorization']['tracking_code']?>
                                <?php } ?>
                            </pre>
                        </td>
                    </tr>
                </table>
                <?php if (isset($transaction['customer'])) { ?>
                <h4>Customer Information</h4>
                <table class="table table-responsive table-hover table-striped">
                    <tr>
                        <td width="15%">Name</td>
                        <td><?php echo $transaction['customer']['name']?></td>
                    </tr>
                    <tr>
                        <td>Email address</td>
                        <td><?php echo $transaction['customer']['email']?></td>
                    </tr>
                    <tr>
                        <td>Company</td>
                        <td><?php echo $transaction['customer']['company']?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><?php echo $transaction['customer']['address']?></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><?php echo $transaction['customer']['phone']?></a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="pull-left"><a href="<?php echo $transaction['customer']['href']?>" class="btn"><i class="fa fa-edit fw"></i> Edit customer information</a></span></td>
                    </tr>
                </table>
                <?php } ?>
                <h4>Authorization Information</h4>
                <table class="table table-responsive table-hover table-striped">
                    <tr>
                        <td width="15%">Transaction id</td>
                        <td><?php echo $transaction['authorization']['transaction_id']?></td>
                    </tr>
                    <tr>
                        <td>Tracking code</td>
                        <td><?php echo $transaction['authorization']['tracking_code']?></td>
                    </tr>
                    <tr>
                        <td>Transaction GUID</td>
                        <td><?php echo $transaction['authorization']['transaction_guid']?></td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <?php } else { ?>
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-info"></i> Transaction that you are looking for could not be found.Please check your transaction id or contact to support.
                </div>
            </div>
        <?php } ?>
        <div class="pull-right">
            <a href="<?php echo $back?>" class="btn btn-info"><i class="fa fa-reply"></i> Back to dashboard</a>
        </div>
    </div>
</div>
<?php echo $footer; ?>