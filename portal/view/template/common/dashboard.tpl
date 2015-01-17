<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div id="transaction"></div>
        <div id="control"></div>
    </div>
</div>
<script type="text/javascript"><!--
    $('#control').load('index.php?route=common/dashboard/control&token=<?php echo $token; ?>');
    //--></script>
<script type="text/javascript"><!--
    $('#transaction').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#transaction').load(this.href);
    });

    $('#transaction').load('index.php?route=report/transaction/lastTransactions&token=<?php echo $token; ?>');

    //--></script>
<?php echo $footer; ?>