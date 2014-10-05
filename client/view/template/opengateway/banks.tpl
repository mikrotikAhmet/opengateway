<?php if ($bank) { ?>
<table style="width: 500px">
    <tr>
    <td>Account holder</td>
    <td><?php echo $bank['account_holder']?></td>
</tr>
<tr>
    <td>Bank</td>
    <td><?php echo $bank['bank']?></td>
</tr>
<tr>
    <td>City/Town</td>
    <td><?php echo $bank['zone']?></td>
</tr>
<tr>
    <td>Country</td>
    <td><?php echo $bank['country']?></td>
</tr>
<tr>
    <td>Account numbet</td>
    <td><?php echo $bank['account_number']?></td>
</tr>
<tr>
    <td>SWIFT</td>
    <td><?php echo $bank['swift']?></td>
</tr>
<tr>
    <td>IBAN</td>
    <td><?php echo $bank['iban']?></td>
</tr>
<?php if (!empty($bank['sort_code'])) { ?>
<tr>
    <td>Sort code</td>
    <td><?php echo $bank['sort_code']?></td>
</tr>
<?php } ?>
<tr>
    <td>Currency</td>
    <td><?php echo $bank['currency']?></td>
</tr>
<tr>
    <td><strong>Reference</strong></td>
    <td><strong>42548493 (= Your Customer ID)</strong></td>
</tr>
</table>
<?php } ?>