<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <base href="<?php echo $base; ?>" />
        <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>" />
        <?php } ?>
        <?php if ($keywords) { ?>
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <?php } ?>
        <?php foreach ($links as $link) { ?>
        <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
        <?php } ?>
        <meta name="author" content="Ahmet GOUDENOGLU">

        <link href="view/css/style.css" rel="stylesheet" type="text/css">
        <link href="view/css/color.css" rel="stylesheet" type="text/css">
        <link href="view/css/icons.css" rel="stylesheet" type="text/css">
        <link href="view/fonts/csscc26.css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <?php foreach ($styles as $style) { ?>
        <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
        <?php } ?>
        <script type="text/javascript" src="view/js/jquery.js"></script>
        <script type="text/javascript" src="view/js/modal.js"></script>
        <?php if (isset($this->session->data['token'])) { ?>
        <script>
            var token = '<?php echo $this->session->data['token']?>';
        </script>
        <?php } ?>
        <script type="text/javascript" src="view/js/common.js"></script>
        <?php foreach ($scripts as $script) { ?>
        <script type="text/javascript" src="<?php echo $script; ?>"></script>
        <?php } ?>

    </head>
    <body>
        <div id="spinner">
            <div class="loading">
                <i class="icon-spinner7 spin panel-icon"></i>
                <p>Please wait.</p>
            </div>
        </div>
        <div id="header">
            <h1 id="logo"><a href="<?php echo $home?>" title="Semite :: Merchat Panel"><img src="view/images/logo.gif" title="Semite :: Merchat Panel" alt="Semite :: Merchat Panel" /></a></h1>
        </div>
        <?php if($logged) { ?>
        <div id="menubar" class="wrapper box-title"><div>
                <ul id="mainnav">
                    <li id="dashboard"><a href="<?php echo $home?>" title=""><?php echo $text_dashboard?></a></li>
                    <li id="transaction"><a href="<?php echo $transaction?>" title=""><?php echo $text_transaction?></a></li>
                    <li id="account"><a href="<?php echo $account?>" title=""><?php echo $text_account?></a></li>
                    <li id="semite"><a href="<?php echo $semite?>" title=""><?php echo $text_semite?></a></li>
                    <li id="setting"><a href="<?php echo $setting?>" title=""><?php echo $text_setting?></a></li>
                </ul>
                <div id="loginbar">
                    <?php echo $logged?>, <a href="<?php echo $logout?>" title="Logout"><?php echo $text_logout?></a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php } ?>
