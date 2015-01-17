<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading"><?php echo $text_filter_transaction?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><?php echo $text_date_range?></label>
                        <select name="date_interval" class="form-control">
                            <option value="30"><?php echo $interval_m_30?></option>
                            <option value="60"><?php echo $interval_m_60?></option>
                            <option value="90"><?php echo $interval_m_90?></option>
                            <option value="180"><?php echo $interval_m_180?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input-filter-date-start">From date</label>
                        <div class="">
                            <div class="input-group date">
                                <input type="text" name="filter_date_start" value="<?php echo $filter_date_start?>" data-format="YYYY-MM-DD" id="input-filter-date-start" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input-filter-date-end">To date</label>
                        <div class="">
                            <div class="input-group date">
                                <input type="text" name="filter_date_end" value="<?php echo $filter_date_end?>" data-format="YYYY-MM-DD" id="input-filter-date-end" class="form-control" />
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                </span></div>
                        </div>
                    </div>
                    <p><a onclick="filter();" class="btn" type="button" id="button-search"><i class="icon-search2"></i> Search</a></p>
                    <a href="<?php echo $export?>">Export CSV</a>
                </div>
                <div class="panel-footer">By email or transaction ID</div>
            </div>
        </div>
        <div class="col-md-9">
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
    </div>
</div>
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
<script type="text/javascript"><!--

    function filter() {
        url = 'index.php?route=report/transaction/allTransactions&token=<?php echo $token; ?>&all=0';

        var filter_date_start = $('input[name=\'filter_date_start\']').val();

        if (filter_date_start) {
            url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
        }

        var filter_date_end = $('input[name=\'filter_date_end\']').val();

        if (filter_date_end) {
            url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
        }

        var date_interval = $('select[name=\'date_interval\']').val();

        url +='&date_interval='+ encodeURIComponent(date_interval);

        window.location = url;
    }

    $('select[name=\'date_interval\']').on('change',function(){

        var dateEnd = $('input[name=\'filter_date_end\']').val();

        var interval = DateRemove(new Date(dateEnd),'d',this.value)

        $('input[name=\'filter_date_start\']').val(interval.toISOString().substring(0, 10));

    });

    $('select[name=\'date_interval\']').trigger('change');

    $('select[name=\'date_interval\']').find('option[value="<?php echo $date_interval?>"]').attr("selected",true);

    $('.date').datetimepicker({
        pickTime: false
    });
    //--></script>
<?php echo $footer; ?>