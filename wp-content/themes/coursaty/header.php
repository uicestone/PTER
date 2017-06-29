<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<title><?php bloginfo('sitename'); ?></title>
	<meta name="description" content="">
	<meta name="author" content="Uice Lu">
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<?php wp_head(); ?>

	<!-- FAV & Touch Icons -->
	<link rel="shortcut icon" href="assets/img/icons/favicon.ico">
	<link rel="apple-touch-icon" href="assets/img/icons/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/img/icons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/img/icons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="144x144" href="assets/img/icons/apple-touch-icon-144x144.png">
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="assets/js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
</head>
<body id="home">
<div id="entire">
	<div class="loader"></div>
    <?php if(!is_404()): ?>
	<header id="header">
		<div class="container">
			<div class="logo-container fl clearfix">
				<a href="#" class="ib">
					<img src="<?=get_stylesheet_directory_uri()?>/assets/img/logo@2x.png" class="fl" alt="Logo">
					<span class="site-name">PTE Revolution<span>.</span></span>
				</a>
			</div><!-- End Logo Container -->
            <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => 'nav', 'container_class' => 'main-navigation fr', 'menu_class' => 'clearfix', 'walker' => new Cousaty_Walker_Nav_Menu())); ?>
			<div class="mobile-navigation fr">
				<a href="#" class="mobile-btn"><span></span></a>
				<div class="mobile-container"></div>
			</div><!-- end mobile navigation -->
		</div>
	</header><!-- End Main Header Container -->
    <?php endif; ?>
