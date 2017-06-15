<?php

add_action('wp', function() {
	$coming_soon_page = get_posts(array('name'=>'coming-soon', 'post_type'=>'page'));
	if($coming_soon_page && !is_page('coming-soon') && !is_admin() && !current_user_can('administrator')) {
		header('Location: ' . site_url() . '/coming-soon/'); exit;
	}
});
