<?php if ($bank) { ?>
<table class="table table-condensed table-hover">
    <tr>
    <td><strong><?php echo $text_account_holder?></strong></td>
    <td><?php echo $bank['account_holder']?></td>
</tr>
<tr>
    <td><strong><?php echo $text_bank?></strong></td>
    <td><?php echo $bank['bank']?></td>
</tr>
<tr>
    <td><strong><?php echo $text_zone?></strong></td>
    <td><?php echo $bank['zone']?></td>
</tr>
<tr>
    <td><strong><?php echo $text_country?></strong></td>
    <td><?php echo $bank['country']?></td>
</tr>
<tr>
    <td><strong><?php echo $text_account_number?></strong></td>
    <td><?php echo $bank['account_number']?></td>
</tr>
<tr>
    <td><strong><?php echo $text_swift?></strong></td>
    <td><?php echo $bank['swift']?></td>
</tr>
<tr>
    <td><strong><?php echo $text_iban?></strong></td>
    <td><?php echo $bank['iban']?></td>
</tr>
<?php if (!empty($bank['sort_code'])) { ?>
<tr>
    <td><strong><?php echo $text_sort_code?></strong></td>
    <td><?php echo $bank['sort_code']?></td>
</tr>
<?php } ?>
<tr>
    <td><strong><?php echo $text_currency?></strong></td>
    <td><?php echo $bank['currency']?></td>
</tr>
<tr>
    <td><strong><?php echo $text_reference?></strong></td>
    <td><strong><?php echo $bank['reference']?></strong></td>
</tr>
</table>
<?php } ?>