<?php echo $header?>
<form action="<?php echo $action?>" method="post">
    <div id="login">
        <h2><?php echo $text_login; ?></h2>
        <label for="username"><?php echo $entry_username?></label>
        <input type="text" id="username" name="username"/>
        <label for="password"><?php echo $entry_password?></label>
        <input type="password" id="password" name="password"/>
        <label>
            <?php if ($forgotten) { ?>
            <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
            <?php } ?>
        </label>
        <?php if ($error_warning) { ?>
        <div class="msg-error">
            <?php echo $error_warning; ?>
        </div>
        <?php } ?>
        <input type="submit" value="<?php echo $button_login?>" />
        <?php if ($redirect) { ?>
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        <?php } ?>
        <div class="clear"></div>
    </div>
</form>
<script>

    
</script>
<?php echo $footer?>