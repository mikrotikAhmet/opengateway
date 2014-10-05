<div class="clear"></div>
<!-- Modal Dialog Example -->  
<div id="modal" class="modal-container">
    <h2></h2>
    <h3>Card number</h3>
    <p>
        <input type="text">
    </p>
    <h3>Expiry date</h3>
    <p>
        <select name="year" style="width: auto">
            <?php 
            $i = $currentYear;
            while ($i <= ($currentYear+6)) // this gives you six years in the future
            {
            ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php 
            $i++;
            } 
            ?>
        </select>
        <select name="month" style="width: auto">
            <option value="01" <?php echo ($currentMonth == "01")?"selected":""; ?>><?php echo $month_january?></option>
            <option value="02" <?php echo ($currentMonth == "02")?"selected":""; ?>><?php echo $month_february?></option>
            <option value="03" <?php echo ($currentMonth == "03")?"selected":""; ?>><?php echo $month_march?></option>
            <option value="04" <?php echo ($currentMonth == "04")?"selected":""; ?>><?php echo $month_april?></option>
            <option value="05" <?php echo ($currentMonth == "05")?"selected":""; ?>><?php echo $month_may?></option>
            <option value="06" <?php echo ($currentMonth == "06")?"selected":""; ?>><?php echo $month_june?></option>
            <option value="07" <?php echo ($currentMonth == "07")?"selected":""; ?>><?php echo $month_july?></option>
            <option value="08" <?php echo ($currentMonth == "08")?"selected":""; ?>><?php echo $month_august?></option>
            <option value="09" <?php echo ($currentMonth == "09")?"selected":""; ?>><?php echo $month_september?></option>
            <option value="10" <?php echo ($currentMonth == "10")?"selected":""; ?>><?php echo $month_october?></option>
            <option value="11" <?php echo ($currentMonth == "11")?"selected":""; ?>><?php echo $month_november?></option>
            <option value="12" <?php echo ($currentMonth == "12")?"selected":""; ?>><?php echo $month_december?></option>
        </select>
    </p>
    <h3>CVV</h3>
    <p>
        <input type="text" style="width: 50px">
    </p>
    <div class="modal-content">

    </div>
    <button type="button" class="btn close" data-dismiss="modal" aria-hidden="true"><i class="icon-arrow-left5"></i> <?php echo $button_back?></button>
    <button type="button" class="btn close" data-dismiss="modal" aria-hidden="true"><?php echo $button_continue?> <i class="icon-arrow-right5"></i></button>
    <div class="clear"></div>
</div>
<div id="mask"></div>
<!-- End of Modal Dialog Example -->
<div id="footer" class="login-f"><?php echo $text_footer?></div>
</body>
</html>