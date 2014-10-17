<?php echo $header?>
<!-- Main content-->
<div id="contentpanel">
    <div class="box open">
        <div class="box-title">
            <div>
                <i class="icon-transmission"></i> <?php echo $heading_title?>
            </div>
        </div>
        <div class="box-content tabular-view">
            <table id="all-transactions" class="details">
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
                    <td><span class="transaction_status<?php echo $transaction['transaction_order_id']?>"><?php echo $transaction['status']?></span></td>
                    <td><i class="expand icon-plus"></i></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="transaction-details" style="width: 135%; margin :0 auto;">
                            <ul id="details">
                                <li>
                                    <label class="control-lable"><strong><?php echo $details_invoice_no?></strong></label> <?php echo $transaction['invoice_no']?>
                                </li>
                                <li>
                                    <label class="control-lable"><strong><?php echo $details_amount?></strong></label> <?php echo $transaction['total']?>
                                </li>
                                <li>
                                    <label class="control-lable"><strong><?php echo $details_conversation?></strong></label> <?php echo $transaction['total']?> => <?php echo $transaction['converted']?>
                                </li>
                                <li>
                                    <label class="control-lable"><strong><?php echo $details_rate?></strong></label> <?php echo $transaction['convertion_rate']?>
                                </li>
                                <li>
                                    <label class="control-lable"><strong><?php echo $details_description?></strong></label> <?php echo $transaction['description']?>
                                </li>
                                <li>
                                    <label class="control-lable"><strong><?php echo $details_status?></strong></label> <span class="transaction_status<?php echo $transaction['transaction_order_id']?>"><?php echo $transaction['status']?></span>
                                </li><br/>
                                <?php if ($this->config->get('config_complete_status_id') == $transaction['transaction_status']) { ?>
                                <li class="transaction_action<?php echo $transaction['transaction_order_id']?>">
                                    <label class="control-lable"><strong><?php echo $details_action?></strong></label> <button type="button" class="btn" onclick="refund('<?php echo $transaction['transaction_order_id']?>','<?php echo $this->config->get('config_transaction_refund')?>')"><i class="icon-undo"></i> <?php echo $button_refund?></button>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
                <?php } else { ?>
                <tfoot>
                <tr>
                    <td colspan="6"><?php echo $text_no_result?>.</td>
                </tr>
                </tfoot>
                <?php }?>
            </table>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>
<!-- /main content-->
<!-- Side content -->
<div id="sidebar">
    <div class="box open">
        <div class="box-title">
            <div>
                <i class="icon-search2"></i> <?php echo $text_search?>
            </div>
        </div>
        <div class="box-content tabular-view">
                <h2><?php echo $text_date_range?></h2>
                <p>
                    <select name="date_interval" style="width: 235px">
                        <option value="30"><?php echo $interval_m_30?></option>
                        <option value="60"><?php echo $interval_m_60?></option>
                        <option value="90"><?php echo $interval_m_90?></option>
                        <option value="180"><?php echo $interval_m_180?></option>
                    </select>
                    <input type="text" name="filter_date_start" value="<?php echo $filter_date_start?>" placeholder="Date from" class="date" style="width: 100px">
                    <input type="text" name="filter_date_end" value="<?php echo $filter_date_end?>" placeholder="Date to" class="date" style="width: 100px">
                </p>
                <p><a onclick="filter();" class="btn" type="button"><i class="icon-search2"></i> <?php echo $button_search?></a></p>
                <p><a href="<?php echo $export?>"> <?php echo $text_export_csv?></a></p>
        </div>
    </div>
</div>
<!-- /side content-->
<script type="text/javascript"><!--
function filter() {
    url = 'index.php?route=account/transaction&token=<?php echo $token; ?>';

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

    location = url;
}

    $('select[name=\'date_interval\']').bind('change',function(){
        var dateEnd = $('input[name=\'filter_date_end\']').val();
        
        var interval = DateRemove(new Date(dateEnd),'d',this.value)
        
        $('input[name=\'filter_date_start\']').val(interval.toISOString().substring(0, 10));
        
    });
    
    $('select[name=\'date_interval\']').find('option[value="<?php echo $date_interval?>"]').attr("selected",true);
//--></script>
<script><!-- 
    <?php if ($transactions) { ?>
        $("#all-transactions").jExpand();
    <?php }?>
    //--></script>
<?php echo $footer?>