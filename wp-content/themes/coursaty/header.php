<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="zh-cmn-Hans" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="zh-cmn-Hans" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="zh-cmn-Hans" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="zh-cmn-Hans" class="no-js"> <!--<![endif]-->
<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<title><?php wp_title('-', true, 'right'); bloginfo('name'); echo ' - '; bloginfo('description') ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="Bingo Training Pty Ltd, Uice Lu">
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<?php wp_head(); ?>

	<!-- FAV & Touch Icons -->
	<link rel="shortcut icon" href="<?=get_stylesheet_directory_uri()?>/assets/img/icons/favicon.ico?v=1">
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="assets/js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->

	<script>
        // default path is on the same directory as this HTML
        var Mp3LameEncoderConfig = {
            memoryInitializerPrefixURL: "<?=get_stylesheet_directory_uri()?>/assets/js/vendor/mp3-lame-encoder/"
        };
	</script>

    <style type="text/css">
        <?php if (is_user_logged_in()): ?>
        .main-navigation .login, .mobile-navigation .login {
            display: none;
        }
        <?php endif; ?>
    </style>
</head>
<body id="home" class="<?php body_class(); ?>">
<div id="entire">
    <?php if (is_home()): ?>
	<div class="loader"></div>
    <?php endif; ?>
    <?php if(!is_404()): ?>
	<header id="header" class="<?=is_home() ? '' : 'alt static-header'?>">
		<div class="container">
			<div class="logo-container fl clearfix">
				<a href="<?=site_url()?>" class="ib">
					<img src="<?=get_stylesheet_directory_uri()?>/assets/img/<?=is_home() ? 'logo-white' : 'logo'?>.png" class="fl" alt="Logo">
				</a>
			</div><!-- End Logo Container -->
            <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => 'nav', 'container_class' => 'main-navigation fr', 'menu_class' => 'clearfix')); ?>
			<div class="mobile-navigation fr">
				<a href="#" class="mobile-btn"><span></span></a>
				<div class="mobile-container"></div>
			</div><!-- end mobile navigation -->
		</div>
	</header><!-- End Main Header Container -->
    <?php endif; ?>
