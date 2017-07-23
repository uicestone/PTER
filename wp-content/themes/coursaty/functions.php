<?php

add_action('wp', function() {

	$coming_soon_page = get_posts(array('name' => 'coming-soon', 'post_type' => 'page'));

//	if($coming_soon_page && !is_page('coming-soon') && !is_page('login') && !is_admin() && !is_user_logged_in()) {
//		header('Location: ' . site_url() . '/coming-soon/'); exit;
//	}

	wp_register_style('style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.18');
	wp_register_style('responsive', get_stylesheet_directory_uri() . '/assets/css/responsive.css', array(), '1.0.0');

	wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/vendor/jquery-1.11.2.min.js', array(), '1.11.2', true);
	wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/assets/js/bsmodal.min.js', array('jquery'), '3.3.4', true);
	wp_register_script('easydropdown', get_stylesheet_directory_uri() . '/assets/js/jquery.easydropdown.min.js', array('jquery'), '2.1.4', true);
	wp_register_script('flexslider', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), '2.2.2', true);
	wp_register_script('isotope', get_stylesheet_directory_uri() . '/assets/js/jquery.isotope.min.js', array('jquery'), '1.5.26', true);
	wp_register_script('revolution', get_stylesheet_directory_uri() . '/assets/js/jquery.themepunch.revolution.min.js', array('jquery'), '4.6.4', true);
	wp_register_script('tools', get_stylesheet_directory_uri() . '/assets/js/jquery.themepunch.tools.min.js', array('jquery'), '1.0.0', true);
	wp_register_script('viewportchecker', get_stylesheet_directory_uri() . '/assets/js/jquery.viewportchecker.min.js', array('jquery'), '1.8.0', true);
	wp_register_script('waypoints', get_stylesheet_directory_uri() . '/assets/js/jquery.waypoints.min.js', array('jquery'), '3.0.0', true);
	wp_register_script('sticky', get_stylesheet_directory_uri() . '/assets/js/jquery.sticky.min.js', array('jquery'), '1.0.4', true);
	wp_register_script('scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.2', true);

});

add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('style');
	wp_enqueue_style('responsive');

	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap');
	wp_enqueue_script('easydropdown');
	wp_enqueue_script('flexslider');
	wp_enqueue_script('isotope');
	wp_enqueue_script('revolution');
	wp_enqueue_script('tools');
	wp_enqueue_script('viewportchecker');
	wp_enqueue_script('waypoints');
	wp_enqueue_script('sticky');
	wp_enqueue_script('scripts');
});

add_action('after_switch_theme', function () {
	$administrator = get_role('administrator');
	$administrator->add_cap('view_tips');
	$administrator->add_cap('view_exercises');

	// TODO create scheduled event to remove cap for expired users
});

add_action('after_setup_theme', function () {
	register_nav_menu('primary', '主导航');
	add_theme_support('post-thumbnails');
	add_image_size('headline', 1600, 700, true);
	add_image_size('mentor', 270, 270, true);
	add_image_size('post-thumbnail', 1280, 720, true);
});

add_action('init', function () {

	register_taxonomy('question_type', null, array(
		'label' => '题型分类',
		'labels' => array(
			'all_items' => '所有题型',
			'add_new' => '添加题型',
			'add_new_item' => '新题型',
		),
		'public' => true,
		'show_admin_column' => true,
		'hierarchical' => true
	));

	register_post_type('question_type_desc', array(
		'label' => '题型',
		'labels' => array(
			'all_items' => '所有题型',
			'add_new' => '添加题型',
			'add_new_item' => '新题型',
			'not_found' => '未找到题型'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'revisions', 'thumbnail'),
		'taxonomies' => array('question_type', 'post_tag'),
		'menu_icon' => 'dashicons-feedback',
		'has_archive' => true
	));

	add_post_type_support('question_type_desc', 'wps_subtitle');

	register_post_type('tip', array(
		'label' => '技巧',
		'labels' => array(
			'all_items' => '所有技巧',
			'add_new' => '添加技巧',
			'add_new_item' => '新技巧',
			'edit_item' => '编辑技巧',
			'not_found' => '未找到技巧'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'revisions', 'thumbnail'),
		'taxonomies' => array('question_type', 'post_tag'),
		'menu_icon' => 'dashicons-clipboard',
		'has_archive' => true
	));

	add_post_type_support('tip', 'wps_subtitle');

	register_post_type('exercise', array(
		'label' => '练习',
		'labels' => array(
			'all_items' => '所有练习',
			'add_new' => '添加练习',
			'add_new_item' => '新练习',
			'edit_item' => '编辑练习',
			'not_found' => '未找到练习'
		),
		'public' => true,
		'supports' => array('title', 'editor', 'revisions', 'thumbnail'),
		'taxonomies' => array('question_type', 'post_tag'),
		'menu_icon' => 'dashicons-editor-spellcheck',
		'has_archive' => true
	));

	register_post_type('member_order', array(
		'label' => '订单',
		'labels' => array(
			'all_items' => '所有订单',
			'add_new' => '手动添加订单',
			'add_new_item' => '新订单',
			'edit_item' => '编辑订单',
			'not_found' => '未找到订单'
		),
		'show_ui' => true,
		'show_in_menu' => true,
		'supports' => array('title'),
		'taxonomies' => array('post_tag'),
		'menu_icon' => 'dashicons-cart',
	));

});

add_filter('nav_menu_link_attributes', function($attrs, $item) {

	$attrs['class'] = $attrs['class'] ?: [];

	$attrs['class'][] = 'ln-tr';

	$attrs['class'] = implode(' ', $attrs['class']);

	$attrs['role'] = 'button';

	return $attrs;

}, 10, 2);

add_filter('nav_menu_css_class', function($classes, $item) {

	if(in_array('menu-item-has-children', $classes)) {
		$classes[] = 'haschild';
	}

	if(array_intersect(['current-menu-item', 'current-page-ancestor', 'current-post-ancestor', 'current-question_type_desc-ancestor', 'current-exercise-ancestor'], $classes ?: [])) {
		$classes[] = 'current_page_item';
	}

	if($item->menu_item_parent) {
		$classes[] = 'sub-item';
	}
	elseif(in_array('menu-item-has-children', $classes)) {
		$classes[] = 'parent-item';
	}

	if($item->title === 'Login') {
		$classes[] = 'login';
	}

	return $classes;

}, 10, 2);

/**
 * Simple helper function for make menu item objects
 *
 * @param $title      - menu item title
 * @param $url        - menu item url
 * @param $order      - where the item should appear in the menu
 * @param int $parent - the item's parent item
 * @return \stdClass
 */
function custom_nav_menu_item( $title, $url, $order, $parent = 0 ){
	$item = new stdClass();
	$item->ID = 1000000 + $order + parent;
	$item->db_id = $item->ID;
	$item->title = $title;
	$item->url = $url;
	$item->menu_order = $order;
	$item->menu_item_parent = $parent;
	$item->type = '';
	$item->object = '';
	$item->object_id = '';
	$item->classes = array();
	$item->target = '';
	$item->attr_title = '';
	$item->description = '';
	$item->xfn = '';
	$item->status = '';
	return $item;
}

add_filter('wp_get_nav_menu_items', function ($items, $menu) {

	if ( $menu->slug == 'primary' ) {
		// only add item to a specific menu
		if ( $menu->slug == 'primary' ){

			// only add profile link if user is logged in
			if ( get_current_user_id() ){
				$top = custom_nav_menu_item( '我的账户', get_author_posts_url( get_current_user_id() ), 100 );
				$items[] = $top;
				$items[] = custom_nav_menu_item( wp_get_current_user()->display_name, null, 101, $top->ID );
				$items[] = custom_nav_menu_item( '个人中心', site_url() . '/profile/', 103, $top->ID );
				$items[] = custom_nav_menu_item( '退出登录', site_url() . '/login/?logout=true', 102, $top->ID );
			}
		}

		return $items;
	}

	return $items;
}, 10, 2);

show_admin_bar( false );

/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'add_extra_tablenav');
function add_extra_tablenav($post_type) {
	$taxonomy  = 'question_type'; // change to your taxonomy
	$post_types = array('question_type_desc', 'tip', 'exercise');
	if (in_array($post_type, $post_types)) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => "全部{$info_taxonomy->label}",
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'hide_empty'      => false,
			'hierarchical'	  => true,
			'value_field'     => 'slug'
		));
	};
}
/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'team'; // change to your post type
	$taxonomy  = 'group'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

function redirect_login ($force = false) {

	if (!$force && is_user_logged_in()) {
		return;
	}

	header('Location: ' . site_url() . '/register/?intend=' . ($_SERVER['REQUEST_URI'])); exit;
}

function redirect_pricing_table ($cap) {
	if (current_user_can($cap)) {
		return;
	}
	else {
		header('Location: ' . site_url() . '/pricing-table/?intend=' . ($_SERVER['REQUEST_URI'])); exit;
	}
}

function order_paid ($order_no) {
	// find the order
	$order = get_posts(array('name' => sanitize_title($order_no), 'post_type' => 'member_order', 'post_status' => 'private'))[0];

	// update order payment status
	update_post_meta($order->ID, 'status', 'paid');

	// TODO price-service needs to be verified

	// get the user and add cap
	$user = get_user_by('ID', $order->post_author);

	$service = get_post_meta($order->ID, 'service', true);

	if (in_array($service, array('听说基础包30天', '听说读写套餐30天'))) {
		$user->add_cap('view_tips');
		$user->add_cap('view_exercises');
	}

	if (in_array($service, array('听说读写套餐30天', '阅读拓展包'))) {
		add_user_meta($user->ID, 'service_valid_before_阅读拓展包', 'inactivated');
	}

	if (in_array($service, array('听说读写套餐30天', '写作拓展包'))) {
		add_user_meta($user->ID, 'service_valid_before_写作拓展包', 'inactivated');
	}

	if (in_array($service, array('听说基础包30天', '听说读写套餐30天'))) {
		update_user_meta($user->ID, 'service_valid_before_' . get_post_meta($order->ID, 'service', true), get_post_meta($order->ID, 'expires_at', true));
	}
}
