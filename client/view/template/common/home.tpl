<?php echo $header?>
<!-- Main content-->
<div id="contentpanel">
    <div class="box open">
        <div class="box-title">
            <div>
                <i class="icon-transmission"></i> <?php echo $text_last_transaction?>
            </div>
        </div>
        <div class="box-content tabular-view">
            <table id="last-transactions">
                <thead>
                    <tr>
                        <th><?php echo $column_transaction?></th>
                        <th><?php echo $column_type?></th>
                        <th><?php echo $column_total?></th>
                        <th><?php echo $column_date?></th>
                        <th><?php echo $column_status?></th>
                        <th></th>
                    </tr>
                </thead>
                <?php if ($transactions) { ?>
                <tbody>
                    <?php foreach ($transactions as $transaction) {  ?>
                    <tr>
                        <td><?php echo $transaction['transaction_id']?></td>
                        <td><?php echo $transaction['action']?></td>
                        <td><?php echo $transaction['total']?></td>
                        <td><?php echo $transaction['date']?></td>
                        <td><?php echo $transaction['status']?></td>
                        <td><i class="expand icon-plus"></i></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="transaction-details">
                                <ul>
                                    <li>
                                        <strong>Invoice # :</strong> <?php echo $transaction['invoice_no']?>
                                    </li>
                                    <li>
                                        <strong>IDescription :</strong> <?php echo $transaction['description']?>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <?php } else { ?>
                <tfoot>
                    <tr>
                        <td colspan="4"><?php echo $text_no_result?>.</td>
                    </tr>
                </tfoot>
                <?php }?>
            </table>
        </div>
    </div>
</div>
<!-- /main content-->
<!-- Side content -->
<div id="sidebar">
    <div class="box open">
        <div class="box-title">
            <div>
                <i class="icon-coin"></i> <?php echo $text_general_balance?>
            </div>
        </div>
        <div class="box-content tabular-view">
            <?php echo $text_balance?><h3><?php echo $balance?></h3>
            <br/>
            <p>
                <a href="<?php echo $deposit?>" class="btn" type="button"><i class="icon-arrow-up"></i> <?php echo $button_deposit?></a>
                <a href="#" class="btn" type="button"><i class="icon-arrow-down"></i> <?php echo $button_withdraw?></a>
            </p>
            <p><a href="#" class="btn" type="button"><i class="icon-arrow-right7"></i> <?php echo $button_send?></a></p>
        </div>
    </div>
</div>
<!-- /side content-->
<script><!-- 
    $("#last-transactions").jExpand();
    //--></script>
<?php echo $footer?>