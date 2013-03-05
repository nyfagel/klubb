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
	<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Raleway:400,200,700:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
</head>
<body>
