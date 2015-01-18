<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div class="col-md-3" style="display: none">
            <div class="panel panel-info">
                <div class="panel-heading">Customer Filter</div>
                <div class="panel-body">
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <nav id="top">
                <div class="pull-right">
                    <a href="<?php echo $add?>" class="btn"><i class="expand fa fa-plus" ></i> Add new</a>
                    <!--a href="#" class="btn btn-danger"><i class="expand fa fa-trash-o" ></i> Remove</a-->
                </div>
            </nav>
            <div class="table-responsive">
                <table class="table table-bordered table-hover customer" id="customers">
                    <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                        <th class="text-left"><?php echo $column_date_added?></th>
                        <th class="text-left"><?php echo $column_name?></th>
                        <th class="text-left"><?php echo $column_email?></th>
                        <th class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($customers) { ?>
                    <?php foreach ($customers as $customer) { ?>
                    <tr class="" id="<?php echo $customer['customer_id']?>">
                        <td class="text-center"><?php if (in_array($customer['customer_id'], $selected)) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" />
                            <?php } ?></td>
                        <td class="text-left"><?php echo $customer['date_added']; ?></td>
                        <td class="text-left"><?php echo $customer['name']; ?></td>
                        <td class="text-left"><?php echo $customer['email']; ?></td>
                        <td class="text-center"><a href="<?php echo $customer['edit']?>"><i class="expand fa fa-eye" style="cursor: pointer"></i></a></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="7"><?php echo $text_no_customer; ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>