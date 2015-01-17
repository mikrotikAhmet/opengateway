<?php if (isset($bank['bank']) && $bank['bank']) { ?>
<table class="table payment-option" data-currency="EUR">
    <tbody>
    <tr>
        <td><?php echo $text_account_holder?></td>
        <td><?php echo $name?></td>
    </tr>
    <tr>
        <td><?php echo $text_account_bank?></td>
        <td><?php echo $bank['bank']?></td>
    </tr>
    <tr>
        <td><?php echo $text_account_city?></td>
        <td><?php echo $bank['city']?></td>
    </tr>
    <tr>
        <td><?php echo $text_account_country?></td>
        <td><?php echo $bank['country']?></td>
    </tr>
    <tr>
        <td><?php echo $text_account_number?></td>
        <td><?php echo $bank['account_number']?></td>
    </tr>
    <tr>
        <td><?php echo $text_account_swift?></td>
        <td><?php echo $bank['swift']?></td>
    </tr>
    <tr>
        <td><?php echo $text_account_iban?></td>
        <td><?php echo $bank['iban']?></td>
    </tr>
    <?php if ($bank['sort_code']) { ?>
    <tr>
        <td><?php echo $text_account_sort_code?></td>
        <td><?php echo $bank['sort_code']?></td>
    </tr>
    <?php } ?>
    <tr>
        <td><?php echo $text_account_currency?></td>
        <td><?php echo $bank['code']?></td>
    </tr>
    <tr class="bold">
        <td><b><?php echo $text_account_reference?></b></td>
        <td><b><?php echo $text_reference?></b></td>
    </tr>
    </tbody>
</table>
<?php } else { ?>
<p><?php echo $text_no_bank_information?></p>
<?php } ?>