<fieldset>
    <dl>
        <dt>Transaction ID</dt>
        <dd>: <?php echo $transaction['general']['transaction_id']?> <a href="index.php?route=report/transaction/detail&token=<?php echo $token?>&transaction_id=<?php echo $transaction['general']['transaction_id']?>" class=""><i class="fa fa-eye fw"></i> View details</a> </dd>
    </dl>

    <!-- Charged -->
    <?php if ($transaction['general']['charged']) { ?>
    <?php if (isset($transaction['customer']['name'])) { ?>
    <dl>
        <dt>Card holder</dt>
        <dd>: <strong><?php echo $transaction['customer']['name']?></strong></dd>
    </dl>
    <?php } else { ?>
    <dl>
        <dt>Charge description</dt>
        <?php if (isset($transaction['general']['additionalInfo']['description'])) { ?>
        <dd>: <strong><?php echo $transaction['general']['additionalInfo']['description']?></strong></dd>
        <?php } else { ?>
        <dd>: <strong><?php echo $transaction['authorization']['tracking_code']?></strong></dd>
        <?php } ?>
    </dl>
    <?php } ?>
    <dl>
        <dt>Card number</dt>
        <dd>: <?php echo $transaction['general']['card_number'].' '. strtoupper($transaction['general']['card_type'])?></dd>
    </dl>
    <?php if ($transaction['authorization']['external_transaction_id'] && $transaction['authorization']['transaction_state']) { ?>
    <div class="pull-right">
        <button type="button" class="btn btn-xs btn-primary" onclick="makeRefund(this,'<?php echo $transaction['general']['transaction_id']?>')"><i class="fa fa-reply fw"></i> Make Refund</button>
    </div>
    <?php } ?>
    <?php } ?>

    <!-- Authorized -->
    <?php if ($transaction['general']['authorized']) { ?>
    <?php if (isset($transaction['customer']['name'])) { ?>
    <dl>
        <dt>Card holder</dt>
        <dd>: <strong><?php echo $transaction['customer']['name']?></strong></dd>
    </dl>
    <?php } else { ?>
    <dl>
        <dt>Authorization description</dt>
        <?php if (isset($transaction['general']['additionalInfo']['description'])) { ?>
        <dd>: <strong><?php echo $transaction['general']['additionalInfo']['description']?></strong></dd>
        <?php } else { ?>
        <dd>: <strong><?php echo $transaction['authorization']['tracking_code']?></strong></dd>
        <?php } ?>
    </dl>
    <?php } ?>
    <dl>
        <dt>Card number</dt>
        <dd>: <?php echo $transaction['general']['card_number'].' '. strtoupper($transaction['general']['card_type'])?></dd>
    </dl>
    <?php if ($transaction['authorization']['external_transaction_id']) { ?>
    <div class="pull-right">
        <button type="button" class="btn btn-xs btn-primary" onclick="makeCapture(this,'<?php echo $transaction['general']['transaction_id']?>')"><i class="fa fa-check fw"></i> Capture</button>
        <button type="button" class="btn btn-xs btn-info" onclick="makeVoid(this,'<?php echo $transaction['general']['transaction_id']?>')"><i class="fa fa-close fw"></i> Void</button>
    </div>
    <?php } ?>
    <?php } ?>


    <!-- Captured -->
    <?php if ($transaction['general']['captured']) { ?>
    <?php if (isset($transaction['customer']['name'])) { ?>
    <dl>
        <dt>Card holder</dt>
        <dd>: <strong><?php echo $transaction['customer']['name']?></strong></dd>
    </dl>
    <?php } else { ?>
    <dl>
        <dt>Charge description</dt>
        <?php if (isset($transaction['general']['additionalInfo']['description'])) { ?>
        <dd>: <strong><?php echo $transaction['general']['additionalInfo']['description']?></strong></dd>
        <?php } else { ?>
        <dd>: <strong><?php echo $transaction['authorization']['tracking_code']?></strong></dd>
        <?php } ?>
    </dl>
    <?php } ?>
    <dl>
        <dt>Card number</dt>
        <dd>: <?php echo $transaction['general']['card_number'].' '. strtoupper($transaction['general']['card_type'])?></dd>
    </dl>
    <?php if ($transaction['authorization']['external_transaction_id'] && $transaction['authorization']['transaction_state']) { ?>
    <div class="pull-right">
        <button type="button" class="btn btn-xs btn-primary" onclick="makeRefund(this,'<?php echo $transaction['general']['transaction_id']?>')"><i class="fa fa-reply fw"></i> Make Refund</button>
    </div>
    <?php } ?>
    <?php } ?>

<!-- Refund -->
    <?php if ($transaction['general']['refunded']) { ?>
    <dl>
        <dt>Reference TC</dt>
        <dd>: <?php echo $transaction['authorization']['tracking_code']?></dd>
    </dl>
    <?php } ?>

    <!-- Void -->
    <?php if ($transaction['general']['voided']) { ?>
    <dl>
        <dt>Reference TC</dt>
        <dd>: <?php echo $transaction['authorization']['tracking_code']?></dd>
    </dl>
    <?php } ?>
</fieldset>