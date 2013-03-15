<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?php echo $this->config->item('language'); ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $this->config->item('language'); ?>"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo asset_url('css/quicksand.css'); ?>">
	<link rel="stylesheet" href="<?php echo asset_url('css/general_foundicons.css'); ?>">
	<link rel="stylesheet" href="<?php echo asset_url('css/app.css'); ?>">
	<link rel="stylesheet" href="<?php echo asset_url('js/tablesorter/addons/pager/jquery.tablesorter.pager.css'); ?>">
	
	<?php if (isset($stylesheets)): ?>
		<?php foreach($stylesheets as $stylesheet): ?>
			<link rel="stylesheet" href="<?php echo asset_url('css/'.$stylesheet.'.css'); ?>">
		<?php endforeach; ?>
	<?php endif; ?>
	<script src="<?php echo asset_url('js/foundation/modernizr.foundation.js'); ?>"></script>
	<!--[if lt IE 8]>
		<link rel="stylesheet" href="<?php echo asset_url('css/general_foundicons_ie7.css'); ?>">
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
