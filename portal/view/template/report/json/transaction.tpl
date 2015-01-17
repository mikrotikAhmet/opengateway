<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $text_last_transaction?></div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover transaction" id="transactions">
                    <thead>
                    <tr>
                        <th class="text-left"><?php echo $column_date_added?></th>
                        <th class="text-left"><?php echo $column_description?></th>
                        <th class="text-left"><?php echo $column_fee?></th>
                        <th class="text-right"><?php echo $column_amount?></th>
                        <th class="text-right"><?php echo $column_status?></th>
                        <th class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($transactions) { ?>
                    <?php foreach ($transactions as $transaction) { ?>
                    <tr class="" id="<?php echo $transaction['transaction_id']?>">
                        <td class="text-left"><?php echo $transaction['date_added']; ?></td>
                        <td class="text-left"><?php echo $transaction['type']; ?></td>
                        <td class="text-left"><?php echo $transaction['fee']; ?></td>
                        <td class="text-right"><?php echo $transaction['amount']; ?></td>
                        <td class="text-right"><?php echo $transaction['status']; ?></td>
                        <td class="text-center"><i class="expand fa fa-plus" style="cursor: pointer"></i></td>
                    </tr>
                    <tr class="">
                        <td colspan="7">
                            <div id="transaction-details-<?php echo $transaction['transaction_id']?>">
                                <div class="loading">
                                    <img src="view/image/loading/spinner.gif">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="7"><?php echo $text_no_transaction; ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if ($showpagination) { ?>
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
            <?php } ?>
        </div>
        <div class="panel-footer">
            <div class="text-right">
                <a href="<?php echo $transaction_all?>" class="btn"><?php echo $button_all_transaction?></a>
            </div>
        </div>
    </div>
    <?php //echo $promotion?>
    <script>

        $("#transactions tr:odd").addClass("master");
        $("#transactions tr:not(.master)").hide();
        $("#transactions tr:first-child").show();

        $("#transactions tr.master").click(function() {

            if ($(this).next("tr").css('display') == 'none'){
                $('#transaction-details-'+this.id).load('index.php?route=report/transaction/detail&token=<?php echo $token; ?>&transaction_id='+this.id+'&json=true');
            }

            $(this).next("tr").toggle();
            $(this).find(".expand").toggleClass("fa-minus");
            $(this).toggleClass("selected");

        });
    </script>
</div>