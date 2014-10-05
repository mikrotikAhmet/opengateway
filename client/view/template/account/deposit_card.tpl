<?php echo $header?>
<div id="contentpanel-full">
    <div class="box open">
        <div class="box-title">
            <div>
                Upload step 2: select your card and transfer the money
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="upload-money" class="form-horizontal form-bordered" role="form">
            <div class="box-content tabular-view">
                <div class="left">
                <div class="cards">
                    <?php if ($cards) { ?>
                    <?php foreach ($cards as $card) { ?>
                    <div class="panel">
                        <input type="radio" name="card"  id="card" value="<?php echo $card['customer_card_id']?>"> <?php echo strtoupper($card['cardholder'])?> - <?php echo strtoupper($card['card_number'])?><br/><img src="<?php echo $card['image']?>">
                    </div>
                    <?php } ?>
                    <?php } ?>
                </div>
                <div class="panel">
                    <a  href="javascript::void()" id="addcard"  class="btn">Add a Card <i class="icon-credit"></i></a>
                </div> 
                    </div>
                <div class="right" style="width: 70%">
                <div class="panel">
                    <h2>Deposit Amount</h2>
                    <p>
                            <input type="text">
                            <cite class="hint">All deposits will be processed based of your account currency.</cite>
                    </p>
                </div>
                    <div class="panel">
                    <a  href="<?php echo $back?>" class="btn"><i class="icon-arrow-left5"></i> Back</a>
                    <a  href="javascript::void()" id="continue"  class="btn">Continue <i class="icon-arrow-right5"></i></a>
                </div> 
                    </div>
                  

            </div>
        </form>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'currency_code\']').trigger('change');
    //--></script> 
<?php echo $footer?>