<?php echo $header?>
<div id="contentpanel-full">
    <div class="box open">
        <div class="box-title">
            <div>
                Upload step 2: select currency and transfer the money
            </div>
        </div>
        <div class="box open">
            <div class="box-content">
                <p><b>Important Notice :</b> <br/>Bank transfers must be made by Ahmet Gudenoglu or Global Business Marketing and cash deposits cannot be accepted. Due to money laundering regulations we take this very seriously and will have to charge you all banking and administrative costs to return third party or cash deposits.</p>
            </div>
        </div>
        <form action="<?php echo $card?>" method="post" enctype="multipart/form-data" id="upload-method" class="form-horizontal form-bordered" role="form">
            <div class="box-content tabular-view">
                <label>1. Select the currency for the bank transfer</label>
                <p>
                    <select name="currency_code">
                        <option value="">--Please select--</option>
                        <?php foreach ($currencies as $currency) { ?>
                        <option value="<?php echo $currency['currency_id']?>"><?php echo $currency['code']?></option>
                        <?php } ?>
                    </select>
                </p>
                <label>2. Transfer the money to the bank account below</label>
                <div id="banks"></div>
                <div class="panel">
                    <a  href="<?php echo $back?>" class="btn"><i class="icon-arrow-left5"></i> Back</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'currency_code\']').trigger('change');
    //--></script> 
<?php echo $footer?>