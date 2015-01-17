<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="view/javascript/jquery.cookie.js" type="text/javascript"></script>
<link href="view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="view/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

    <script src="view/javascript/jquery/jquery.dataTables.js" type="text/javascript"></script>
    <script src="view/javascript/common.js" type="text/javascript"></script>
    <script src="view/javascript/app.js" type="text/javascript"></script>

<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<?php if ($logged) { ?>
<nav id="top">
    <div class="container">
        <div class="pull-left">
            <img src="view/image/semitePAYMENT.png" style="width: 150px"/>
        </div>
        <div id="top-links" class="nav pull-right">
            <ul class="list-inline">
                <li><a href="<?php echo $home?>" id="dashboard" title=""><span class="hidden-xs hidden-sm hidden-md"><i class="fa fa-dashboard"></i> <?php echo $text_dashboard; ?></span></a></li>
                <li><a href="#" title=""><span class="hidden-xs hidden-sm hidden-md"><i class="fa fa-archive"></i> <?php echo $text_documentation; ?></span></a></li>
                <li><a href="#" title=""><span class="hidden-xs hidden-sm hidden-md"><i class="fa fa-support"></i> <?php echo $text_help; ?></span></a></li>
                <li class="dropdown"><a href="javascript:void()" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <?php if ($logged) { ?>
                        <li><a href="#"><i class="fa fa-cog"></i> <?php echo $text_setting; ?></a></li>
                        <li class="divider"></li>
                        <li> <a href="<?php echo $logout; ?>"><i class="fa fa-sign-out"></i> <?php echo $text_logout; ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php } ?>
<header>
  <div class="container">
    <div class="row">

    </div>
  </div>
</header>
<?php if ($logged) { ?>
<div class="container">
    <nav id="menu" class="navbar">
        <div class="navbar-header"><span id="category" class="visible-xs">Categories</span>
            <button type="button" class="btn btn-navbar navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
        </div>
        <div class="navbar-collapse navbar-ex1-collapse collapse" style="height: 1px;">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo $home?>"><?php echo $text_overview?></a></li>
                <li><a href="<?php echo $transaction?>"><?php echo $text_transaction?></a></li>
                <li class="dropdown"><a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown">Operations</a>
                    <div class="dropdown-menu">
                        <div class="dropdown-inner">
                            <ul class="list-unstyled">
                                <li><a href="<?php echo $charge?>"><?php echo $text_charge?></a></li>
                                <li class="divider"><?php echo $text_all_transaction?></li>
                                <li><a href="<?php echo $customer?>"><?php echo $text_customer?></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="#"><?php echo $text_card_bank?></a></li>
                <li><a href="#"><?php echo $text_card?></a></li>
            </ul>
        </div>
    </nav>
</div>
<?php }?>
