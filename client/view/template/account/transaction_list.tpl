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
                <i class="icon-search2"></i> <?php echo $text_search?>
            </div>
        </div>
        <div class="box-content tabular-view">
        </div>
    </div>
</div>
<!-- /side content-->
<script><!-- 
    $("#all-transactions").jExpand();
    //--></script>
<?php echo $footer?>