<!DOCTYPE html>
<html lang="zh" class="no-js">
<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<title><?php wp_title('-', true, 'right'); bloginfo('name'); echo ' - '; bloginfo('description') ?></title>
	<meta name="keywords" content="<?=__('PTE练习')?> PTE技巧 PTE考试 PTE模考">
	<meta name="description" content="<?php is_single() ? print(get_the_excerpt()) : bloginfo('description'); ?>">
	<meta name="author" content="Bingo Training Pty Ltd, Uice Lu">
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<?php wp_head(); ?>

	<!-- FAV & Touch Icons -->
	<link rel="shortcut icon" href="<?=get_stylesheet_directory_uri()?>/assets/img/icons/favicon.ico?v=1">

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
	<?php if (is_single()): ?>
	<script type="application/ld+json">
	{
		"@context": "http://schema.org"
		, "@type": "NewsArticle"
		, "mainEntityOfPage": <?=json_encode(get_the_permalink())?>
		, "headline": "<?php the_title(); ?>"
		, "author": "<?php the_author(); ?>"
		, "datePublished": "<?php the_date('Y-m-d'); ?>"
		, "publisher": {"@type":"Organization", "name":"Bingo Training Pty. Ltd.", "logo": {"@type": "ImageObject", "url": <?=json_encode(site_url('wp-content/themes/coursaty/assets/img/logo.png'))?>}, "url": "<?=site_url()?>"}
		, "dateModified": "<?php the_modified_date('Y-m-d'); ?>"
		, "image": <?=json_encode(get_images_from_the_post())?>
		<?php global $post_require_payment; if ($post_require_payment): ?>
		, "isAccessibleForFree": "False"
		, "hasPart": {
			"@type": "WebPageElement",
			"isAccessibleForFree": "False",
			"cssSelector" : ".entry"
		}
		<?php endif; ?>
	}
	</script>
	<?php endif; ?>
</head>
<body id="home" <?php body_class(); ?>>
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
