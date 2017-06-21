<?php

add_action('wp', function() {
	$coming_soon_page = get_posts(array('name' => 'coming-soon', 'post_type' => 'page'));
	if($coming_soon_page && !is_page('coming-soon') && !is_admin() && !current_user_can('administrator')) {
		header('Location: ' . site_url() . '/coming-soon/'); exit;
	}
});

// change to after_switch_theme in production
add_action('init', function () {

	register_nav_menu('primary', '主导航');

	register_taxonomy('question_model', null, array(
		'label' => '题型',
		'labels' => array(
			'all_items' => '所有题型',
			'add_new' => '添加题型',
			'add_new_item' => '新题型',
		),
		'public' => true,
		'show_admin_column' => true,
		'hierarchical' => true
	));

	register_post_type('question_model', array(
		'label' => '题型',
		'labels' => array(
			'all_items' => '所有题型',
			'add_new' => '添加题型',
			'add_new_item' => '新题型',
			'not_found' => '未找到题型'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
		'taxonomies' => array('question_model', 'post_tag'),
		'menu_icon' => 'dashicons-feedback',
		'has_archive' => true
	));

	register_post_type('tip', array(
		'label' => '技巧',
		'labels' => array(
			'all_items' => '所有技巧',
			'add_new' => '添加技巧',
			'add_new_item' => '新技巧',
			'not_found' => '未找到技巧'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
		'taxonomies' => array('question_model', 'post_tag'),
		'menu_icon' => 'dashicons-clipboard',
		'has_archive' => true
	));

	register_post_type('exercise', array(
		'label' => '练习',
		'labels' => array(
			'all_items' => '所有练习',
			'add_new' => '添加练习',
			'add_new_item' => '新练习',
			'not_found' => '未找到练习'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'custom-fields', 'comments', 'thumbnail'),
		'taxonomies' => array('question_model', 'post_tag'),
		'menu_icon' => 'dashicons-editor-spellcheck',
		'has_archive' => true
	));

	register_post_type('order', array(
		'label' => '订单',
		'labels' => array(
			'all_items' => '所有订单',
			'add_new' => '手动添加订单',
			'add_new_item' => '新订单',
			'not_found' => '未找到订单'
		),
		'show_ui' => true,
		'show_in_menu' => true,
		'supports' => array('title', 'excerpt', 'custom-fields', 'comments'),
		'taxonomies' => array('post_tag'),
		'menu_icon' => 'dashicons-cart',
	));
});
