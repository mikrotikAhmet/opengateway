<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">


<script type="text/javascript" src="opengateway/view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="opengateway/view/javascript/bootstrap/js/bootstrap.min.js"></script>
<!--
<link href="opengateway/view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen" />
//-->


<link href="opengateway/view/javascript/bootstrap/less/bootstrap.less" rel="stylesheet/less" />
<script src="opengateway/view/javascript/bootstrap/less-1.7.4.min.js"></script>

<link href="opengateway/view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="opengateway/view/javascript/summernote/summernote.css" rel="stylesheet">
<script type="text/javascript" src="opengateway/view/javascript/summernote/summernote.js"></script>
<script src="opengateway/view/javascript/jquery/datetimepicker/moment.min.js" type="text/javascript"></script>
<script src="opengateway/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="opengateway/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

<link type="text/css" href="opengateway/view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<link type="text/css" href="opengateway/view/stylesheet/app.css" rel="stylesheet" media="screen" />


<?php foreach ($styles as $style) { ?>
<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="opengateway/view/javascript/jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="opengateway/view/javascript/app.js" type="text/javascript"></script>
<script src="opengateway/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
</head>
<body>
<div id="loading-overlay"></div>
<div id="loading"><span>Loading...</span></div>
<div id="container">
<header id="header" class="navbar navbar-static-top">
  <div class="navbar-header">
    <?php if ($logged) { ?>
    <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
    <?php } ?>
    <a href="<?php echo $home; ?>" class="navbar-brand"><img src="opengateway/view/image/logo.png" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></a></div>
  <?php if ($logged) { ?>
  <ul class="nav pull-right">

    <li><a href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span> <i class="fa fa-sign-out fa-lg"></i></a></li>
  </ul>
  <?php } ?>
</header>
