<?php

add_action('after_setup_theme', function () {
	register_nav_menu('primary', '主导航');
	add_theme_support('post-thumbnails');
	add_image_size('headline', 1600, 700, true);
	add_image_size('mentor', 270, 270, true);
	add_image_size('post-thumbnail', 1280, 720, true);
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
function custom_nav_menu_item( $title, $url, $order, $parent = 0, $classes = array() ){
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
	$item->classes = $classes;
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
				$top = custom_nav_menu_item( '我的账户', get_author_posts_url( get_current_user_id() ), 100, 0, ['account'] );
				$items[] = $top;
				$items[] = custom_nav_menu_item( wp_get_current_user()->display_name, null, 101, $top->ID );
				$items[] = custom_nav_menu_item( '个人中心', site_url() . '/profile/', 103, $top->ID, ['profile'] );
				$items[] = custom_nav_menu_item( '退出登录', site_url() . '/login/?logout=true', 102, $top->ID );
			}
		}

		return $items;
	}

	return $items;
}, 10, 2);

show_admin_bar( false );

add_filter( 'status_header', function ($header) {
	global $wp_query;

	if (is_404()) {
		unset( $wp_query->query_vars['name'] );
	}
} );
