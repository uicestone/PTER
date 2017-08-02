<?php

add_action('wp', function() {

	$coming_soon_page = get_posts(array('name' => 'coming-soon', 'post_type' => 'page'));

//	if($coming_soon_page && !is_page('coming-soon') && !is_page('login') && !is_admin() && !is_user_logged_in()) {
//		header('Location: ' . site_url() . '/coming-soon/'); exit;
//	}

	wp_register_style('style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.19');
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

	add_post_type_support('post', 'page-attributes');

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
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes'),
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
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes'),
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
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes'),
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

	add_filter('manage_member_order_posts_columns', function($columns) {
		$new_columns = array(
			'cb' => $columns['cb'],
			'title' => $columns['title'],
			'date' => '下单时间',
			'status' => '状态',
			'user'=>'用户',
			'price'=>'金额',
			'gateway' => '通道'
		);
		return $new_columns;
	});

	add_action('manage_member_order_posts_custom_column', function($column_name) {
		global $post;
		switch ($column_name ) {
			case 'user' :
				$user = get_user_by('ID', $post->post_author);
				echo '<a href="' . site_url() . 'wp-admin/user-edit.php?user_id=' . $user->ID . '">' . $user->display_name . '</a>';
				break;
			case 'price' :
				$price = get_post_meta($post->ID, 'price', true);
				echo $price;
				break;
			case 'status' :
				$status = get_post_meta($post->ID, 'status', true);
				switch ($status) {
					case 'pending_payment': echo '待付款'; break;
					case 'paid': echo '已付款'; break;
					case 'cancelled': echo '已取消'; break;
					default;
				}
				break;
            case 'gateway':
				$gateway = get_post_meta($post->ID, 'gateway', true);
				echo $gateway;
                break;
			default;
		}
	});
	
	add_action('restrict_manage_posts', function() {
		
	    global $current_screen;
		
		if ($current_screen->post_type == 'member_order') {
			
			$available_statuses = array('pending_payment' => '待付款', 'paid' => '已付款', 'cancelled' => '已取消');
			
			echo '<select name="status">';
			echo '<option value="">所有状态</option>';
			
			foreach ($available_statuses as $status_name => $status_label) {
				$selected = (!empty($_GET['status']) && $_GET['status'] == $status_name ) ? ' selected="selected"' : '';
				echo '<option' . $selected . ' value="' . $status_name . '">' . $status_label . '</option>';
			}
			
			echo '</select>';
		}
	});

	add_filter('parse_query', function ($query) {
		if (is_admin() AND $query->query['post_type'] === 'member_order') {
			$qv = &$query->query_vars;
			$qv['meta_query'] = array();
			if (!empty($_GET['status'])) {
				$qv['meta_query'][] = array(
					'field' => 'status',
					'value' => $_GET['status']
				);
			}
			if (!empty($_GET['price'])) {
				$qv['meta_query'][] = array(
					'field' => 'price',
					'value' => $_GET['price']
				);
			}
		}
	});
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

function order_paid ($order_no, $gateway) {
	// find the order
	$order = get_posts(array('name' => sanitize_title($order_no), 'post_type' => 'member_order', 'post_status' => 'private'))[0];

	if (!$order) {
	    error_log('order_paid(): order not found. (order no: ' . $order_no . ')');
	    exit;
    }

	// update order payment status
	update_post_meta($order->ID, 'status', 'paid');
	add_post_meta($order->ID, 'refundable_amount', get_post_meta($order->ID, 'price', true));
	update_post_meta($order->ID, 'gateway', $gateway);

	// TODO price-service needs to be verified

	// get the user and add cap
	$user = get_user_by('ID', $order->post_author);

	if (!$user) {
	    error_log('order_paid(): order user not found. (order no: ' . $order_no . ')');
    }

	$service = get_post_meta($order->ID, 'service', true);

	if (in_array($service, array('tips', 'base', 'full'))) {
		$user->add_cap('view_tips');
	}

	if (in_array($service, array('exercises', 'base', 'full'))) {
		$user->add_cap('view_exercises');
	}

	if (in_array($service, array('full', 'reading'))) {
		add_user_meta($user->ID, 'service_reading_valid_before', 'inactivated');
	}

	if (in_array($service, array('full', 'writing'))) {
		add_user_meta($user->ID, 'service_writing_valid_before', 'inactivated');
	}

	if (in_array($service, array('base', 'full'))) {
	    // TODO calculate cap expire time base on current cap
		update_user_meta($user->ID, 'service_tips_valid_before', time() + 86400 * 30);
		update_user_meta($user->ID, 'service_exercises_valid_before', time() + 86400 * 30);
    }

	if (in_array($service, array('tips', 'exercises', 'base', 'full'))) {
		// TODO calculate cap expire time base on current cap
		update_user_meta($user->ID, 'service_' . $service . '_valid_before', time() + 86400 * 30);
	}

	// user total pay
	update_user_meta($user->ID, 'total_paid', (get_user_meta($user->ID, 'total_paid', true) ?: 0) + get_post_meta($order->ID, 'price', true));

	// invititation award and discount
	$inviter_id = get_user_meta($user->ID, 'invited_by_user', true);
	$service_awardable = in_array(get_post_meta($order->ID, 'service', true), array('base', 'full'));
	$discount_order = get_user_meta($user->ID, 'discount_order', true);

	if ($inviter_id && $service_awardable && !$discount_order) {

		add_user_meta($user->ID, 'discount_order', $order->ID);

		// award the inviter
		$award_amount_fixed = get_post_meta(get_page_by_path('pricing-table')->ID, 'intro_award', true);
		$awardable_amount = round(get_user_meta($inviter_id, 'total_paid', true) - get_user_meta($inviter_id, 'total_awarded', true), 2);

		$award_amount = min($award_amount_fixed, $awardable_amount);

		if  ($award_amount > 0) {
			// get oldest refundable orders
			$refundable_orders = get_posts(array(
				'post_type' => 'member_order',
				'post_status' => 'private',
				'author' => $inviter_id,
				'date_query' => array('after' => '-3 months'),
				'order' => 'asc',
				'posts_per_page' => '-1',
				'meta_key' => 'refundable_amount',
				'meta_compare' => '>',
				'meta_value' => '0')
			);

			foreach ($refundable_orders as $refundable_order) {
				$refund_amount = min(get_post_meta($refundable_order->ID, 'refundable_amount', true), $award_amount);
				refund_order($refundable_order->ID, $refund_amount);
				$award_amount -= $refund_amount;
				if ($award_amount <= 0) {
					break;
				}
			}
		}
	}

	return $order;
}

/**
 * @param $out_trade_no string order no in our system
 * @param $subject string order title
 * @param $total_fee number a price in basic unit
 * @param $currency string
 * @param $service string base, full, tips, exercises, reading or writing
 * @param $gateway string alipay, wechatpay or paypal
 */
function create_order ($out_trade_no, $subject, $total_fee, $currency, $service, $gateway) {
	$order_id = wp_insert_post(array(
		'post_type' => 'member_order',
		'post_author' => get_current_user_id(),
		'post_name' => $out_trade_no,
		'post_title' => $subject,
		'post_status' => 'private'
	));

	add_post_meta($order_id, 'price', $total_fee);
	add_post_meta($order_id, 'currency', $currency);
	add_post_meta($order_id, 'no', $out_trade_no);
	add_post_meta($order_id, 'user', get_current_user_id());
	add_post_meta($order_id, 'service', $service);
	add_post_meta($order_id, 'status', 'pending_payment');

	add_post_meta($order_id, 'gateway', $gateway);

}

/**
 * refund an order through it's gateway
 * @param $order_id
 */
function refund_order ($order_id, $amount) {

	$amount = round($amount, 2);
	$order_no = get_post_meta($order_id, 'no', true);

	if ($amount <= 0) {
		return;
	}

	switch (get_post_meta($order_id, 'gateway', true)) {
		case 'wechatpay':
			$input = new RoyalPayApplyRefund();
			$input->setOrderId($order_no);
			$input->setRefundId('refund.' . $order_no);
			$input->setFee($amount * 100);
			RoyalPayApi::refund($input);
			break;
		case 'paypal':
			$sale_id = get_post_meta($order_id, 'sale_id', true);
			paypal_sale_refund($sale_id, $amount);
			break;
		case 'alipay':
		default:
			(new AlipayRefund(get_alipay_config()))->refund($order_no, $amount);
	}

	update_post_meta($order_id, 'refundable_amount',
		round(get_post_meta($order_id, 'refundable_amount', true) - $amount, 2)
	);

	$user = get_post($order_id)->post_author;

	update_user_meta($user, 'total_awarded', get_user_meta($user, 'total_awarded', true) + $amount);
}

function pter_adjacent_post_where ($where) {

	global $post;

	if ($post->post_type === 'exercise' && $_GET['tag'] !== 'free-trial') {
		$where = str_replace('p.post_date', 'p.ID', $where);
		$where = preg_replace('/\'\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}\'/', $post->ID, $where);
		return $where;
	}

	return $where;
};

function pter_previous_post_sort ($orderby) {

	global $post;

	if ($post->post_type === 'exercise' && $_GET['tag'] !== 'free-trial') {
		return 'ORDER BY p.ID DESC LIMIT 1';
	}

	return $orderby;
}

function pter_next_post_sort ($orderby) {

	global $post;

	if ($post->post_type === 'exercise' && $_GET['tag'] !== 'free-trial') {
		return 'ORDER BY p.ID ASC LIMIT 1';
	}

	return $orderby;
}

add_filter('get_previous_post_where', 'pter_adjacent_post_where');
add_filter('get_next_post_where', 'pter_adjacent_post_where');
add_filter('get_previous_post_sort', 'pter_previous_post_sort');
add_filter('get_next_post_sort', 'pter_next_post_sort');

add_action('login_enqueue_scripts', function () { ?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(<?=get_stylesheet_directory_uri()?>/assets/img/logo-admin.png);
			height:100px;
			width:250px;
			background-size: contain;
			background-repeat: no-repeat;
			padding-bottom: 30px;
		}
		#nav {
			display: none;
		}
	</style>
	<?php
});

add_filter ('sanitize_user', function ($username, $raw_username, $strict) {
	$username = wp_strip_all_tags( $raw_username );
	$username = remove_accents( $username );
	// Kill octets
	$username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
	$username = preg_replace( '/&.+?;/', '', $username ); // Kill entities

	// 网上很多教程都是直接将$strict赋值false，
	// 这样会绕过字符串检查，留下隐患
	if ($strict) {
		$username = preg_replace ('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $username);
	}

	$username = trim( $username );
	// Consolidate contiguous whitespace
	$username = preg_replace( '|\s+|', ' ', $username );

	return $username;
}, 10, 3);

// Display User IP in WordPress

function get_the_user_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        //to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
